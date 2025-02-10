<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil order beserta data user (customer)
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.orders', compact('orders'));
    }

    /**
     * Update status order.
     */
    public function update(Request $request, $id)
    {
        // Validasi input status
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        // Mengembalikan response JSON agar bisa diproses oleh AJAX
        return response()->json(['success' => true, 'message' => 'Order status updated successfully.']);
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
     * Menampilkan detail order.
     */
    public function show($id)
    {
        // Jika terdapat relasi detail order, misalnya orderDetails
        $order = Order::with('user', 'orderDetails')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Menampilkan form edit order (jika diperlukan fitur edit selain update status).
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
