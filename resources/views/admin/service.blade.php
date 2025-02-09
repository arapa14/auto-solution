@extends('admin.layout')

@section('title', 'Manage Services')

@section('content')
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md mt-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Service Management</h2>
            <button id="openAddServiceBtn"
                class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-3 rounded-md shadow-md flex items-center gap-2">
                <i class="fas fa-plus"></i> Add New Service
            </button>
        </div>

        <!-- Add Service Modal -->
        <div id="addServiceModal"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50 overflow-y-auto">
            <div class="bg-white p-6 rounded-lg w-full max-w-lg mx-4 my-8">
                <h2 class="text-2xl font-bold mb-4">Add New Service</h2>
                <form id="addServiceForm">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label for="newServiceName" class="block text-gray-700 font-semibold mb-1">Service Name</label>
                            <input type="text" name="name" id="newServiceName"
                                class="w-full border border-gray-300 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label for="newServiceDescription"
                                class="block text-gray-700 font-semibold mb-1">Description</label>
                            <textarea name="description" id="newServiceDescription"
                                class="w-full border border-gray-300 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                        </div>
                        <div>
                            <label for="newServicePrice" class="block text-gray-700 font-semibold mb-1">Price</label>
                            <input type="text" name="price" id="newServicePrice"
                                class="w-full border border-gray-300 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label for="newServiceDuration" class="block text-gray-700 font-semibold mb-1">Duration</label>
                            <input type="text" name="duration" id="newServiceDuration"
                                class="w-full border border-gray-300 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                    </div>
                    <div class="flex justify-end mt-6">
                        <button type="button" id="cancelAddService"
                            class="mr-3 px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-100">Cancel</button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-md hover:bg-blue-600">Add
                            Service</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Search Field -->
        <div class="mb-6">
            <input type="text" id="searchServiceInput" placeholder="Search service..."
                class="w-full border border-gray-300 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Total Services Info -->
        <div class="mb-4">
            <p class="text-gray-700 font-medium">Total Services: <span id="totalServices">{{ $services->count() }}</span>
            </p>
        </div>

        <!-- Service Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" id="serviceTable">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Description</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="serviceTableBody">
                    @foreach ($services as $service)
                        <tr data-id="{{ $service->id }}">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $service->id }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $service->name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $service->description }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $service->price }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $service->duration }} menit</td>
                            <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium space-x-1">
                                <button
                                    class="editServiceBtn bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-md shadow-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button
                                    class="deleteServiceBtn bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md shadow-sm">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Global variable to store service data
        let services = @json($services);

        // Render services in the table dynamically
        function renderServices() {
            const tbody = document.getElementById('serviceTableBody');
            tbody.innerHTML = '';
            services.forEach(service => {
                const tr = document.createElement('tr');
                tr.setAttribute('data-id', service.id);
                tr.classList.add('divide-y', 'divide-gray-200');
                tr.innerHTML = `
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${service.id}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${service.name}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${service.description}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${service.price}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${service.duration}</td>
                <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium space-x-1">
                    <button class="editServiceBtn bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-md shadow-sm">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="deleteServiceBtn bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md shadow-sm">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </td>
            `;
                tbody.appendChild(tr);
            });
        }

        // Update total services count
        function updateTotalServices() {
            document.getElementById('totalServices').textContent = services.length;
        }

        // Search functionality for services
        document.getElementById('searchServiceInput').addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('#serviceTableBody tr');
            rows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                row.style.display = rowText.includes(filter) ? '' : 'none';
            });
        });

        // Modal Elements for Add Service
        const openAddServiceBtn = document.getElementById('openAddServiceBtn');
        const addServiceModal = document.getElementById('addServiceModal');
        const cancelAddServiceBtn = document.getElementById('cancelAddService');
        const addServiceForm = document.getElementById('addServiceForm');

        // Open Add Service Modal
        openAddServiceBtn.addEventListener('click', function() {
            addServiceModal.classList.remove('hidden');
        });

        // Close Add Service Modal
        cancelAddServiceBtn.addEventListener('click', function() {
            addServiceModal.classList.add('hidden');
        });

        // Add Service using Form submission
        addServiceForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(addServiceForm);

            fetch("{{ route('admin.services.store') }}", {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        services.push(data.service);
                        renderServices();
                        updateTotalServices();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        addServiceForm.reset();
                        addServiceModal.classList.add('hidden');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message
                        });
                    }
                })
                .catch(error => {
                    console.error(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while adding the service.'
                    });
                });
        });

        // Delegated event for Edit and Delete buttons
        document.getElementById('serviceTableBody').addEventListener('click', function(e) {
            const target = e.target.closest('button');
            if (!target) return;

            const row = target.closest('tr');
            const serviceId = row.getAttribute('data-id');

            if (target.classList.contains('editServiceBtn')) {
                // Find the service data
                const service = services.find(s => s.id == serviceId);
                Swal.fire({
                    title: 'Edit Service',
                    html: `
                    <input id="swal-input1" class="swal2-input" placeholder="Service Name" value="${service.name}">
                    <textarea id="swal-input2" class="swal2-textarea" placeholder="Description">${service.description}</textarea>
                    <input id="swal-input3" class="swal2-input" placeholder="Price" value="${service.price}">
                    <input id="swal-input4" class="swal2-input" placeholder="Duration" value="${service.duration}">
                `,
                    focusConfirm: false,
                    showCancelButton: true,
                    preConfirm: () => {
                        return {
                            id: service.id,
                            name: document.getElementById('swal-input1').value,
                            description: document.getElementById('swal-input2').value,
                            price: document.getElementById('swal-input3').value,
                            duration: document.getElementById('swal-input4').value,
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        updateService(result.value);
                    }
                });
            }

            if (target.classList.contains('deleteServiceBtn')) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This service will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteService(serviceId, row);
                    }
                });
            }
        });

        // Update Service function
        function updateService(updatedService) {
            fetch("{{ route('admin.services.update', ':id') }}".replace(':id', updatedService.id), {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(updatedService)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const index = services.findIndex(s => s.id == updatedService.id);
                        if (index !== -1) {
                            services.splice(index, 1, data.service);
                        }
                        renderServices();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message
                        });
                    }
                })
                .catch(error => {
                    console.error(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while updating the service.'
                    });
                });
        }

        // Delete Service function
        function deleteService(serviceId, row) {
            fetch("{{ route('admin.services.destroy', ':id') }}".replace(':id', serviceId), {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        services = services.filter(s => s.id != serviceId);
                        row.remove();
                        updateTotalServices();
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message
                        });
                    }
                })
                .catch(error => {
                    console.error(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while deleting the service.'
                    });
                });
        }
    </script>
@endsection
