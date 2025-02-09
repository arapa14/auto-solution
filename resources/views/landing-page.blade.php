@extends('layouts.app')

@section('title', 'AutoSolution - Solution in One')

@section('content')
<!-- Hero Section -->
    <section class="bg-gray-100">
        <div
            class="container mx-auto px-4 py-20 flex flex-col items-center text-center md:text-left md:flex-row md:justify-center">
            <div class="md:w-3/4 lg:w-1/2">
                <h1 class="text-4xl font-bold text-gray-800 mb-4">
                    Solusi All-In-One Perawatan & Servis Mobil
                </h1>
                <p class="text-gray-600 mb-6">
                    Nikmati kemudahan dalam pembelian sparepart, penjualan, dan jasa perbaikan mobil dengan platform
                    kami yang cepat, mudah, dan terpercaya.
                </p>
                <div class="flex justify-center md:justify-start">
                    <a href="/pembelian"
                        class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition duration-300">
                        Mulai Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Tentang -->
    <section id="tentang" class="container mx-auto px-4 py-20">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800">Tentang BengkelExpress</h2>
            <p class="text-gray-600 mt-4">
                Platform yang mengintegrasikan layanan pembelian sparepart, penjualan, dan jasa perbaikan dalam satu
                aplikasi yang mudah digunakan.
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="text-blue-600 mb-4">
                    <!-- Icon sederhana -->
                    <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m0-4h.01M12 3v1m0 16v1m8-9h1m-16 0h1"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2 text-center">Mudah Digunakan</h3>
                <p class="text-gray-600 text-center">Antarmuka yang intuitif untuk memudahkan setiap transaksi.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="text-blue-600 mb-4">
                    <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-3-3v6m4.5 3H5.5a2.5 2.5 0 01-2.5-2.5V5.5A2.5 2.5 0 015.5 3h13a2.5 2.5 0 012.5 2.5v13a2.5 2.5 0 01-2.5 2.5z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2 text-center">Terintegrasi</h3>
                <p class="text-gray-600 text-center">Semua layanan bengkel tersedia dalam satu platform, mulai dari
                    sparepart hingga servis.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="text-blue-600 mb-4">
                    <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7l1.664-1.664a9 9 0 1112.672 0L21 7"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2 text-center">Cepat & Efisien</h3>
                <p class="text-gray-600 text-center">Layanan responsif dan cepat untuk memenuhi kebutuhan perawatan
                    mobil Anda.</p>
            </div>
        </div>
    </section>

    <!-- Section Fitur -->
    <section id="fitur" class="bg-blue-50 py-20">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Fitur Unggulan</h2>
                <p class="text-gray-600 mt-4">Jelajahi berbagai fitur yang membuat layanan kami semakin istimewa.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Pembelian Sparepart</h3>
                    <p class="text-gray-600">Temukan berbagai sparepart berkualitas untuk kendaraan Anda dengan harga
                        kompetitif.</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Penjualan Mobil</h3>
                    <p class="text-gray-600">Jual mobil bekas atau sparepart dengan mudah melalui platform kami yang
                        terpercaya.</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Jasa Perbaikan</h3>
                    <p class="text-gray-600">Dapatkan layanan servis dan perbaikan mobil yang cepat dan profesional.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection

