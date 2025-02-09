<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Order_Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Bisa digunakan untuk menampilkan daftar produk jika diperlukan
        $products = Product::all();
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * Menampilkan halaman detail produk beserta form pemesanan.
     */
    public function show($id)
    {
        // Mengambil data produk berdasarkan ID atau gagal jika tidak ditemukan.
        $product = Product::findOrFail($id);

        // Mengembalikan view dengan data produk
        return view('product.order', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * Method ini dipakai untuk memproses pemesanan produk.
     */

     public function update(Request $request, $id)
     {
         //
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
