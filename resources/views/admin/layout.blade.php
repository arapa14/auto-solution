<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard - BengkelExpress | @yield('title')</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
        <!-- Mobile Sidebar (Slide-in) -->
        <div x-show="sidebarOpen" class="fixed inset-0 flex z-40 md:hidden" role="dialog" aria-modal="true" x-cloak>
            <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50"
                aria-hidden="true"></div>
            <div x-show="sidebarOpen" class="relative flex-1 flex flex-col max-w-xs w-full bg-white"
                x-transition:enter="transition ease-in-out duration-300" x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button @click="sidebarOpen = false"
                        class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:bg-gray-600">
                        <span class="sr-only">Close sidebar</span>
                        <svg class="h-6 w-6 text-white" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-800">BengkelExpress Admin</h2>
                </div>
                <nav class="mt-6 flex-1">
                    <a href="{{ route('admin.dashboard') }}"
                        class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-600 font-semibold' : 'hover:bg-blue-100 hover:text-blue-700 text-gray-700' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.products') }}"
                        class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.products') ? 'bg-blue-100 text-blue-600 font-semibold' : 'hover:bg-blue-100 hover:text-blue-700 text-gray-700' }}">
                        Manage Products
                    </a>
                    <a href="{{ route('admin.orders') }}"
                        class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.orders') ? 'bg-blue-100 text-blue-600 font-semibold' : 'hover:bg-blue-100 hover:text-blue-700 text-gray-700' }}">
                        Manage Orders
                    </a>
                    <a href="{{ route('admin.sales') }}"
                        class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.sales') ? 'bg-blue-100 text-blue-600 font-semibold' : 'hover:bg-blue-100 hover:text-blue-700 text-gray-700' }}">
                        Manage Sales
                    </a>
                    <a href="{{ route('admin.services') }}"
                        class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.services') ? 'bg-blue-100 text-blue-600 font-semibold' : 'hover:bg-blue-100 hover:text-blue-700 text-gray-700' }}">
                        Manage Services
                    </a>
                    <a href="{{ route('admin.users') }}"
                        class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.users') ? 'bg-blue-100 text-blue-600 font-semibold' : 'hover:bg-blue-100 hover:text-blue-700 text-gray-700' }}">
                        User Management
                    </a>
                    <a href="{{ route('admin.reports') }}"
                        class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.reports') ? 'bg-blue-100 text-blue-600 font-semibold' : 'hover:bg-blue-100 hover:text-blue-700 text-gray-700' }}">
                        Reports
                    </a>
                </nav>
                <div class="p-4">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700 transition duration-200">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Static Sidebar for Desktop -->
        <aside class="hidden md:flex md:flex-col md:w-64 bg-white shadow-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800">BengkelExpress Admin</h2>
            </div>
            <nav class="mt-6 flex-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-600 font-semibold' : 'hover:bg-blue-100 hover:text-blue-700 text-gray-700' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.products') }}"
                    class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.products') ? 'bg-blue-100 text-blue-600 font-semibold' : 'hover:bg-blue-100 hover:text-blue-700 text-gray-700' }}">
                    Manage Products
                </a>
                <a href="{{ route('admin.orders') }}"
                    class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.orders') ? 'bg-blue-100 text-blue-600 font-semibold' : 'hover:bg-blue-100 hover:text-blue-700 text-gray-700' }}">
                    Manage Orders
                </a>
                <a href="{{ route('admin.sales') }}"
                    class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.sales') ? 'bg-blue-100 text-blue-600 font-semibold' : 'hover:bg-blue-100 hover:text-blue-700 text-gray-700' }}">
                    Manage Sales
                </a>
                <a href="{{ route('admin.services') }}"
                    class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.services') ? 'bg-blue-100 text-blue-600 font-semibold' : 'hover:bg-blue-100 hover:text-blue-700 text-gray-700' }}">
                    Manage Services
                </a>
                <a href="{{ route('admin.users') }}"
                    class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.users') ? 'bg-blue-100 text-blue-600 font-semibold' : 'hover:bg-blue-100 hover:text-blue-700 text-gray-700' }}">
                    User Management
                </a>
                <a href="{{ route('admin.reports') }}"
                    class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.reports') ? 'bg-blue-100 text-blue-600 font-semibold' : 'hover:bg-blue-100 hover:text-blue-700 text-gray-700' }}">
                    Reports
                </a>
            </nav>
            <div class="p-4">
                <form action="{{ route('logout') }}" method="POST" onsubmit="localStorage.removeItem('modalShown');">
                    @csrf
                    <button type="submit"
                        class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700 transition duration-200">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Mobile Header -->
            <header class="flex items-center justify-between bg-white p-4 shadow md:hidden">
                <button @click="sidebarOpen = true" class="text-gray-800 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h2 class="text-xl font-bold text-gray-800">Dashboard</h2>
                <div></div>
            </header>
            <main class="flex-1 p-6 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Modal Notifikasi Login Berhasil (Tampilkan hanya sekali per login) -->
    @if (session('success_login'))
        <script>
            // Cek apakah flag sudah ada di localStorage
            if (!localStorage.getItem('modalShown')) {
                Swal.fire({
                    icon: 'success',
                    title: 'Login Berhasil',
                    text: '{{ session('success_login') }}',
                    timer: 2000,
                    showConfirmButton: false
                });
                // Set flag agar modal tidak muncul lagi pada refresh
                localStorage.setItem('modalShown', true);
            }
        </script>
    @endif


    @yield('scripts')
</body>

</html>
