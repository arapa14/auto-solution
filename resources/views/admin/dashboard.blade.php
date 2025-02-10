@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-3xl font-bold mb-4">Dashboard</h1>
        <p class="text-gray-700">Welcome back, {{ auth()->user()->name }}!</p>
    </div>

    <!-- Statistik Data (dinamis) -->
    <div class="mt-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-bold mb-2">Total Products</h2>
            <p class="text-3xl font-semibold text-blue-600">{{ $totalProducts }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-bold mb-2">Total Services</h2>
            <p class="text-3xl font-semibold text-blue-600">{{ $totalServices }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-bold mb-2">Pending Orders</h2>
            <p class="text-3xl font-semibold text-blue-600">{{ $pendingOrders }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-bold mb-2">Complete Orders</h2>
            <p class="text-3xl font-semibold text-blue-600">{{ $totalComplete }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-bold mb-2">Total Sales</h2>
            <p class="text-3xl font-semibold text-blue-600">{{ $totalSales }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-bold mb-2">Total Users</h2>
            <p class="text-3xl font-semibold text-blue-600">{{ $totalUsers }}</p>
        </div>
    </div>

    <!-- Tabel Pesanan Terbaru -->
    <div class="mt-10 bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Recent Orders</h2>
        @if ($recentOrders->isEmpty())
            <p class="text-gray-600">No recent orders found.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Order ID</th>
                            <th class="px-4 py-2 text-left">Date</th>
                            <th class="px-4 py-2 text-left">Customer</th>
                            <th class="px-4 py-2 text-left">Type</th>
                            <th class="px-4 py-2 text-left">Total Price</th>
                            <th class="px-4 py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentOrders as $order)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $order->id }}</td>
                                <td class="px-4 py-2">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="px-4 py-2">{{ $order->user->name }}</td>
                                <td class="px-4 py-2">{{ $order->type }}</td>
                                <td class="px-4 py-2">Rp. {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="px-4 py-2">{{ ucfirst($order->status) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
