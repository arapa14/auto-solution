<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AutoSolution - Solusi All-In-One Perawatan Mobil</title>
    <!-- Pastikan file CSS Tailwind sudah ter-compile dan tersambung -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Alpine.js untuk interaktivitas -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<!-- Gunakan Alpine.js di level body untuk mengatur modal login/register -->

<body x-data="{ showModal: false, isLogin: true }" class="font-sans antialiased">
    <!-- Header / Navbar -->
    <header class="bg-white shadow">
        <div class="container mx-auto px-4 py-6 flex items-center justify-between">
            <div class="text-2xl font-bold text-gray-800">
                BengkelExpress
            </div>
            <!-- Navigasi Desktop -->
            <nav class="hidden md:flex space-x-6">
                <a href="/pembelian" class="text-gray-600 hover:text-gray-800">Pembelian Alat-Alat Mobil</a>
                <a href="/penjualan" class="text-gray-600 hover:text-gray-800">Penjualan Alat-Alat Mobil</a>
                <a href="/jasa-perbaikan" class="text-gray-600 hover:text-gray-800">Jasa Perbaikan Mobil</a>
                <button @click="showModal = true; isLogin = true"
                    class="text-gray-600 hover:text-gray-800 focus:outline-none">
                    Login/Register
                </button>
            </nav>
            <!-- Mobile Menu -->
            <div x-data="{ open: false }" class="md:hidden relative">
                <!-- Tombol hamburger -->
                <button @click="open = !open" class="text-gray-800 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <!-- Menu dropdown -->
                <ul x-show="open" @click.away="open = false"
                    class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg z-50" x-cloak>
                    <li>
                        <a href="/pembelian" class="block px-4 py-2 text-gray-600 hover:bg-gray-100">
                            Pembelian Alat-Alat Mobil
                        </a>
                    </li>
                    <li>
                        <a href="/penjualan" class="block px-4 py-2 text-gray-600 hover:bg-gray-100">
                            Penjualan Alat-Alat Mobil
                        </a>
                    </li>
                    <li>
                        <a href="/jasa-perbaikan" class="block px-4 py-2 text-gray-600 hover:bg-gray-100">
                            Jasa Perbaikan Mobil
                        </a>
                    </li>
                    <li>
                        <button @click="showModal = true; isLogin = true; open = false"
                            class="block w-full text-left px-4 py-2 text-gray-600 hover:bg-gray-100">
                            Login/Register
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </header>

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

    <!-- Contoh Section Lain (Tentang, Fitur, Hubungi, dll.) -->
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

    <!-- Footer -->
    <footer class="bg-gray-800 py-6">
        <div class="container mx-auto px-4 text-center text-gray-300">
            <p>&copy; {{ date('Y') }} BengkelExpress. All rights reserved.</p>
        </div>
    </footer>

    <!-- Modal Login/Register -->
    <div x-show="showModal" class="fixed inset-0 flex items-center justify-center z-50" x-cloak>
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <!-- Modal Container -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden z-50 max-w-md w-full">
            <!-- Header Modal -->
            <div class="p-4 flex justify-between items-center border-b">
                <h2 class="text-xl font-bold" x-text="isLogin ? 'Login' : 'Register'"></h2>
                <button @click="showModal = false"
                    class="text-gray-600 hover:text-gray-800 text-2xl leading-none">&times;</button>
            </div>
            <!-- Body Modal -->
            <div class="p-4">
                <!-- Tampilkan Semua Error Jika Ada -->
                @if ($errors->any())
                    <div class="bg-red-500 text-white p-3 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Tab Navigation -->
                <div class="mb-4 flex">
                    <button @click="isLogin = true"
                        :class="{ 'border-b-2 border-blue-600 text-blue-600': isLogin, 'text-gray-600': !isLogin }"
                        class="flex-1 py-2 text-center focus:outline-none">
                        Login
                    </button>
                    <button @click="isLogin = false"
                        :class="{ 'border-b-2 border-blue-600 text-blue-600': !isLogin, 'text-gray-600': isLogin }"
                        class="flex-1 py-2 text-center focus:outline-none">
                        Register
                    </button>
                </div>

                <!-- Form Login -->
                <form action="{{ route('login') }}" method="POST" x-show="isLogin" @submit.prevent="$el.submit()"
                    x-cloak>
                    @csrf
                    <div class="mb-4">
                        <label for="loginEmail" class="block text-gray-700 font-semibold">Email</label>
                        <input type="email" id="loginEmail" name="email"
                            class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Email" required>
                    </div>
                    <div class="mb-4">
                        <label for="loginPassword" class="block text-gray-700 font-semibold">Password</label>
                        <input type="password" id="loginPassword" name="password"
                            class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Password" required>
                    </div>
                    <div class="text-right">
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
                            Login
                        </button>
                    </div>
                </form>

                <!-- Form Register -->
                <form action="{{ route('register') }}" method="POST" x-show="!isLogin"
                    @submit.prevent="$el.submit()" x-cloak>
                    @csrf
                    <div class="mb-4">
                        <label for="registerName" class="block text-gray-700 font-semibold">Nama</label>
                        <input type="text" id="registerName" name="name"
                            class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Nama" required>
                    </div>
                    <div class="mb-4">
                        <label for="registerEmail" class="block text-gray-700 font-semibold">Email</label>
                        <input type="email" id="registerEmail" name="email"
                            class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Email" required>
                    </div>
                    <div class="mb-4">
                        <label for="registerPassword" class="block text-gray-700 font-semibold">Password</label>
                        <input type="password" id="registerPassword" name="password"
                            class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Password" required>
                    </div>
                    <div class="mb-4">
                        <label for="registerPhone" class="block text-gray-700 font-semibold">Nomor Telepon</label>
                        <input type="text" id="registerPhone" name="phone"
                            class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Nomor Telepon" required>
                    </div>
                    <div class="mb-4">
                        <label for="registerAddress" class="block text-gray-700 font-semibold">Alamat</label>
                        <textarea id="registerAddress" name="address"
                            class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Alamat" rows="3" required></textarea>
                    </div>
                    <div class="text-right">
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
                            Register
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</body>

</html>
