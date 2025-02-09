@extends('layouts.app')

@section('title', 'AutoSolution - Product')

@section('content')
<!-- Bagian untuk menampilkan produk yang sudah dipesan (hanya jika user login) -->
@auth
<section class="container mx-auto py-10 px-4">
    <h2 class="text-3xl font-bold text-gray-800 mb-8">Produk yang Sudah Dipesan</h2>
    @if($orders->isEmpty())
        <p class="text-gray-600">Anda belum memesan barang.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($orders as $order)
                @foreach ($order->order_products as $orderProduct)
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <!-- Gambar produk yang dipesan -->
                        <img src="{{ asset('storage/' . $orderProduct->product->image) }}" alt="{{ $orderProduct->product->name }}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="text-xl font-semibold mb-2">{{ $orderProduct->product->name }}</h3>
                            <p class="text-gray-600 text-sm mb-2">Jumlah: {{ $orderProduct->qty }}</p>
                            <p class="text-lg font-bold text-blue-600 mb-2">
                                Total: Rp. {{ number_format($orderProduct->total_price, 0, ',', '.') }}
                            </p>
                            <p class="text-sm text-gray-500 mb-2">Status: {{ ucfirst($order->status) }}</p>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    @endif
</section>
@endauth

<!-- Daftar Produk -->
<section class="container mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Daftar Produk Alat-Alat Mobil</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($products as $product)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <!-- Gambar produk -->
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                <!-- Detail produk -->
                <div class="p-4">
                    <h2 class="text-xl font-semibold mb-2">{{ $product->name }}</h2>
                    <p class="text-gray-600 text-sm mb-2">{{ \Illuminate\Support\Str::limit($product->description, 100) }}</p>
                    <p class="text-lg font-bold text-blue-600 mb-2">Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-500 mb-2">Stok: {{ $product->stock }}</p>
                    <p class="text-sm text-gray-500 mb-4">Kategori: {{ $product->category }}</p>
                    @guest
                        <button @click="loginModal = true" class="block bg-blue-600 text-white text-center py-2 rounded hover:bg-blue-700 transition duration-200">
                            Beli Sekarang
                        </button>
                    @else
                        <a href="{{ route('product.detail', $product->id) }}" class="block bg-blue-600 text-white text-center py-2 rounded hover:bg-blue-700 transition duration-200">
                            Beli Sekarang
                        </a>
                    @endguest
                </div>
            </div>
        @empty
            <div class="col-span-4 text-center text-gray-500">Belum ada produk yang tersedia.</div>
        @endforelse
    </div>
</section>


@endsection
