@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-5xl font-extrabold text-gray-800">Dashboard</h1>
            <p class="mt-2 text-xl text-gray-600">Selamat datang, {{ auth()->user()->name }}!</p>
        </div>

        <!-- Statistik Data - Baris 1 -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Total Produk -->
            <div
                class="bg-gradient-to-r from-blue-500 to-blue-700 text-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition duration-300">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <!-- Icon Produk -->
                        <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V5a1 1 0 00-1-1h-3V3a1 1 0 00-2 0v1H9a1 1 0 00-1 1v6M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H5a2 2 0 00-2 2v5a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="ml-6">
                        <h2 class="text-2xl font-semibold">Total Produk</h2>
                        <p class="mt-2 text-4xl font-bold">{{ $totalProducts }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Layanan -->
            <div
                class="bg-gradient-to-r from-green-500 to-green-700 text-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition duration-300">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <!-- Icon Layanan -->
                        <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317a1 1 0 00-1.45.316L7.21 7.242a1 1 0 01-.945.588H4a1 1 0 000 2h2.265a1 1 0 01.945.588l1.664 2.61a1 1 0 001.45.316 9.025 9.025 0 003.278-4.662 9.025 9.025 0 00-3.278-4.662z" />
                        </svg>
                    </div>
                    <div class="ml-6">
                        <h2 class="text-2xl font-semibold">Total Layanan</h2>
                        <p class="mt-2 text-4xl font-bold">{{ $totalServices }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Penjualan -->
            <div
                class="bg-gradient-to-r from-purple-500 to-purple-700 text-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition duration-300">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <!-- Icon Sales -->
                        <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-3.866 0-7 1.79-7 4s3.134 4 7 4 7-1.79 7-4-3.134-4-7-4z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 12c-3.866 0-7 1.79-7 4s3.134 4 7 4 7-1.79 7-4-3.134-4-7-4z" />
                        </svg>
                    </div>
                    <div class="ml-6">
                        <h2 class="text-2xl font-semibold">Total Penjualan</h2>
                        <p class="mt-2 text-4xl font-bold">Rp. {{ number_format($totalSales, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Data - Baris 2 -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-8">
            <!-- Pesanan Pending -->
            <div
                class="bg-gradient-to-r from-yellow-500 to-yellow-700 text-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition duration-300">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <!-- Icon Pending -->
                        <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-6">
                        <h2 class="text-2xl font-semibold">Pesanan Pending</h2>
                        <p class="mt-2 text-4xl font-bold">{{ $pendingOrders }}</p>
                    </div>
                </div>
            </div>

            <!-- Pesanan Selesai -->
            <div
                class="bg-gradient-to-r from-blue-500 to-blue-700 text-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition duration-300">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <!-- Icon Selesai -->
                        <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="ml-6">
                        <h2 class="text-2xl font-semibold text-gray-200">Pesanan Selesai</h2>
                        <p class="mt-2 text-4xl font-bold text-gray-100">{{ $totalComplete ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Pengguna -->
            <div
                class="bg-gradient-to-r from-red-500 to-red-700 text-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition duration-300">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <!-- Icon Users -->
                        <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m10-6a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="ml-6">
                        <h2 class="text-2xl font-semibold">Total Pengguna</h2>
                        <p class="mt-2 text-4xl font-bold">{{ $totalUsers }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Pesanan Terbaru -->
        <div class="bg-white shadow-xl rounded-xl mt-12 p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Pesanan Terbaru</h2>
            @if ($recentOrders->isEmpty())
                <p class="text-gray-600">Tidak ada pesanan terbaru.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700">
                                <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">
                                    Order ID</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">
                                    Tanggal</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">
                                    Pelanggan</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">
                                    Tipe</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">
                                    Total Harga</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300">
                            @foreach ($recentOrders as $order)
                                <tr class="hover:bg-gray-100">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->type }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Rp.
                                        {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $status = strtolower($order->status);
                                        @endphp

                                        @if ($status === 'pending')
                                            <span
                                                class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @elseif ($status === 'approved')
                                            <span
                                                class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Disetujui
                                            </span>
                                        @elseif ($status === 'rejected')
                                            <span
                                                class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                Ditolak
                                            </span>
                                        @elseif ($status === 'completed')
                                            <span
                                                class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Selesai
                                            </span>
                                        @else
                                            <span
                                                class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Sales Overview Chart -->
        <div class="bg-white shadow-xl rounded-xl mt-12 p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Sales Overview</h2>
            <canvas id="salesChart" class="w-full h-80"></canvas>
        </div>

        <!-- Laporan Penjualan Berdasarkan Periode -->
        <div class="bg-white shadow-xl rounded-xl mt-12 p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Laporan Penjualan</h2>
            <!-- Tab Navigation -->
            <ul class="flex border-b mb-4" id="salesReportTabs" role="tablist">
                <li class="-mb-px mr-1">
                    <a href="#daily"
                        class="bg-white inline-block py-2 px-4 text-blue-500 font-semibold border-l border-t border-r rounded-t"
                        id="daily-tab" role="tab" aria-controls="daily" aria-selected="true">Harian</a>
                </li>
                <li class="mr-1">
                    <a href="#weekly"
                        class="bg-white inline-block py-2 px-4 text-gray-500 hover:text-blue-500 font-semibold border-l border-t border-r rounded-t"
                        id="weekly-tab" role="tab" aria-controls="weekly" aria-selected="false">Mingguan</a>
                </li>
                <li class="mr-1">
                    <a href="#monthly"
                        class="bg-white inline-block py-2 px-4 text-gray-500 hover:text-blue-500 font-semibold border-l border-t border-r rounded-t"
                        id="monthly-tab" role="tab" aria-controls="monthly" aria-selected="false">Bulanan</a>
                </li>
                <li class="mr-1">
                    <a href="#yearly"
                        class="bg-white inline-block py-2 px-4 text-gray-500 hover:text-blue-500 font-semibold border-l border-t border-r rounded-t"
                        id="yearly-tab" role="tab" aria-controls="yearly" aria-selected="false">Tahunan</a>
                </li>
            </ul>
            <!-- Tab Content -->
            <div class="tab-content">
                <div id="daily" class="tab-pane active">
                    <canvas id="dailySalesChart" class="w-full h-80"></canvas>
                </div>
                <div id="weekly" class="tab-pane hidden">
                    <canvas id="weeklySalesChart" class="w-full h-80"></canvas>
                </div>
                <div id="monthly" class="tab-pane hidden">
                    <canvas id="monthlySalesChart" class="w-full h-80"></canvas>
                </div>
                <div id="yearly" class="tab-pane hidden">
                    <canvas id="yearlySalesChart" class="w-full h-80"></canvas>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <!-- Pastikan CDN Chart.js sudah terintegrasi -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Sales Overview Chart (sudah ada)
        const salesData = {
            labels: {!! json_encode($salesChartLabels) !!},
            datasets: [{
                label: 'Penjualan',
                data: {!! json_encode($salesChartData) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                fill: true,
            }]
        };

        const config = {
            type: 'line',
            data: salesData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        const salesChart = new Chart(
            document.getElementById('salesChart'),
            config
        );

        // Laporan Penjualan - Chart Harian
        const dailySalesChart = new Chart(
            document.getElementById('dailySalesChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($dailySalesChartLabels) !!},
                    datasets: [{
                        label: 'Penjualan Harian',
                        data: {!! json_encode($dailySalesChartData) !!},
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            }
        );

        // Laporan Penjualan - Chart Mingguan
        const weeklySalesChart = new Chart(
            document.getElementById('weeklySalesChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($weeklySalesChartLabels) !!},
                    datasets: [{
                        label: 'Penjualan Mingguan',
                        data: {!! json_encode($weeklySalesChartData) !!},
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            }
        );

        // Laporan Penjualan - Chart Bulanan
        const monthlySalesChart = new Chart(
            document.getElementById('monthlySalesChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($monthlySalesChartLabels) !!},
                    datasets: [{
                        label: 'Penjualan Bulanan',
                        data: {!! json_encode($monthlySalesChartData) !!},
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            }
        );

        // Laporan Penjualan - Chart Tahunan
        const yearlySalesChart = new Chart(
            document.getElementById('yearlySalesChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($yearlySalesChartLabels) !!},
                    datasets: [{
                        label: 'Penjualan Tahunan',
                        data: {!! json_encode($yearlySalesChartData) !!},
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            }
        );

        // Logika untuk switch tab pada Laporan Penjualan
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('#salesReportTabs a');
            const tabPanes = document.querySelectorAll('.tab-pane');

            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Hilangkan style aktif dari seluruh tab dan sembunyikan konten
                    tabs.forEach(t => t.classList.remove('text-blue-500', 'border-blue-500'));
                    tabPanes.forEach(pane => {
                        pane.classList.add('hidden');
                        pane.classList.remove('active');
                    });
                    // Aktifkan tab yang diklik dan tampilkan konten terkait
                    this.classList.add('text-blue-500', 'border-blue-500');
                    const targetId = this.getAttribute('href').substring(1);
                    const targetPane = document.getElementById(targetId);
                    targetPane.classList.remove('hidden');
                    targetPane.classList.add('active');
                });
            });
        });
    </script>
@endsection
