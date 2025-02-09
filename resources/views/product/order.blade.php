@extends('layouts.app')

@section('title', 'Pesan Produk ' . $product->name)

@section('content')
<section class="container mx-auto py-10 px-4">
    <div class="flex flex-col md:flex-row">
        <!-- Gambar Produk -->
        <div class="md:w-1/2">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                 class="w-full h-auto object-cover rounded-lg shadow">
        </div>
        <!-- Detail Produk & Form Pemesanan -->
        <div class="md:w-1/2 md:pl-10 mt-6 md:mt-0">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $product->name }}</h1>
            <p class="text-gray-600 mb-4">{{ $product->description }}</p>
            <p class="text-xl font-bold text-blue-600 mb-2">
                Rp. {{ number_format($product->price, 0, ',', '.') }}
            </p>
            <p class="text-sm text-gray-500 mb-4">Stok: {{ $product->stock }}</p>

            <!-- Form Pemesanan -->
            <form action="{{ route('product.order', $product->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="quantity" class="block text-gray-700 font-bold mb-2">Jumlah Pesanan:</label>
                    <input type="number" name="quantity" id="quantity" min="1" value="1"
                           class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
                </div>
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition duration-200">
                    Pesan Sekarang
                </button>
            </form>
        </div>
    </div>
</section>
@endsection

@section('scripts')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Pemesanan Berhasil',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Pemesanan Gagal',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif
@endsection
