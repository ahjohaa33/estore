@extends('admin.admin2.layout2')
@section('admin2')
    <!-- products.blade.php -->
    <main class="main-wrap">
        <header class="main-header navbar">
            <div class="col-search">
                <form class="searchform" id="searchForm">
                    <div class="input-group">
                        <input class="form-control" id="searchInput" type="text" placeholder="Search products...">
                        <button class="btn btn-light bg" type="submit"><i class="material-icons md-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="col-nav">
                <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside"><i
                        class="material-icons md-apps"></i></button>
                <ul class="nav">
                    <li class="nav-item"><a class="nav-link btn-icon" href="#"><i
                                class="material-icons md-notifications animation-shake"></i><span
                                class="badge rounded-pill">3</span></a></li>
                    <li class="nav-item"><a class="nav-link btn-icon darkmode" href="#"><i
                                class="material-icons md-nights_stay"></i></a></li>
                    <li class="nav-item"><a class="requestfullscreen nav-link btn-icon" href="#"><i
                                class="material-icons md-cast"></i></a></li>
                    <li class="dropdown nav-item"><a class="dropdown-toggle" id="dropdownLanguage" data-bs-toggle="dropdown"
                            href="#" aria-expanded="false"><i class="material-icons md-public"></i></a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownLanguage"><a
                                class="dropdown-item text-brand" href="#"><img src="assets/imgs/theme/flag-us.png"
                                    alt="English">English</a><a class="dropdown-item" href="#"><img
                                    src="assets/imgs/theme/flag-fr.png" alt="Français">Fran&ccedil;ais</a><a
                                class="dropdown-item" href="#"><img src="assets/imgs/theme/flag-jp.png"
                                    alt="Français">&#x65E5;&#x672C;&#x8A9E;</a><a class="dropdown-item" href="#"><img
                                    src="assets/imgs/theme/flag-cn.png" alt="Français">&#x4E2D;&#x56FD;&#x4EBA;</a></div>
                    </li>
                    <li class="dropdown nav-item"><a class="dropdown-toggle" id="dropdownAccount" data-bs-toggle="dropdown"
                            href="#" aria-expanded="false"><img class="img-xs rounded-circle"
                                src="assets/imgs/people/avatar2.jpg" alt="User"></a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownAccount"><a
                                class="dropdown-item" href="#"><i class="material-icons md-perm_identity"></i>Edit
                                Profile</a><a class="dropdown-item" href="#"><i
                                    class="material-icons md-settings"></i>Account Settings</a><a class="dropdown-item"
                                href="#"><i class="material-icons md-account_balance_wallet"></i>Wallet</a><a
                                class="dropdown-item" href="#"><i class="material-icons md-receipt"></i>Billing</a><a
                                class="dropdown-item" href="#"><i class="material-icons md-help_outline"></i>Help
                                center</a>
                            <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#"><i
                                    class="material-icons md-exit_to_app"></i>Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </header>

        <section class="content-main">
            <div class="row">
                <div class="col-12">
                    <div class="content-header">
                        <h2 class="content-title">Product Management</h2>
                        <div>
                            <button class="btn btn-light rounded font-sm mr-5 text-body hover-up" data-bs-toggle="modal"
                                data-bs-target="#addProductModal">Add New Product</button>
                            <button class="btn btn-md rounded font-sm hover-up" id="bulkDeleteBtn"
                                style="display: none;">Delete Selected</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row gx-3">
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label">Category</label>
                            <select class="form-select" id="categoryFilter">
                                <option value="">All Categories</option>
                                @foreach ($cats as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label">Stock Status</label>
                            <select class="form-select" id="stockFilter">
                                <option value="">All Stock</option>
                                <option value="in_stock">In Stock</option>
                                <option value="out_of_stock">Out of Stock</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label">Featured</label>
                            <select class="form-select" id="featuredFilter">
                                <option value="">All Products</option>
                                <option value="1">Featured</option>
                                <option value="0">Not Featured</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="card mb-4">
                <header class="card-header">
                    <div class="row gx-3">
                        <div class="col-lg-4 col-md-6 me-auto">
                            <input type="text" placeholder="Search..." class="form-control" id="tableSearch">
                        </div>
                        <div class="col-lg-2 col-md-3 col-6">
                            <select class="form-select" id="sortBy">
                                <option value="name">Sort by Name</option>
                                <option value="price">Sort by Price</option>
                                <option value="category">Sort by Category</option>
                                <option value="sale_count">Sort by Sales</option>
                            </select>
                        </div>
                        <div class="col-lg-1 col-md-3 col-6">
                            <select class="form-select" id="sortOrder">
                                <option value="asc">ASC</option>
                                <option value="desc">DESC</option>
                            </select>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="productsTable">
                            <thead>
                                <tr>
                                    <th scope="col" width="40">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                        </div>
                                    </th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Stock</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody id="productsTableBody">
                                @foreach ($products as $product)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input row-checkbox" type="checkbox"
                                                    value="{{ $product->id }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-3" style="width: 60px;">
                                                    @php
                                                        // start from whatever is stored
                                                        $images = $product->images;

                                                        // if it's a JSON string, decode it
if (is_string($images)) {
    $images = json_decode($images, true) ?: [];
}

// if it's still not an array, force empty array
                                                        if (!is_array($images)) {
                                                            $images = [];
                                                        }

                                                        // pick first image or fallback
                                                        $firstImage = !empty($images)
                                                            ? $images[0]
                                                            : asset('assets/imgs/items/default.jpg');
                                                    @endphp

                                                    <img style="object-fit: contain; height:60px; width:120px;
                                                "
                                                        src="{{ asset('storage') . '/' . $firstImage }}" class="img-fluid"
                                                        alt="{{ $product->name }}">
                                                </div>
                                                <div>
                                                    <a href="#" class="text-reset">{{ $product->name }}</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $product->category }}</td>
                                        <td>
                                            @if ($product->offer_price)
                                                <span
                                                    class="text-muted text-decoration-line-through">${{ number_format($product->price, 2) }}</span>
                                                ${{ number_format($product->offer_price, 2) }}
                                            @else
                                                ${{ number_format($product->price, 2) }}
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge {{ $product->in_stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                                {{ $product->in_stock > 0 ? $product->in_stock . ' in stock' : 'Out of stock' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge {{ $product->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $product->status }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown">
                                                <a href="#" data-bs-toggle="dropdown"
                                                    class="btn btn-light rounded btn-sm font-sm">
                                                    <i class="material-icons md-more_horiz"></i>
                                                </a>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#"
                                                        onclick="editProduct({{ $product->id }})">Edit</a>
                                                    <a class="dropdown-item text-danger" href="#"
                                                        onclick="deleteProduct({{ $product->id }})">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="pagination-area mt-30 mb-50" id="paginationContainer">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </section>

        <!-- Add Product Modal -->
        <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="addProductForm" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <h6>1. General info</h6>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="mb-4">
                                                        <label class="form-label">Product Name *</label>
                                                        <input class="form-control" type="text" name="name"
                                                            required>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label">Category *</label>
                                                        <select class="form-select" name="category" id="categorySelect"
                                                            required>
                                                            <option value="">Select Category</option>
                                                            @foreach ($cats as $category)
                                                                <option value="{{ $category->name }}">
                                                                    {{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label">Description</label>
                                                        <textarea class="form-control" name="specification" placeholder="Type here" rows="4"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <h6>2. Pricing</h6>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="mb-4">
                                                        <label class="form-label">Price *</label>
                                                        <input class="form-control" type="number" step="0.01"
                                                            name="price" required>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label">Offer Price</label>
                                                        <input class="form-control" type="number" step="0.01"
                                                            name="offer_price">
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label">Offer Duration</label>
                                                        <input class="form-control" type="datetime-local"
                                                            name="offer_duration">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Dynamic Fields Based on Category -->
                            <div id="dynamicFieldsContainer">
                                <!-- Dynamic fields will be loaded here based on category selection -->
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <h6>3. Additional Info</h6>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-4">
                                                                <label class="form-label">Stock Quantity</label>
                                                                <input class="form-control" type="number"
                                                                    name="in_stock" value="0">
                                                            </div>
                                                            <div class="mb-4">
                                                                <label class="form-label">Sale Count</label>
                                                                <input class="form-control" type="number"
                                                                    name="sale_count" value="0">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-4">
                                                                <label class="form-label">Status</label>
                                                                <select class="form-select" name="status">
                                                                    <option value="active">Active</option>
                                                                    <option value="inactive">Inactive</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-check mb-4">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="is_featured" value="1">
                                                                <label class="form-check-label">Featured Product</label>
                                                            </div>
                                                            <div class="form-check mb-4">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="is_fav" value="1">
                                                                <label class="form-check-label">Mark as Favorite</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <h6>4. Media & Attributes</h6>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="mb-4">
                                                        <label class="form-label">Product Images</label>
                                                        <input class="form-control" type="file" id="productImages"
                                                            name="images[]" multiple accept="image/*">
                                                        <small class="form-text text-muted">You can select multiple
                                                            images</small>
                                                        <div id="imagePreviewContainer"
                                                            class="d-flex flex-wrap gap-2 mb-2"></div>

                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label">Colors (JSON format)</label>
                                                        <textarea class="form-control" name="color" placeholder='["Red", "Blue", "Green"]' rows="2"></textarea>
                                                        <small class="form-text text-muted">Enter colors as JSON
                                                            array</small>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label">Sizes (JSON format)</label>
                                                        <textarea class="form-control" name="size" placeholder='["S", "M", "L"]' rows="2"></textarea>
                                                        <small class="form-text text-muted">Enter sizes as JSON
                                                            array</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light rounded font-sm text-body hover-up"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-md rounded font-sm hover-up" id="submitProductBtn">Add
                                Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <footer class="main-footer font-xs">
            <div class="row pb-30 pt-15">
                <div class="col-sm-6">
                    <script>
                        document.write(new Date().getFullYear())
                    </script> &copy;, Ecom - HTML Ecommerce Template .
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end">All rights reserved</div>
                </div>
            </div>
        </footer>
    </main>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // CSRF token for AJAX requests
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Define dynamic field configurations for different categories



            const categoryFields = {
                'Clothing': [{
                        type: 'text',
                        name: 'brand',
                        label: 'Brand',
                        required: false
                    },
                    {
                        type: 'select-multiple',
                        name: 'sizes',
                        label: 'Available Sizes',
                        options: ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
                        required: false
                    },
                    {
                        type: 'select-multiple',
                        name: 'colors',
                        label: 'Available Colors',
                        options: ['Red', 'Blue', 'Green', 'Black', 'White', 'Yellow'],
                        required: false
                    },
                    {
                        type: 'text',
                        name: 'material',
                        label: 'Material',
                        required: false
                    }
                ],
                'Electronics': [{
                        type: 'text',
                        name: 'brand',
                        label: 'Brand',
                        required: false
                    },
                    {
                        type: 'text',
                        name: 'model',
                        label: 'Model',
                        required: false
                    },
                    {
                        type: 'text',
                        name: 'warranty',
                        label: 'Warranty Period',
                        required: false
                    },
                    {
                        type: 'textarea',
                        name: 'specifications',
                        label: 'Technical Specifications',
                        required: false
                    }
                ],
                'Home & Garden': [{
                        type: 'text',
                        name: 'dimensions',
                        label: 'Dimensions',
                        required: false
                    },
                    {
                        type: 'text',
                        name: 'material',
                        label: 'Material',
                        required: false
                    },
                    {
                        type: 'text',
                        name: 'weight',
                        label: 'Weight',
                        required: false
                    },
                    {
                        type: 'textarea',
                        name: 'care_instructions',
                        label: 'Care Instructions',
                        required: false
                    }
                ],
                'Sports': [{
                        type: 'text',
                        name: 'brand',
                        label: 'Brand',
                        required: false
                    },
                    {
                        type: 'select',
                        name: 'sport_type',
                        label: 'Sport Type',
                        options: ['Running', 'Football', 'Basketball', 'Tennis', 'Swimming', 'Cycling'],
                        required: false
                    },
                    {
                        type: 'text',
                        name: 'material',
                        label: 'Material',
                        required: false
                    },
                    {
                        type: 'text',
                        name: 'weight',
                        label: 'Weight',
                        required: false
                    }
                ],
                'Books': [{
                        type: 'text',
                        name: 'author',
                        label: 'Author',
                        required: false
                    },
                    {
                        type: 'text',
                        name: 'publisher',
                        label: 'Publisher',
                        required: false
                    },
                    {
                        type: 'text',
                        name: 'isbn',
                        label: 'ISBN',
                        required: false
                    },
                    {
                        type: 'number',
                        name: 'pages',
                        label: 'Number of Pages',
                        required: false
                    }
                ]
            };

            // Category selection change handler
            document.getElementById('categorySelect').addEventListener('change', function() {
                const category = this.value;
                const container = document.getElementById('dynamicFieldsContainer');
                container.innerHTML = '';

                if (category && categoryFields[category]) {
                    const fields = categoryFields[category];

                    const dynamicSection = document.createElement('div');
                    dynamicSection.className = 'row';
                    dynamicSection.innerHTML = `
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <h6>Category Specific Details</h6>
                                    </div>
                                    <div class="col-md-9" id="dynamicFields">
                                        <!-- Dynamic fields will be inserted here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                    container.appendChild(dynamicSection);

                    const fieldsContainer = document.getElementById('dynamicFields');

                    fields.forEach(field => {
                        let fieldHtml = '';

                        switch (field.type) {
                            case 'text':
                            case 'number':
                                fieldHtml = `
                                <div class="mb-4">
                                    <label class="form-label">${field.label}</label>
                                    <input class="form-control" type="${field.type}" name="${field.name}" ${field.required ? 'required' : ''}>
                                </div>
                            `;
                                break;
                            case 'textarea':
                                fieldHtml = `
                                <div class="mb-4">
                                    <label class="form-label">${field.label}</label>
                                    <textarea class="form-control" name="${field.name}" rows="3" ${field.required ? 'required' : ''}></textarea>
                                </div>
                            `;
                                break;
                            case 'select':
                                fieldHtml = `
                                <div class="mb-4">
                                    <label class="form-label">${field.label}</label>
                                    <select class="form-select" name="${field.name}" ${field.required ? 'required' : ''}>
                                        <option value="">Select ${field.label}</option>
                                        ${field.options.map(option => `<option value="${option}">${option}</option>`).join('')}
                                    </select>
                                </div>
                            `;
                                break;
                            case 'select-multiple':
                                fieldHtml = `
                                <div class="mb-4">
                                    <label class="form-label">${field.label}</label>
                                    <select class="form-select" name="${field.name}[]" multiple ${field.required ? 'required' : ''}>
                                        ${field.options.map(option => `<option value="${option}">${option}</option>`).join('')}
                                    </select>
                                    <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple options</small>
                                </div>
                            `;
                                break;
                        }

                        fieldsContainer.innerHTML += fieldHtml;
                    });
                }
            });

            // Add Product Form Submission
            // document.getElementById('addProductForm').addEventListener('submit', function(e) {
            //     e.preventDefault();

            //     const submitBtn = document.getElementById('submitProductBtn');
            //     const originalText = submitBtn.innerHTML;
            //     submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...';
            //     submitBtn.disabled = true;

            //     const formData = new FormData(this);

            //     // Process multiple selects and checkboxes
            //     const formElements = this.elements;
            //     for (let element of formElements) {
            //         if (element.type === 'select-multiple') {
            //             const selectedOptions = Array.from(element.selectedOptions).map(option => option.value);
            //             formData.set(element.name, JSON.stringify(selectedOptions));
            //         } else if (element.type === 'checkbox') {
            //             formData.set(element.name, element.checked ? '1' : '0');
            //         }
            //     }

            //     fetch('{{ route('createproduct') }}', {
            //         method: 'POST',
            //         body: formData,
            //         headers: {
            //              'X-Requested-With': 'XMLHttpRequest',
            //             'X-CSRF-TOKEN': csrfToken
            //         }
            //     })
            //     .then(response => {
            //         if (!response.ok) {
            //             throw new Error('Network response was not ok');
            //         }
            //         return response.json();
            //     })
            //     .then(data => {
            //         if (data.success) {
            //             // Close modal
            //             const modal = bootstrap.Modal.getInstance(document.getElementById('addProductModal'));
            //             modal.hide();

            //             // Reset form
            //             document.getElementById('addProductForm').reset();
            //             document.getElementById('dynamicFieldsContainer').innerHTML = '';

            //             // Show success message
            //             showAlert('Product added successfully!', 'success');

            //             // Reload page to show new product
            //             window.location.reload();
            //         } else {
            //             showAlert('Error adding product: ' + (data.message || 'Unknown error'), 'error');
            //         }
            //     })
            //     .catch(error => {
            //         console.error('Error:', error);
            //         showAlert('Error adding product. Please try again.', 'error');
            //     })
            //     .finally(() => {
            //         submitBtn.innerHTML = originalText;
            //         submitBtn.disabled = false;
            //     });
            // });

            const formEl = document.getElementById('addProductForm');
            const imgInput = document.getElementById('productImages'); 
            const previewContainer = document.getElementById('imagePreviewContainer');

            /**
             * IMAGE PREVIEW
             * --------------------------------------------------
             */
            if (imgInput) {
                imgInput.addEventListener('change', function(e) {
                    const files = e.target.files;
                    // clear old previews
                    if (previewContainer) {
                        previewContainer.innerHTML = '';
                    }

                    if (!files || !files.length) {
                        console.log('[AddProduct] No images selected');
                        return;
                    }

                    Array.from(files).forEach((file, idx) => {
                        if (!file.type.startsWith('image/')) return;

                        const reader = new FileReader();
                        reader.onload = function(ev) {
                            const img = document.createElement('img');
                            img.src = ev.target.result;
                            img.alt = file.name;
                            img.style.width = '80px';
                            img.style.height = '80px';
                            img.style.objectFit = 'cover';
                            img.style.border = '1px solid #ddd';
                            img.style.borderRadius = '6px';
                            img.title = file.name;

                            if (previewContainer) {
                                previewContainer.appendChild(img);
                            }
                        };
                        reader.readAsDataURL(file);
                    });

                    console.log('[AddProduct] Selected image files:', files);
                });
            }

            /**
             * FORM SUBMIT
             * --------------------------------------------------
             */
            formEl.addEventListener('submit', function(e) {
                e.preventDefault();

                console.log('[AddProduct] Form submit triggered');

                const submitBtn = document.getElementById('submitProductBtn');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML =
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...';
                submitBtn.disabled = true;

                const formData = new FormData(this);

                // Process multiple selects and checkboxes
                const formElements = this.elements;
                for (let element of formElements) {
                    if (element.type === 'select-multiple') {
                        const selectedOptions = Array.from(element.selectedOptions).map(option => option
                            .value);
                        formData.set(element.name, JSON.stringify(selectedOptions));
                    } else if (element.type === 'checkbox') {
                        formData.set(element.name, element.checked ? '1' : '0');
                    }
                }

                // log what we're about to send (text fields only, not files)
                console.log('[AddProduct] Payload (non-file fields):');
                formData.forEach((val, key) => {
                    if (!(val instanceof File)) {
                        console.log('  ', key, ':', val);
                    }
                });

                // log files too
                const imageFiles = formData.getAll('images[]') || formData.getAll('images');
                if (imageFiles && imageFiles.length) {
                    console.log('[AddProduct] Image files to upload:', imageFiles);
                } else {
                    console.log('[AddProduct] No image files found in formData');
                }

                fetch('{{ route('createproduct') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => {
                        console.log('[AddProduct] Server responded with status:', response.status);
                        if (!response.ok) {
                            // try to read error body
                            return response.json().then(err => {
                                console.error('[AddProduct] Non-OK response JSON:', err);
                                throw new Error(err.message || 'Network response was not ok');
                            }).catch(() => {
                                throw new Error('Network response was not ok');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('[AddProduct] Server JSON response:', data);

                        if (data.success) {
                            // Close modal
                            const modal = bootstrap.Modal.getInstance(document.getElementById(
                                'addProductModal'));
                            if (modal) {
                                modal.hide();
                            }

                            // Reset form + preview
                            formEl.reset();
                            if (previewContainer) {
                                previewContainer.innerHTML = '';
                            }
                            document.getElementById('dynamicFieldsContainer').innerHTML = '';

                            showAlert('Product added successfully!', 'success');

                            console.log('[AddProduct] Product added successfully, reloading page...');
                            window.location.reload();
                        } else {
                            console.warn('[AddProduct] Server responded with success=false', data);
                            showAlert('Error adding product: ' + (data.message || 'Unknown error'),
                                'error');
                        }
                    })
                    .catch(error => {
                        console.error('[AddProduct] Fetch error:', error);
                        showAlert('Error adding product. Please try again.', 'error');
                    })
                    .finally(() => {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                        console.log('[AddProduct] Form submission finished (finally block)');
                    });
            });

            // Bulk Delete Functionality
            document.getElementById('selectAll').addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('#productsTableBody input[type="checkbox"]');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                toggleBulkDeleteButton();
            });

            function toggleBulkDeleteButton() {
                const selectedCount = document.querySelectorAll('#productsTableBody input[type="checkbox"]:checked')
                    .length;
                const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');

                if (selectedCount > 0) {
                    bulkDeleteBtn.style.display = 'inline-block';
                    bulkDeleteBtn.textContent = `Delete ${selectedCount} Selected`;
                } else {
                    bulkDeleteBtn.style.display = 'none';
                }
            }

            document.getElementById('bulkDeleteBtn').addEventListener('click', function() {
                const selectedIds = [];
                document.querySelectorAll('#productsTableBody input[type="checkbox"]:checked').forEach(
                    checkbox => {
                        selectedIds.push(checkbox.value);
                    });

                if (selectedIds.length > 0 && confirm(
                        `Are you sure you want to delete ${selectedIds.length} products?`)) {
                    fetch('{{ route('deleteproducts') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                ids: selectedIds
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showAlert('Products deleted successfully!', 'success');
                                window.location.reload();
                            } else {
                                showAlert('Error deleting products', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showAlert('Error deleting products', 'error');
                        });
                }
            });

            // Filter and Search Functionality
            const filters = {
                category: document.getElementById('categoryFilter'),
                status: document.getElementById('statusFilter'),
                stock: document.getElementById('stockFilter'),
                featured: document.getElementById('featuredFilter'),
                search: document.getElementById('tableSearch'),
                sortBy: document.getElementById('sortBy'),
                sortOrder: document.getElementById('sortOrder')
            };

            // Add event listeners for filters
            Object.values(filters).forEach(filter => {
                if (filter) {
                    filter.addEventListener('change', function() {
                        // For AJAX filtering, you would make a request here
                        // For now, we'll just submit the form to refresh with filters
                        window.location.href = updateUrlParams();
                    });
                }
            });

            // Update URL with filter parameters
            function updateUrlParams() {
                const params = new URLSearchParams();

                if (filters.category.value) params.append('category', filters.category.value);
                if (filters.status.value) params.append('status', filters.status.value);
                if (filters.stock.value) params.append('stock', filters.stock.value);
                if (filters.featured.value) params.append('featured', filters.featured.value);
                if (filters.search.value) params.append('search', filters.search.value);
                if (filters.sortBy.value) params.append('sort_by', filters.sortBy.value);
                if (filters.sortOrder.value) params.append('sort_order', filters.sortOrder.value);

                return window.location.pathname + '?' + params.toString();
            }

            // Add event listeners to row checkboxes
            document.querySelectorAll('.row-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', toggleBulkDeleteButton);
            });

            // Utility function for showing alerts
            function showAlert(message, type) {
                // Remove existing alerts
                const existingAlert = document.querySelector('.global-alert');
                if (existingAlert) {
                    existingAlert.remove();
                }

                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const alertHtml = `
                <div class="global-alert alert ${alertClass} alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999;">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;

                document.body.insertAdjacentHTML('beforeend', alertHtml);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    const alert = document.querySelector('.global-alert');
                    if (alert) {
                        alert.remove();
                    }
                }, 5000);
            }
        });

        // Edit Product Function
        function editProduct(id) {
            // Redirect to edit page or open edit modal
            window.location.href = `/products/${id}/edit`;
        }

        // Delete Product Function
        function deleteProduct(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                fetch(`/products/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            const alertDiv = document.createElement('div');
                            alertDiv.className = 'alert alert-success alert-dismissible fade show position-fixed';
                            alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999;';
                            alertDiv.innerHTML = `
                        Product deleted successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                            document.body.appendChild(alertDiv);

                            // Reload the page after a short delay
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        } else {
                            alert('Error deleting product');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error deleting product');
                    });
            }
        }
    </script>


  





    <!-- Add some custom CSS for better responsiveness -->
    <style>
        @media (max-width: 768px) {
            .card-body .row .col-md-3 {
                margin-bottom: 1rem;
            }

            .card-body .row .col-md-9 {
                padding-left: 0;
            }

            .table-responsive {
                font-size: 0.875rem;
            }

            .dropdown-menu {
                position: absolute !important;
            }
        }

        .global-alert {
            min-width: 300px;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }
    </style>
@endsection
