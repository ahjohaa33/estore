<div>
    <style>
        .image-preview-container img:hover {
            transform: scale(1.05);
            transition: transform 0.2s ease;
        }
    </style>
    <main class="main-content">
        <header class="top-header">
            <div class="header-left">
                <h1>Products</h1>
            </div>
            <div class="header-right">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search products...">
                </div>
                <div class="user-menu">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=667eea&color=fff" alt="Admin">
                    <span>Admin</span>
                </div>
            </div>
        </header>

        <div class="content-area">
            <div class="page-actions">
                <button class="btn btn-primary" onclick="openModal('addProductModal')">
                    <i class="fas fa-plus"></i> Add New Product
                </button>
                <div class="filter-group">
                    <select class="filter-select" id="categoryFilter">
                        <option value="">All Categories</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Clothing">Clothing</option>
                        <option value="Accessories">Accessories</option>
                    </select>

                    <select class="filter-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="Active">Active</option>
                        <option value="Out of Stock">Out of Stock</option>
                        <option value="Draft">Draft</option>
                    </select>

                    <select class="filter-select" id="bulkAction">
                        <option value="">Bulk Actions</option>
                        <option value="Delete">Delete</option>
                    </select>

                    <button class="btn btn-primary" id="applyBtn">Apply</button>
                </div>
            </div>

            <div class="table-card w-100">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $item)
                            <tr>
                                <td><input type="checkbox" class="row-checkbox" data-id="{{ $item->id }}"></td>
                                <td>
                                    <div class="product-cell">
                                        <div class="product-image"></div>
                                        <span>{{ $item->name }}</span>
                                    </div>
                                </td>
                                <td>Electronics</td>
                                <td>$89.99</td>
                                <td>145</td>
                                <td><span class="badge success">Active</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit"><i class="fas fa-edit"></i></button>
                                        <button class="btn-icon" title="Delete"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td>No Products Found</td>

                            </tr>
                        @endforelse


                    </tbody>
                </table>
                <div class="table-pagination">
                    <span>Showing 1-5 of 856 products</span>
                    <div class="pagination-buttons">
                        <button class="btn-pagination" disabled><i class="fas fa-chevron-left"></i></button>
                        <button class="btn-pagination active">1</button>
                        <button class="btn-pagination">2</button>
                        <button class="btn-pagination">3</button>
                        <button class="btn-pagination"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="addProductModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New Product</h2>
                <button class="modal-close" onclick="closeModal('addProductModal')">&times;</button>
            </div>

            <div class="modal-body">

                <!-- Product Name -->
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" class="form-input" name="name" placeholder="Enter product name">
                </div>

                <!-- Images Upload -->
                <div class="form-group">
                    <label>Product Images</label>
                    <input type="file" class="form-input" name="images[]" multiple accept="image/*">
                    <small>Upload one or more images</small>
                </div>

                <!-- Category / Price / Offer -->
                <div class="form-row">
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-input" name="category">
                            <option value="">Select category</option>
                            @foreach ($cats as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                            
                            
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" class="form-input" name="price" placeholder="Product Price In BDT">
                    </div>
                    <div class="form-group">
                        <label>Offer Price</label>
                        <input type="number" class="form-input" name="offer_price" placeholder="Offer Price">
                    </div>
                </div>

                <!-- Offer Duration -->
                <div class="form-group">
                    <label>Offer Duration</label>
                    <input type="datetime-local" class="form-input" name="offer_duration">
                </div>

                <!-- Color / Size -->
                <div class="form-row">
                    <div class="form-group">

                        <label>Colors</label>
                        <input type="text" class="form-input" name="color"
                            placeholder='e.g. ["Red","Blue","Green"]'>
                    </div>
                    <div class="form-group">
                        <label>Sizes</label>
                        <input type="text" class="form-input" name="size"
                            placeholder='e.g. ["S","M","L","XL"]'>
                    </div>
                </div>

                <!-- Specification -->
                <div class="form-group">
                    <label>Specification</label>
                    <textarea class="form-input" name="specification" rows="3" placeholder="Enter product specifications"></textarea>
                </div>

                <!-- Stock / Featured / Fav -->
                <div class="form-row">
                    <div class="form-group">
                        <label>In Stock</label>
                        <input type="number" class="form-input" name="in_stock" placeholder="Stock Quantity">
                    </div>
                    <div class="form-group">
                        <label>Featured Product</label>
                        <select class="form-input" name="is_featured">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>

                </div>



                <!-- Status -->
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-input" name="status">
                        <option value="active">Active</option>
                        <option value="draft">Draft</option>
                        <option value="inactive">Inactive</option>
                        <option value="outofstock">Out Of Stock</option>
                    </select>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal('addProductModal')">Cancel</button>
                <button class="btn btn-primary">Add Product</button>
            </div>
        </div>
    </div>

    <!-- add product script-->
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const modal = document.getElementById('addProductModal');
            const addProductBtn = modal.querySelector('.btn.btn-primary');
            const imageInput = modal.querySelector('input[name="images[]"]');

            // 🔹 Create an image preview container (right after the image input)
            const previewContainer = document.createElement('div');
            previewContainer.classList.add('image-preview-container');
            previewContainer.style.display = 'flex';
            previewContainer.style.flexWrap = 'wrap';
            previewContainer.style.gap = '10px';
            previewContainer.style.marginTop = '10px';
            imageInput.insertAdjacentElement('afterend', previewContainer);

            // 🔹 Show image previews when files are selected
            imageInput.addEventListener('change', (e) => {
                previewContainer.innerHTML = ''; // Clear old previews

                const files = Array.from(e.target.files);
                if (!files.length) return;

                files.forEach(file => {
                    if (!file.type.startsWith('image/')) return; // Skip non-image files

                    const reader = new FileReader();
                    reader.onload = (ev) => {
                        const img = document.createElement('img');
                        img.src = ev.target.result;
                        img.style.width = '80px';
                        img.style.height = '80px';
                        img.style.objectFit = 'cover';
                        img.style.borderRadius = '8px';
                        img.style.boxShadow = '0 0 4px rgba(0,0,0,0.2)';
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            });

            // 🔹 Handle Add Product button click
            addProductBtn.addEventListener('click', async (e) => {
                e.preventDefault();

                // Disable button & show spinner
                const originalText = addProductBtn.innerHTML;
                addProductBtn.disabled = true;
                addProductBtn.innerHTML = `<i class="fa fa-spinner fa-spin"></i> Adding...`;

                const formData = new FormData();
                modal.querySelectorAll('input[name], select[name], textarea[name]').forEach(input => {
                    const name = input.name;

                    if (input.type === 'file') {
                        Array.from(input.files).forEach(file => formData.append(name, file));
                    } else if (input.type === 'checkbox' || input.type === 'radio') {
                        if (input.checked) formData.append(name, input.value);
                    } else {
                        formData.append(name, input.value);
                    }
                });

                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                    'content');
                if (token) formData.append('_token', token);

                try {
                    const response = await fetch('/admin/v1/createproduct', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json'
                        },
                        body: formData,
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        const message = data.message ||
                            'Something went wrong. Please check your input.';
                        if (data.errors) {
                            Object.values(data.errors).forEach(errArr => toastr.error(errArr.join(
                                '<br>')));
                        } else {
                            toastr.error(message);
                        }
                        return;
                    }

                    toastr.success(data.message || 'Product added successfully.');
                    location.reload();

                    // Reset form inputs
                    modal.querySelectorAll('input, textarea, select').forEach(el => {
                        if (el.type === 'file') el.value = '';
                        else if (el.tagName === 'SELECT') el.selectedIndex = 0;
                        else el.value = '';
                    });

                    // Clear image previews
                    previewContainer.innerHTML = '';

                    // Close modal if available
                    if (typeof closeModal === 'function') closeModal('addProductModal');

                } catch (error) {
                    console.error('Error:', error);
                    toastr.error('An unexpected error occurred. Please try again.');
                } finally {
                    // Re-enable button & restore text
                    addProductBtn.disabled = false;
                    addProductBtn.innerHTML = originalText;
                }
            });
        });
    </script>

    <!-- filtering and bulk delete-->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const selectAll = document.getElementById("selectAll");
            const checkboxes = document.querySelectorAll(".row-checkbox");
            const applyBtn = document.getElementById("applyBtn");
            const bulkAction = document.getElementById("bulkAction");
            const categoryFilter = document.getElementById("categoryFilter");
            const statusFilter = document.getElementById("statusFilter");
            const tableBody = document.querySelector(".data-table tbody");

            // ✅ Select all checkboxes
            selectAll.addEventListener("change", function() {
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
            });

            // ✅ When Apply clicked
            applyBtn.addEventListener("click", function() {
                const action = bulkAction.value;
                const category = categoryFilter.value;
                const status = statusFilter.value;
                const selectedIds = Array.from(document.querySelectorAll(".row-checkbox:checked"))
                    .map(cb => cb.getAttribute("data-id"));

                // === Case 1: Bulk Delete ===
                if (action === "Delete") {
                    if (selectedIds.length === 0) {
                        alert("Please select at least one product to delete.");
                        return;
                    }
                    if (!confirm("Are you sure you want to delete selected products?")) return;

                    fetch("{{ route('deleteproducts') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                ids: selectedIds
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message || "Products deleted successfully!");
                                location.reload();
                            } else {
                                alert(data.message || "Something went wrong!");
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            alert("An error occurred while deleting.");
                        });
                    return;
                }

                // === Case 2: Filter Products ===
                fetch("{{ route('productfilter') }}?category=" + encodeURIComponent(category) + "&status=" +
                        encodeURIComponent(status), {
                            method: "GET",
                            headers: {
                                "X-Requested-With": "XMLHttpRequest"
                            }
                        })
                    .then(response => response.text())
                    .then(html => {
                        // Replace table body dynamically
                        const parser = new DOMParser();
                        const newDoc = parser.parseFromString(html, 'text/html');
                        const newTableBody = newDoc.querySelector('.data-table tbody');
                        if (newTableBody) {
                            tableBody.innerHTML = newTableBody.innerHTML;
                        } else {
                            tableBody.innerHTML =
                                `<tr><td colspan="7" style="text-align:center;">No products found</td></tr>`;
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        alert("Error fetching filtered products.");
                    });
            });
        });
    </script>


</div>
