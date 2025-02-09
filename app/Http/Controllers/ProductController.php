<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_Product;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * Mengambil semua produk dan mengopernya ke view admin.product.
     */
    public function index()
    {
        $products = Product::all();
        $totalProducts = $products->count();
        return view('admin.product', compact('products', 'totalProducts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * Menyimpan produk baru berdasarkan data yang dikirim via AJAX.
     */
    public function store(Request $request)
    {
        // Validasi input, gunakan aturan 'image' untuk file image
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category'    => 'required|string|max:255',
            'image'       => 'required|image|max:2048', // maksimal 2MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            $product = new Product();
            $product->name        = $request->name;
            $product->description = $request->description;
            $product->price       = $request->price;
            $product->stock       = $request->stock;
            $product->category    = $request->category;

            if ($request->hasFile('image')) {
                // Simpan file image ke disk 'public' dalam folder 'products'
                $path = $request->file('image')->store('products', 'public');
                // Simpan hanya path relatif ke database
                $product->image = $path;
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No image file provided.'
                ]);
            }

            $product->save();

            return response()->json([
                'success' => true,
                'message' => 'Product added successfully!',
                'product' => $product
            ]);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Failed to add product.'
            ]);
        }
    }

    public function show($id)
    {
        // Mengambil data produk berdasarkan ID atau gagal jika tidak ditemukan.
        $product = Product::findOrFail($id);

        // Mengembalikan view dengan data produk
        return view('product.order', compact('product'));
    }


    /**
     * Update the specified resource in storage.
     *
     * Mengupdate produk berdasarkan data yang dikirim via AJAX.
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category'    => 'required|string|max:255',
            'image'       => $request->hasFile('image') ? 'required|image|max:2048' : 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            if ($request->hasFile('image')) {
                // Simpan file baru dan dapatkan path relatif
                $path = $request->file('image')->store('products', 'public');
                $imagePath = $path;
            } else {
                // Gunakan nilai image yang sudah ada
                $imagePath = $product->image;
            }

            // Update produk dengan data request dan path image yang sesuai
            $product->update(array_merge(
                $request->only(['name', 'description', 'price', 'stock', 'category']),
                ['image' => $imagePath]
            ));

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully!',
                'product' => $product
            ]);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product.'
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * Menghapus produk dan mengembalikan respons JSON.
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully!'
            ]);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Error deleting product: ' . $e->getMessage()
            ]);
        }
    }



    public function order(Request $request, $id)
    {
        // Validasi data input, misalnya jumlah pemesanan (quantity) minimal 1
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Ambil data produk
        $product = Product::findOrFail($id);

        // Periksa apakah stok mencukupi
        if ($request->quantity > $product->stock) {
            return redirect()->back()
                ->with('error', 'Stok produk tidak mencukupi untuk jumlah yang diminta.');
        }

        // Hitung total harga pesanan
        $totalPrice = $product->price * $request->quantity;

        // Bungkus operasi dalam sebuah transaksi untuk menjaga integritas data
        DB::transaction(function () use ($request, $product, $totalPrice) {
            // Membuat record Order
            $order = Order::create([
                'user_id'     => auth()->id(),       // Pastikan user telah login
                'type'        => 'pembelian',
                'status'      => 'pending',          // Status awal pesanan, misalnya 'pending'
                'total_price' => $totalPrice,
                'description' => 'Pesanan produk ' . $product->name,
            ]);

            // Membuat record Order_Product yang mengaitkan order dengan produk
            Order_Product::create([
                'order_id'    => $order->id,
                'product_id'  => $product->id,
                'qty'         => $request->quantity,
                'price_unit'  => $product->price,
                'total_price' => $totalPrice,
            ]);

            // Mengurangi stok produk
            $product->stock -= $request->quantity;
            $product->save();
        });

        // Set flash message notifikasi sukses
        session()->flash('success', 'Pesanan untuk produk ' . $product->name . ' berhasil dibuat!');

        // Redirect kembali ke halaman detail produk atau ke halaman konfirmasi sesuai kebutuhan
        return redirect()->route('product.detail', $id);
    }
}
