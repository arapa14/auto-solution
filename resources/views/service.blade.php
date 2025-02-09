@extends('layouts.app')

@section('title', 'Pesan Service - AutoSolution')

@section('content')
    <!-- Bagian untuk menampilkan service yang sudah dipesan (hanya jika user login) -->
    @auth
        <section class="container mx-auto py-10 px-4">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Service yang Sudah Dipesan</h2>
            @if ($orders->isEmpty())
                <p class="text-gray-600">Anda belum memesan service.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($orders as $order)
                        @foreach ($order->order_services as $serviceProduct)
                            <div class="bg-white rounded-lg shadow overflow-hidden">
                                <div class="p-4">
                                    <h3 class="text-xl font-semibold mb-2">{{ $serviceProduct->service->name }}</h3>
                                    <p class="text-gray-600 text-sm mb-2">
                                        {{ \Illuminate\Support\Str::limit($serviceProduct->service->description, 100) }}
                                    </p>
                                    <p class="text-lg font-bold text-blue-600 mb-2">Rp.
                                        {{ number_format($serviceProduct->price_unit, 0, ',', '.') }}</p>
                                    <p class="text-sm text-gray-500 mb-2">Duration: {{ $serviceProduct->service->duration }}</p>
                                    <p class="text-sm text-gray-500 mb-2">Status: {{ ucfirst($order->status) }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            @endif
        </section>
    @endauth

    <!-- Daftar Service -->
    <section class="container mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Daftar Service Bengkel</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($services as $service)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-4">
                        <h2 class="text-xl font-semibold mb-2">{{ $service->name }}</h2>
                        <p class="text-gray-600 text-sm mb-2">
                            {{ \Illuminate\Support\Str::limit($service->description, 100) }}</p>
                        <p class="text-lg font-bold text-blue-600 mb-2">Rp. {{ $service->price }}</p>
                        <p class="text-sm text-gray-500 mb-2">Duration: {{ $service->duration }} menit</p>
                        {{-- @guest
                            <button @click="loginModal = true"
                                class="block bg-blue-600 text-white text-center py-2 rounded hover:bg-blue-700 transition duration-200">
                                Pesan Service
                            </button>
                        @else
                            <form action="{{ route('service.detail', ['id' => $service->id]) }}">
                                @csrf
                                <!-- Jika ada input tambahan, masukkan di sini -->
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                    Pesan Service
                                </button>
                            </form>
                        @endguest --}}
                        @guest
                            <button @click="loginModal = true"
                                class="block bg-blue-600 text-white text-center py-2 rounded hover:bg-blue-700 transition duration-200">
                                Beli Sekarang
                            </button>
                        @else
                            <a href="{{ route('service.detail', $service->id) }}"
                                class="block bg-blue-600 text-white text-center py-2 rounded hover:bg-blue-700 transition duration-200">
                                Beli Sekarang
                            </a>
                        @endguest

                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center text-gray-500">Belum ada service yang tersedia.</div>
            @endforelse
        </div>
    </section>
@endsection
