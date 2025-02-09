@extends('admin.layout')

@section('title', 'Manage Users')

@section('content')
    <div class="max-w-6xl mx-auto bg-white p-4 sm:p-6 rounded-lg shadow-md mt-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 sm:mb-0">User Management</h2>
            <button id="openAddUserBtn"
                class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-3 rounded-md shadow-md flex items-center gap-2">
                <i class="fas fa-plus"></i> Add New User
            </button>
        </div>

        <!-- Add User Modal -->
        <div id="addUserModal"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50 overflow-y-auto">
            <div class="bg-white p-6 rounded-lg w-full max-w-lg mx-4 my-8">
                <h2 class="text-2xl font-bold mb-4">Add New User</h2>
                <form id="addUserForm">
                    @csrf
                    <!-- Grid untuk field: Name, Email, Phone, dan Role dalam 2 kolom pada layar desktop -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="newName" class="block text-gray-700 font-semibold mb-1">Name</label>
                            <input type="text" name="name" id="newName"
                                class="w-full border border-gray-300 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label for="newEmail" class="block text-gray-700 font-semibold mb-1">Email</label>
                            <input type="email" name="email" id="newEmail"
                                class="w-full border border-gray-300 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label for="newPhone" class="block text-gray-700 font-semibold mb-1">Phone</label>
                            <input type="text" name="phone" id="newPhone"
                                class="w-full border border-gray-300 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label for="newRole" class="block text-gray-700 font-semibold mb-1">Role</label>
                            <select name="role" id="newRole"
                                class="w-full border border-gray-300 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>

                    <!-- Field Address full-width -->
                    <div class="mt-4">
                        <label for="newAddress" class="block text-gray-700 font-semibold mb-1">Address</label>
                        <textarea name="address" id="newAddress"
                            class="w-full border border-gray-300 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                    </div>

                    <!-- Password fields: tampil berdampingan pada layar desktop -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label for="newPassword" class="block text-gray-700 font-semibold mb-1">Password</label>
                            <input type="password" name="password" id="newPassword"
                                class="w-full border border-gray-300 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label for="newPasswordConfirmation" class="block text-gray-700 font-semibold mb-1">Confirm
                                Password</label>
                            <input type="password" name="password_confirmation" id="newPasswordConfirmation"
                                class="w-full border border-gray-300 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                    </div>

                    <!-- Tombol aksi -->
                    <div class="flex justify-end mt-6">
                        <button type="button" id="cancelAddUser"
                            class="mr-3 px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-100">Cancel</button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-md hover:bg-blue-600">Add
                            User</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Search Field -->
        <div class="mb-6">
            <input type="text" id="searchInput" placeholder="Search user..."
                class="w-full border border-gray-300 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Total Users Info -->
        <div class="mb-4">
            <p class="text-gray-700 font-medium">Total Users: <span id="totalUsers">{{ $users->count() }}</span></p>
        </div>

        <!-- User Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" id="userTable">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="userTableBody">
                    @foreach ($users as $user)
                        <tr data-id="{{ $user->id }}">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $user->id }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $user->phone }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $user->address }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ ucfirst($user->role) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium">
                                <button
                                    class="editBtn bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-md shadow-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button
                                    class="deleteBtn bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md shadow-sm">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                                <!-- Tombol Switch Account -->
                                <a href="{{ route('switch-account', $user->id) }}"
                                    class="switchBtn bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-md shadow-sm inline-block">
                                    <i class="fas fa-exchange-alt"></i> Switch
                                </a>
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
        // Global variable to store user data
        let users = @json($users);

        // Render users in the table
        function renderUsers() {
            const tbody = document.getElementById('userTableBody');
            tbody.innerHTML = '';
            users.forEach(user => {
                const tr = document.createElement('tr');
                tr.setAttribute('data-id', user.id);
                tr.classList.add('divide-y', 'divide-gray-200');
                tr.innerHTML = `
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${user.id}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${user.name}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${user.email}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${user.phone}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${user.address}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${user.role.charAt(0).toUpperCase() + user.role.slice(1)}</td>
                <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium">
                    <button class="editBtn bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-md shadow-sm">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="deleteBtn bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md shadow-sm">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                    <a href="/switch/${user.id}" class="switchBtn bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-md shadow-sm inline-block">
                        <i class="fas fa-exchange-alt"></i> Switch
                    </a>
                </td>
            `;
                tbody.appendChild(tr);
            });
        }

        // Update total users count
        function updateTotalUsers() {
            document.getElementById('totalUsers').textContent = users.length;
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('#userTableBody tr');
            rows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                row.style.display = rowText.includes(filter) ? '' : 'none';
            });
        });

        // Modal Elements
        const openAddUserBtn = document.getElementById('openAddUserBtn');
        const addUserModal = document.getElementById('addUserModal');
        const cancelAddUserBtn = document.getElementById('cancelAddUser');
        const addUserForm = document.getElementById('addUserForm');

        // Open Add User Modal
        openAddUserBtn.addEventListener('click', function() {
            addUserModal.classList.remove('hidden');
        });

        // Close Add User Modal
        cancelAddUserBtn.addEventListener('click', function() {
            addUserModal.classList.add('hidden');
        });

        // Add User using Form submission
        addUserForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(addUserForm);

            fetch("{{ route('admin.users.store') }}", {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        users.push(data.user);
                        renderUsers();
                        updateTotalUsers();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        addUserForm.reset();
                        addUserModal.classList.add('hidden');
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
                        text: 'An error occurred while adding the user.'
                    });
                });
        });

        // Delegated event for Edit and Delete buttons
        document.getElementById('userTableBody').addEventListener('click', function(e) {
            const target = e.target.closest('button');
            if (!target) return;

            const row = target.closest('tr');
            const userId = row.getAttribute('data-id');

            if (target.classList.contains('editBtn')) {
                // Find the user data
                const user = users.find(u => u.id == userId);
                Swal.fire({
                    title: 'Edit User',
                    html: `
                    <input id="swal-input1" class="swal2-input" placeholder="Name" value="${user.name}">
                    <input id="swal-input2" class="swal2-input" placeholder="Email" value="${user.email}">
                    <input id="swal-input3" class="swal2-input" placeholder="Phone" value="${user.phone}">
                    <input id="swal-input4" class="swal2-input" placeholder="Address" value="${user.address}">
                    <select id="swal-input5" class="swal2-input">
                        <option value="user" ${user.role === 'user' ? 'selected' : ''}>User</option>
                        <option value="admin" ${user.role === 'admin' ? 'selected' : ''}>Admin</option>
                    </select>
                `,
                    focusConfirm: false,
                    showCancelButton: true,
                    preConfirm: () => {
                        return {
                            id: user.id,
                            name: document.getElementById('swal-input1').value,
                            email: document.getElementById('swal-input2').value,
                            phone: document.getElementById('swal-input3').value,
                            address: document.getElementById('swal-input4').value,
                            role: document.getElementById('swal-input5').value,
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        updateUser(result.value);
                    }
                });
            }

            if (target.classList.contains('deleteBtn')) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This user will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteUser(userId, row);
                    }
                });
            }
        });

        // Update User function
        function updateUser(updatedUser) {
            fetch("{{ route('admin.users.update', ':id') }}".replace(':id', updatedUser.id), {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(updatedUser)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const index = users.findIndex(u => u.id == updatedUser.id);
                        if (index !== -1) {
                            users.splice(index, 1, data.user);
                        }
                        renderUsers();
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
                        text: 'An error occurred while updating the user.'
                    });
                });
        }

        // Delete User function
        function deleteUser(userId, row) {
            fetch("{{ route('admin.users.destroy', ':id') }}".replace(':id', userId), {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        users = users.filter(user => user.id != userId);
                        row.remove();
                        updateTotalUsers();
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
                        text: 'An error occurred while deleting the user.'
                    });
                });
        }
    </script>
@endsection
