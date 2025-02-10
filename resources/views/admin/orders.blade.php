@extends('admin.layout')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-4 text-center">Order Management</h2>

            <!-- Field Search -->
            <div class="mb-4">
                <input type="text" id="order-search" placeholder="Search orders by ID, Customer, Type..."
                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
            </div>

            <!-- Pesan Notifikasi -->
            <div id="notification" class="hidden mb-4 p-3 rounded"></div>

            @if ($orders->isEmpty())
                <p class="text-gray-600 text-center">No orders found.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200" id="orders-table">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Order ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($orders as $order)
                                <tr id="order-row-{{ $order->id }}" class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->type }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Rp.
                                        {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <!-- Dropdown Status dengan pewarnaan dinamis -->
                                        <select class="status-dropdown p-2 border rounded focus:outline-none"
                                            data-id="{{ $order->id }}">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="approved" {{ $order->status == 'approved' ? 'selected' : '' }}>
                                                Approved</option>
                                            <option value="rejected" {{ $order->status == 'rejected' ? 'selected' : '' }}>
                                                Rejected</option>
                                            <option value="completed"
                                                {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Script JavaScript -->
    <script>
        // Fungsi untuk mengubah styling dropdown berdasarkan status
        function updateDropdownStyle(dropdown) {
            // Hapus kelas warna status sebelumnya (pastikan daftar kelas sesuai dengan Tailwind)
            dropdown.classList.remove('bg-yellow-100', 'text-yellow-700', 'bg-green-100', 'text-green-700', 'bg-red-100',
                'text-red-700', 'bg-blue-100', 'text-blue-700');
            switch (dropdown.value) {
                case 'pending':
                    dropdown.classList.add('bg-yellow-100', 'text-yellow-700');
                    break;
                case 'approved':
                    dropdown.classList.add('bg-green-100', 'text-green-700');
                    break;
                case 'rejected':
                    dropdown.classList.add('bg-red-100', 'text-red-700');
                    break;
                case 'completed':
                    dropdown.classList.add('bg-blue-100', 'text-blue-700');
                    break;
                default:
                    break;
            }
        }

        // Update styling awal untuk semua dropdown
        document.querySelectorAll('.status-dropdown').forEach(function(dropdown) {
            updateDropdownStyle(dropdown);
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Gunakan route helper dengan placeholder ":id"
            const updateUrlTemplate = "{{ route('admin.orders.update', ':id') }}";

            // Event listener untuk setiap dropdown status
            document.querySelectorAll('.status-dropdown').forEach(function(dropdown) {
                dropdown.addEventListener('change', function() {
                    const orderId = this.getAttribute('data-id');
                    const newStatus = this.value;
                    const token = '{{ csrf_token() }}';

                    // Ganti placeholder ":id" dengan nilai orderId yang sebenarnya
                    const updateUrl = updateUrlTemplate.replace(':id', orderId);

                    fetch(updateUrl, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                status: newStatus
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error("Network response was not ok");
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                showNotification('Order status updated successfully.', false);
                                updateDropdownStyle(dropdown);
                            } else {
                                showNotification('Failed to update order status.', true);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('An error occurred.', true);
                        });
                });
            });

            // Fitur Search: Filter baris tabel berdasarkan input search
            document.getElementById('order-search').addEventListener('input', function() {
                const query = this.value.toLowerCase();
                const rows = document.querySelectorAll('#orders-table tbody tr');
                rows.forEach(function(row) {
                    const rowText = row.textContent.toLowerCase();
                    row.style.display = rowText.indexOf(query) > -1 ? '' : 'none';
                });
            });
        });

        // Fungsi untuk menampilkan notifikasi
        function showNotification(message, isError = false) {
            const notificationDiv = document.getElementById('notification');
            notificationDiv.textContent = message;
            notificationDiv.className = isError ?
                'bg-red-100 text-red-700 p-3 rounded mb-4' :
                'bg-green-100 text-green-700 p-3 rounded mb-4';
            notificationDiv.classList.remove('hidden');

            setTimeout(() => {
                notificationDiv.classList.add('hidden');
            }, 3000);
        }
    </script>
@endsection
