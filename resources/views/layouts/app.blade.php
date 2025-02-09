<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'AutoSolution')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Tambahan styling untuk modal overlay */
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
                <a href="{{ route('landing') }}"
                    class="{{ request()->routeIs('landing') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-gray-800' }}">
                    Home
                </a>
                <a href="{{ route('purchase') }}"
                    class="{{ request()->routeIs('purchase') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-gray-800' }}">
                    Alat-Alat Mobil
                </a>
                <a href="{{ route('service') }}"
                    class="{{ request()->routeIs('service') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-gray-800' }}">
                    Jasa Perbaikan Mobil
                </a>
                @auth
                    <!-- Jika admin sudah switch, tampilkan tombol Switch Back -->
                    @if (session()->has('original_user_id'))
                        <a href="{{ route('switch-back') }}"
                            class="text-green-600 hover:text-green-800 border-b-2 border-green-600">
                            Switch Back
                        </a>
                    @endif
                    <!-- Jika sudah login, tampilkan tombol Logout -->
                    <form action="{{ route('logout') }}" method="POST" class="inline">
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
                <button @click="open = !open" class="text-gray-800 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <ul x-show="open" @click.away="open = false"
                    class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg z-50" x-cloak>
                    <li>
                        <a href="{{ route('landing') }}"
                            class="block px-4 py-2 {{ request()->routeIs('landing') ? 'text-blue-600 bg-gray-100' : 'text-gray-600 hover:bg-gray-100' }}">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('purchase') }}"
                            class="block px-4 py-2 {{ request()->routeIs('purchase') ? 'text-blue-600 bg-gray-100' : 'text-gray-600 hover:bg-gray-100' }}">
                            Alat-Alat Mobil
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('service') }}"
                            class="block px-4 py-2 {{ request()->routeIs('service') ? 'text-blue-600 bg-gray-100' : 'text-gray-600 hover:bg-gray-100' }}">
                            Jasa Perbaikan Mobil
                        </a>
                    </li>
                    @auth
                        <li>
                            <!-- Jika admin sudah switch, tampilkan tombol Switch Back -->
                            @if (session()->has('original_user_id'))
                                <a href="{{ route('switch-back') }}"
                                    class="text-green-600 hover:text-green-800 border-b-2 border-green-600">
                                    Switch Back
                                </a>
                            @endif
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

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 py-6">
        <div class="container mx-auto px-4 text-center text-gray-300">
            <p>&copy; {{ date('Y') }} BengkelExpress. All rights reserved.</p>
        </div>
    </footer>

    <!-- Modal Login -->
    <div x-show="loginModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
        <div class="fixed inset-0 bg-gray-900 opacity-50" @click="loginModal = false"></div>
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
                Belum punya akun? Register
            </p>
        </div>
    </div>

    <!-- Modal Register -->
    <div x-show="registerModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-900 opacity-50" @click="registerModal = false"></div>
        <!-- Modal Content -->
        <div class="bg-white rounded-lg shadow-lg z-50 p-6 w-full max-w-md mx-auto">
            <h2 class="text-2xl font-bold mb-4">Register</h2>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama</label>
                    <input type="text" name="name" id="name" required
                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
                </div>
                <div class="mb-4">
                    <label for="register_email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" id="register_email" required
                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
                </div>
                <div class="mb-4">
                    <label for="register_password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" name="password" id="register_password" required
                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Konfirmasi
                        Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Nomor Telepon</label>
                    <input type="text" name="phone" id="phone" required
                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
                </div>
                <div class="mb-4">
                    <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Alamat</label>
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
                Sudah punya akun? Login
            </p>
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
    <!-- Notifikasi atau Script Tambahan -->
    @yield('scripts')
</body>

</html>
