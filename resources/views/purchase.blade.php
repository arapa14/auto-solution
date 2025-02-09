<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AutoSolution - Purchase Page</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
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
                <a href="{{ route('landing') }}" class="text-gray-600 hover:text-gray-800">Home</a>
                <a href="{{ route('purchase') }}" class="text-gray-600 hover:text-gray-800">Pembelian Alat-Alat
                    Mobil</a>
                <a href="{{ route('sale') }}" class="text-gray-600 hover:text-gray-800">Penjualan Alat-Alat Mobil</a>
                <a href="{{ route('service') }}" class="text-gray-600 hover:text-gray-800">Jasa Perbaikan Mobil</a>
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

    <!-- Bagian Content: Daftar Produk Alat-Alat Mobil -->
    <section class="container mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Daftar Produk Alat-Alat Mobil</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($products as $product)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <!-- Gambar produk -->
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                        class="w-full h-48 object-cover">

                    <!-- Detail produk -->
                    <div class="p-4">
                        <h2 class="text-xl font-semibold mb-2">{{ $product->name }}</h2>
                        <p class="text-gray-600 text-sm mb-2">
                            {{ \Illuminate\Support\Str::limit($product->description, 100) }}
                        </p>
                        <p class="text-lg font-bold text-blue-600 mb-2">
                            Rp. {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                        <p class="text-sm text-gray-500 mb-2">Stok: {{ $product->stock }}</p>
                        <p class="text-sm text-gray-500 mb-4">Kategori: {{ $product->category }}</p>
                        @guest
                            <button @click="loginModal = true"
                                class="block bg-blue-600 text-white text-center py-2 rounded hover:bg-blue-700 transition duration-200">
                                Beli Sekarang
                            </button>
                        @else
                            <a href="{{ route('product.detail', $product->id) }}"
                                class="block bg-blue-600 text-white text-center py-2 rounded hover:bg-blue-700 transition duration-200">
                                Beli Sekarang
                            </a>
                        @endguest
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center text-gray-500">
                    Belum ada produk yang tersedia.
                </div>
            @endforelse
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
                timer: 15 00,
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
                timer: 1500,
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
                timer: 1500,
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
                timer: 1500,
                showConfirmButton: false
            });
        </script>
    @endif
</body>

</html>
