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
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Tambahan styling untuk modal overlay (jika diperlukan) */
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body x-data="{ loginModal: false, registerModal: false }" class="font-sans antialiased">
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
                @auth
                    <!-- Jika sudah login, tampilkan tombol Logout -->
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-800 focus:outline-none">
                            Logout
                        </button>
                    </form>
                @else
                    <!-- Jika belum login, tampilkan tombol Login/Register -->
                    <button @click="loginModal = true" class="text-gray-600 hover:text-gray-800 focus:outline-none">
                        Login/Register
                    </button>
                @endauth
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
                    @auth
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-gray-600 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <li>
                            <button @click="loginModal = true; open = false"
                                class="block w-full text-left px-4 py-2 text-gray-600 hover:bg-gray-100">
                                Login/Register
                            </button>
                        </li>
                    @endauth
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

    <!-- Footer -->
    <footer class="bg-gray-800 py-6">
        <div class="container mx-auto px-4 text-center text-gray-300">
            <p>&copy; {{ date('Y') }} BengkelExpress. All rights reserved.</p>
        </div>
    </footer>

    <!-- Modal Login (menggunakan Tailwind CSS & Alpine.js) -->
    <div x-show="loginModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-900 opacity-50" @click="loginModal = false"></div>
        <!-- Modal Content -->
        <div class="bg-white rounded-lg shadow-lg z-50 p-6 w-full max-w-md mx-auto">
            <h2 class="text-2xl font-bold mb-4">Login</h2>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="login_email">Email</label>
                    <input type="email" name="email" id="login_email" required
                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="login_password">Password</label>
                    <input type="password" name="password" id="login_password" required
                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200">
                        Login
                    </button>
                    <button type="button" @click="loginModal = false"
                        class="text-gray-600 hover:text-gray-800 focus:outline-none">
                        Batal
                    </button>
                </div>
            </form>
            <p class="mt-4 text-sm text-blue-600 cursor-pointer" @click="loginModal = false; registerModal = true;">
                Belum punya akun? Register</p>
        </div>
    </div>

    <!-- Modal Register (menggunakan Tailwind CSS & Alpine.js) -->
    <div x-show="registerModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-900 opacity-50" @click="registerModal = false"></div>
        <!-- Modal Content -->
        <div class="bg-white rounded-lg shadow-lg z-50 p-6 w-full max-w-md mx-auto">
            <h2 class="text-2xl font-bold mb-4">Register</h2>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nama</label>
                    <input type="text" name="name" id="name" required
                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="register_email">Email</label>
                    <input type="email" name="email" id="register_email" required
                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="register_password">Password</label>
                    <input type="password" name="password" id="register_password" required
                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">Konfirmasi
                        Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">Nomor Telepon</label>
                    <input type="text" name="phone" id="phone" required
                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="address">Alamat</label>
                    <textarea name="address" id="address" required
                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300"></textarea>
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200">
                        Register
                    </button>
                    <button type="button" @click="registerModal = false"
                        class="text-gray-600 hover:text-gray-800 focus:outline-none">
                        Batal
                    </button>
                </div>
            </form>
            <p class="mt-4 text-sm text-blue-600 cursor-pointer" @click="registerModal = false; loginModal = true;">
                Sudah punya akun? Login</p>
        </div>
    </div>

    <!-- Notifikasi SweetAlert2 berdasarkan flash session -->
    @if (session('success_register'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Pendaftaran Berhasil',
                text: '{{ session('success_register') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('success_login'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Login Berhasil',
                text: '{{ session('success_login') }}',
                timer: 1000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('success_logout'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Logout Berhasil',
                text: '{{ session('success_logout') }}',
                timer: 1000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: '{{ session('error') }}',
                timer: 1000,
                showConfirmButton: false
            });
        </script>
    @endif

</body>

</html>
