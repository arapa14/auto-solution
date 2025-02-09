@extends('admin.layout')

@section('title', 'Manage Products')

@section('content')
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md mt-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Product Management</h2>
            <button id="openAddProductBtn"
                class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-3 rounded-md shadow-md flex items-center gap-2">
                <i class="fas fa-plus"></i> Add New Product
            </button>
        </div>

        <!-- Add Product Modal -->
        <div id="addProductModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white p-6 rounded-lg w-full max-w-lg">
                <h2 class="text-2xl font-bold mb-4">Add New Product</h2>
                <form id="addProductForm" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label for="newName" class="block text-gray-700 font-bold mb-1">Name</label>
                            <input type="text" name="name" id="newName"
                                class="w-full border border-gray-300 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label for="newDescription" class="block text-gray-700 font-bold mb-1">Description</label>
                            <textarea name="description" id="newDescription"
                                class="w-full border border-gray-300 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                        </div>
                        <div>
                            <label for="newPrice" class="block text-gray-700 font-bold mb-1">Price</label>
                            <input type="number" name="price" id="newPrice"
                                class="w-full border border-gray-300 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label for="newStock" class="block text-gray-700 font-bold mb-1">Stock</label>
                            <input type="number" name="stock" id="newStock"
                                class="w-full border border-gray-300 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label for="newCategory" class="block text-gray-700 font-bold mb-1">Category</label>
                            <input type="text" name="category" id="newCategory"
                                class="w-full border border-gray-300 p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label for="newImage" class="block text-gray-700 font-bold mb-1">Image</label>
                            <input type="file" name="image" id="newImage" class="w-full" required>
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="button" id="cancelAddProduct"
                            class="mr-2 px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-100">Cancel</button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-md hover:bg-blue-600">Add
                            Product</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Search Field -->
        <div class="mb-6">
            <input type="text" id="searchInput" placeholder="Search product..."
                class="w-full border border-gray-300 p-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Product Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" id="productTable">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="productTableBody">
                    @foreach ($products as $product)
                        <tr data-id="{{ $product->id }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-24 w-24">
                                        <img class="h-full w-full object-contain"
                                            src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->name }}</td>
                            <td class="px-6 py-4 whitespace-normal text-sm text-gray-700">{{ $product->description }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp.
                                {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->stock }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->category }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <button
                                    class="editBtn bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md shadow-md">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button
                                    class="deleteBtn bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md shadow-md">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            <p class="text-gray-700">Total Products: <span id="totalProducts">{{ $products->count() }}</span></p>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Global variable untuk menyimpan data produk
        let products = @json($products);

        // Fungsi untuk me-render data produk ke dalam tabel
        function renderProducts() {
            const tbody = document.getElementById('productTableBody');
            tbody.innerHTML = '';
            products.forEach((product, index) => {
                const tr = document.createElement('tr');
                tr.setAttribute('data-id', product.id);
                tr.classList.add('divide-y', 'divide-gray-200');
                tr.innerHTML = `
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${product.id}</td>
      <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex items-center">
          <div class="flex-shrink-0 h-24 w-24">
            <img class="h-full w-full object-contain" src="/storage/${product.image}" alt="${product.name}">
          </div>
        </div>
      </td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${product.name}</td>
      <td class="px-6 py-4 whitespace-normal text-sm text-gray-700">${product.description}</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp. ${Number(product.price).toLocaleString('id-ID')}</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${product.stock}</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${product.category}</td>
      <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
        <button class="editBtn bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md shadow-md">
          <i class="fas fa-edit"></i> Edit
        </button>
        <button class="deleteBtn bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md shadow-md">
          <i class="fas fa-trash"></i> Delete
        </button>
      </td>
    `;
                tbody.appendChild(tr);
            });
        }

        // Render data awal
        renderProducts();

        // Update total products count
        function updateTotalProducts() {
            document.getElementById('totalProducts').textContent = products.length;
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('#productTableBody tr');
            rows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                row.style.display = rowText.includes(filter) ? '' : 'none';
            });
        });

        // Modal Elements
        const openAddProductBtn = document.getElementById('openAddProductBtn');
        const addProductModal = document.getElementById('addProductModal');
        const cancelAddProductBtn = document.getElementById('cancelAddProduct');
        const addProductForm = document.getElementById('addProductForm');

        // Open Add Product Modal
        openAddProductBtn.addEventListener('click', function() {
            addProductModal.classList.remove('hidden');
        });

        // Close Add Product Modal
        cancelAddProductBtn.addEventListener('click', function() {
            addProductModal.classList.add('hidden');
        });

        // Add Product using FormData (untuk file upload)
        addProductForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(addProductForm);

            fetch("{{ route('admin.products.store') }}", {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        products.push(data.product);
                        renderProducts();
                        updateTotalProducts();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        addProductForm.reset();
                        addProductModal.classList.add('hidden');
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
                        text: 'An error occurred while adding the product.'
                    });
                });
        });

        // Delegated event for Edit and Delete buttons
        document.getElementById('productTableBody').addEventListener('click', function(e) {
            const target = e.target.closest('button');
            if (!target) return;

            const row = target.closest('tr');
            const productId = row.getAttribute('data-id');

            if (target.classList.contains('editBtn')) {
                // Gunakan SweetAlert2 untuk modal edit
                const product = products.find(p => p.id == productId);
                Swal.fire({
                    title: 'Edit Product',
                    html: `
        <input id="swal-input1" class="swal2-input" placeholder="Name" value="${product.name}">
        <input id="swal-input2" type="number" class="swal2-input" placeholder="Price" value="${product.price}">
        <input id="swal-input3" type="number" class="swal2-input" placeholder="Stock" value="${product.stock}">
        <input id="swal-input4" class="swal2-input" placeholder="Category" value="${product.category}">
        <textarea id="swal-input5" class="swal2-textarea" placeholder="Description">${product.description}</textarea>
        <input id="swal-input6" type="file" class="swal2-input" placeholder="Image">`,
                    focusConfirm: false,
                    showCancelButton: true,
                    preConfirm: () => {
                        // Catatan: Field file tidak bisa didapatkan dari SweetAlert secara langsung.
                        return {
                            id: product.id,
                            name: document.getElementById('swal-input1').value,
                            price: document.getElementById('swal-input2').value,
                            stock: document.getElementById('swal-input3').value,
                            category: document.getElementById('swal-input4').value,
                            description: document.getElementById('swal-input5').value,
                            image: product.image
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        updateProduct(result.value);
                    }
                });
            }

            if (target.classList.contains('deleteBtn')) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This product will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteProduct(productId, row);
                    }
                });
            }
        });

        // Update Product function
        function updateProduct(updatedProduct) {
            fetch("{{ route('admin.products.update', ':id') }}".replace(':id', updatedProduct.id), {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(updatedProduct)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const index = products.findIndex(p => p.id == updatedProduct.id);
                        if (index !== -1) {
                            products.splice(index, 1, data.product);
                        }
                        renderProducts();
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
                        text: 'An error occurred while updating the product.'
                    });
                });
        }

        // Delete Product function
        function deleteProduct(productId, row) {
            fetch("{{ route('admin.products.destroy', ':id') }}".replace(':id', productId), {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        products = products.filter(product => product.id != productId);
                        row.remove();
                        updateTotalProducts();
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
                        text: 'An error occurred while deleting the product.'
                    });
                });
        }
    </script>
@endsection
