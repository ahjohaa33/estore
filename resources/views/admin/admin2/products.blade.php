@extends('admin.admin2.layout2')
@section('admin2')
    <main class="main-wrap">
        <header class="main-header navbar">
            <div class="col-search">
                <form class="searchform">
                    <div class="input-group">
                        <input class="form-control" list="search_terms" type="text" placeholder="Search term">
                        <button class="btn btn-light bg" type="button"><i class="material-icons md-search"></i></button>
                    </div>
                    <datalist id="search_terms">
                        <option value="Products"></option>
                        <option value="New orders"></option>
                        <option value="Apple iphone"></option>
                        <option value="Ahmed Hassan"></option>
                    </datalist>
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
          <div class="col-6">
            <div class="content-header">
              <h2 class="content-title">Add New Product</h2>
              <div>
                <button class="btn btn-light rounded font-sm mr-5 text-body hover-up">Save to draft</button>
                <button class="btn btn-md rounded font-sm hover-up">Publich</button>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
    <div class="col-lg-6">
        <div class="card mb-4">
            <div class="card-body">
                <form id="productForm" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Section 1: General Info -->
                    <div class="row">
                        <div class="col-md-3">
                            <h6>1. General info</h6>
                        </div>
                        <div class="col-md-9">
                            <div class="mb-4">
                                <label class="form-label">Product Name *</label>
                                <input class="form-control" name="name" type="text" placeholder="Enter product name" required>
                                <div class="invalid-feedback" id="nameError"></div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Specification</label>
                                <textarea class="form-control" name="specification" placeholder="Product specifications and details..." rows="4"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label">Color</label>
                                        <input class="form-control" name="color" type="text" placeholder="e.g., Red, Blue, Green">
                                        <div class="form-text">Separate multiple colors with commas</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label">Size</label>
                                        <input class="form-control" name="size" type="text" placeholder="e.g., S, M, L, XL">
                                        <div class="form-text">Separate multiple sizes with commas</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="mb-4 mt-0">
                    
                    <!-- Section 2: Pricing -->
                    <div class="row">
                        <div class="col-md-3">
                            <h6>2. Pricing</h6>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label">Price *</label>
                                        <input class="form-control" name="price" type="number" step="0.01" min="0" placeholder="$00.00" required>
                                        <div class="invalid-feedback" id="priceError"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label">Offer Price</label>
                                        <input class="form-control" name="offer_price" type="number" step="0.01" min="0" placeholder="$00.00">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Offer Duration</label>
                                <input class="form-control" name="offer_duration" type="datetime-local">
                                <div class="form-text">Set the end date and time for the offer price</div>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="mb-4 mt-0">
                    
                    <!-- Section 3: Category -->
                    <div class="row">
                        <div class="col-md-3">
                            <h6>3. Category</h6>
                        </div>
                        <div class="col-md-9">
                            <div class="mb-4">
                                <label class="form-label">Product Category</label>
                                <select class="form-select" name="category">
                                    <option value="">Select Category</option>
                                    @foreach($cats as $category)
                                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="mb-4 mt-0">
                    
                    <!-- Section 4: Inventory -->
                    <div class="row">
                        <div class="col-md-3">
                            <h6>4. Inventory</h6>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label">In Stock *</label>
                                        <input class="form-control" name="in_stock" type="number" min="0" placeholder="0" required>
                                        <div class="invalid-feedback" id="inStockError"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label">Sale Count</label>
                                        <input class="form-control" name="sale_count" type="number" min="0" placeholder="0" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="mb-4 mt-0">
                    
                    <!-- Section 5: Status & Flags -->
                    <div class="row">
                        <div class="col-md-3">
                            <h6>5. Status & Flags</h6>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label">Status</label>
                                        <select class="form-select" name="status">
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                            <option value="draft">Draft</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label">Product Flags</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="isFeatured">
                                            <label class="form-check-label" for="isFeatured">
                                                Featured Product
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="is_fav" value="1" id="isFav">
                                            <label class="form-check-label" for="isFav">
                                                Mark as Favorite
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="mb-4 mt-0">
                    
                    <!-- Section 6: Media -->
                    <div class="row">
                        <div class="col-md-3">
                            <h6>6. Media</h6>
                        </div>
                        <div class="col-md-9">
                            <div class="mb-4">
                                <label class="form-label">Product Images</label>
                                <input class="form-control" name="images[]" type="file" multiple accept="image/*">
                                <div class="form-text">You can select multiple images</div>
                            </div>
                            <div class="mb-4" id="imagePreviewContainer" style="display: none;">
                                <label class="form-label">Image Previews</label>
                                <div class="d-flex flex-wrap gap-2" id="imagePreviews"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submit Buttons -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-light rounded font-sm mr-5 text-body hover-up" id="saveDraftBtn">Save to draft</button>
                                <button type="button" class="btn btn-md rounded font-sm hover-up" id="publishBtn">Publish</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
      </section>




            <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert"
                style="display: none;">
                <strong>Success!</strong> Product created successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <div class="bulk-actions" id="bulkActions">
                <span id="selectedCount">0 products selected</span>
                <button class="btn btn-danger btn-sm" id="bulkDeleteBtn">Delete Selected</button>
                <button class="btn btn-light btn-sm" id="clearSelectionBtn">Clear Selection</button>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-body">
                        <form id="editProductForm" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="edit_product_id" name="id">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="edit_product_name" class="form-label">Product Name *</label>
                                        <input type="text" class="form-control" id="edit_product_name" name="name" required>
                                        <div class="invalid-feedback" id="editNameError"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="edit_product_price" class="form-label">Price *</label>
                                        <input type="number" class="form-control" id="edit_product_price" name="price" step="0.01" min="0" required>
                                        <div class="invalid-feedback" id="editPriceError"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="edit_product_offer_price" class="form-label">Offer Price</label>
                                        <input type="number" class="form-control" id="edit_product_offer_price" name="offer_price" step="0.01" min="0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="edit_product_offer_duration" class="form-label">Offer Duration</label>
                                        <input type="datetime-local" class="form-control" id="edit_product_offer_duration" name="offer_duration">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="edit_product_in_stock" class="form-label">In Stock *</label>
                                        <input type="number" class="form-control" id="edit_product_in_stock" name="in_stock" min="0" required>
                                        <div class="invalid-feedback" id="editInStockError"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="edit_product_category" class="form-label">Category</label>
                                        <select class="form-select" id="edit_product_category" name="category">
                                            <option value="">Select Category</option>
                                            @foreach($cats as $category)
                                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="edit_product_color" class="form-label">Color</label>
                                        <input type="text" class="form-control" id="edit_product_color" name="color" placeholder="e.g., Red, Blue, Green">
                                        <div class="form-text">Separate multiple colors with commas</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="edit_product_size" class="form-label">Size</label>
                                        <input type="text" class="form-control" id="edit_product_size" name="size" placeholder="e.g., S, M, L, XL">
                                        <div class="form-text">Separate multiple sizes with commas</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="edit_product_status" class="form-label">Status</label>
                                        <select class="form-select" id="edit_product_status" name="status">
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                            <option value="draft">Draft</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="edit_product_sale_count" class="form-label">Sale Count</label>
                                        <input type="number" class="form-control" id="edit_product_sale_count" name="sale_count" min="0">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_product_specification" class="form-label">Specification</label>
                                <textarea class="form-control" id="edit_product_specification" name="specification" rows="4" placeholder="Product specifications and details..."></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="edit_product_is_featured" name="is_featured" value="1">
                                        <label class="form-check-label" for="edit_product_is_featured">Featured Product</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="edit_product_is_fav" name="is_fav" value="1">
                                        <label class="form-check-label" for="edit_product_is_fav">Mark as Favorite</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_product_images" class="form-label">Product Images</label>
                                <input class="form-control" type="file" id="edit_product_images" name="images[]" multiple accept="image/*">
                                <div class="form-text">You can select multiple images</div>
                            </div>
                            
                            <div class="mb-3" id="editImagePreviewContainer">
                                <label class="form-label">Current Images</label>
                                <div class="d-flex flex-wrap gap-2" id="editImagePreviews"></div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="productsTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                                </div>
                                            </th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                            <th>Status</th>
                                            
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productsTableBody">
                                        @foreach ($products as $product)
                                            <tr data-id="{{ $product->id }}">
                                                <td class="text-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input row-checkbox" type="checkbox"
                                                            value="{{ $product->id }}">
                                                    </div>
                                                </td>
                                                <td>{{ $product->id }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if ($product->images && count($product->images) > 0)
                                                            <img src="{{ asset('storage/' . $product->images[0]) }}"
                                                                alt="{{ $product->title }}"
                                                                class="product-image-preview me-2">
                                                        @else
                                                            <div class="product-image-placeholder me-2">No Image</div>
                                                        @endif
                                                        <div>
                                                            <b>{{ $product->title }}</b>
                                                            @if ($product->brand)
                                                                <div class="text-muted small">{{ $product->brand }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                                                <td>${{ number_format($product->price, 2) }}</td>
                                                <td>
                                                    <span
                                                        class="badge {{ $product->quantity > 0 ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $product->quantity }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge {{ $product->status === 'published' ? 'bg-success' : 'bg-secondary' }}">
                                                        {{ ucfirst($product->status) }}
                                                    </span>
                                                </td>
                                                <td class="text-end">
                                                    <div class="dropdown">
                                                        <a class="btn btn-light rounded btn-sm font-sm" href="#"
                                                            data-bs-toggle="dropdown">
                                                            <i class="material-icons md-more_horiz"></i>
                                                        </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item edit-product" href="#"
                                                                data-id="{{ $product->id }}">Edit info</a>
                                                            <a class="dropdown-item text-danger delete-product"
                                                                href="#" data-id="{{ $product->id }}">Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="text-muted" id="tableInfo">
                                    Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of
                                    {{ $products->total() }} entries
                                </div>
                                {{ $products->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

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

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_product_id" name="id">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_product_name" class="form-label">Product Name *</label>
                                    <input type="text" class="form-control" id="edit_product_name" name="name"
                                        required>
                                    <div class="invalid-feedback" id="editNameError"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_product_price" class="form-label">Price *</label>
                                    <input type="number" class="form-control" id="edit_product_price" name="price"
                                        step="0.01" min="0" required>
                                    <div class="invalid-feedback" id="editPriceError"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_product_offer_price" class="form-label">Offer Price</label>
                                    <input type="number" class="form-control" id="edit_product_offer_price"
                                        name="offer_price" step="0.01" min="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_product_offer_duration" class="form-label">Offer Duration</label>
                                    <input type="datetime-local" class="form-control" id="edit_product_offer_duration"
                                        name="offer_duration">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_product_in_stock" class="form-label">In Stock *</label>
                                    <input type="number" class="form-control" id="edit_product_in_stock"
                                        name="in_stock" min="0" required>
                                    <div class="invalid-feedback" id="editInStockError"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_product_category" class="form-label">Category</label>
                                    <select class="form-select" id="edit_product_category" name="category">
                                        <option value="">Select Category</option>
                                        @foreach ($cats as $category)
                                            <option value="{{ $category->name }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_product_color" class="form-label">Color</label>
                                    <input type="text" class="form-control" id="edit_product_color" name="color"
                                        placeholder="e.g., Red, Blue, Green">
                                    <div class="form-text">Separate multiple colors with commas</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_product_size" class="form-label">Size</label>
                                    <input type="text" class="form-control" id="edit_product_size" name="size"
                                        placeholder="e.g., S, M, L, XL">
                                    <div class="form-text">Separate multiple sizes with commas</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_product_status" class="form-label">Status</label>
                                    <select class="form-select" id="edit_product_status" name="status">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                        <option value="draft">Draft</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_product_sale_count" class="form-label">Sale Count</label>
                                    <input type="number" class="form-control" id="edit_product_sale_count"
                                        name="sale_count" min="0">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="edit_product_specification" class="form-label">Specification</label>
                            <textarea class="form-control" id="edit_product_specification" name="specification" rows="4"
                                placeholder="Product specifications and details..."></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="edit_product_is_featured"
                                        name="is_featured" value="1">
                                    <label class="form-check-label" for="edit_product_is_featured">Featured
                                        Product</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="edit_product_is_fav"
                                        name="is_fav" value="1">
                                    <label class="form-check-label" for="edit_product_is_fav">Mark as Favorite</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="edit_product_images" class="form-label">Product Images</label>
                            <input class="form-control" type="file" id="edit_product_images" name="images[]" multiple
                                accept="image/*">
                            <div class="form-text">You can select multiple images</div>
                        </div>

                        <div class="mb-3" id="editImagePreviewContainer">
                            <label class="form-label">Current Images</label>
                            <div class="d-flex flex-wrap gap-2" id="editImagePreviews"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="updateProductBtn">Update Product</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteProductModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this product? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DOM Elements
            const productForm = document.getElementById('productForm');
            const productsTableBody = document.getElementById('productsTableBody');
            const selectAllCheckbox = document.getElementById('selectAll');
            const bulkActions = document.getElementById('bulkActions');
            const selectedCount = document.getElementById('selectedCount');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const clearSelectionBtn = document.getElementById('clearSelectionBtn');
            const successAlert = document.getElementById('successAlert');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            const imagePreviews = document.getElementById('imagePreviews');
            const editProductModal = new bootstrap.Modal(document.getElementById('editProductModal'));
            const deleteProductModal = new bootstrap.Modal(document.getElementById('deleteProductModal'));
            const updateProductBtn = document.getElementById('updateProductBtn');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            const saveDraftBtn = document.getElementById('saveDraftBtn');
            const publishBtn = document.getElementById('publishBtn');

            // Image preview for create form
            document.querySelector('input[name="images[]"]').addEventListener('change', function(e) {
                const files = e.target.files;
                const imagePreviews = document.getElementById('imagePreviews');
                imagePreviews.innerHTML = '';
                
                if (files.length > 0) {
                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.className = 'product-image-preview';
                                imagePreviews.appendChild(img);
                            }
                            reader.readAsDataURL(file);
                        }
                    }
                    document.getElementById('imagePreviewContainer').style.display = 'block';
                } else {
                    document.getElementById('imagePreviewContainer').style.display = 'none';
                }
            });

            // Form submission with AJAX
            function submitProductForm(status) {
                const formData = new FormData(document.getElementById('productForm'));
                formData.append('status', status);
                
                // Reset validation
                resetValidation();
                
                // Show loading state
                const submitBtn = status === 'draft' ? document.getElementById('saveDraftBtn') : document.getElementById('publishBtn');
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
                
                fetch("{{ route('createproduct') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        const successAlert = document.getElementById('successAlert');
                        successAlert.style.display = 'block';
                        successAlert.querySelector('strong').textContent = `Success! Product ${status === 'published' ? 'published' : 'saved to draft'} successfully.`;
                        
                        // Reset form
                        document.getElementById('productForm').reset();
                        document.getElementById('imagePreviewContainer').style.display = 'none';
                        
                        // Add new product to table
                        addProductToTable(data.product);
                        
                        // Hide success message after 3 seconds
                        setTimeout(() => {
                            successAlert.style.display = 'none';
                        }, 3000);
                    } else {
                        // Show validation errors
                        showValidationErrors(data.errors);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while creating the product');
                })
                .finally(() => {
                    // Reset button state
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                });
            }

            // Save as draft
            document.getElementById('saveDraftBtn').addEventListener('click', function(e) {
                e.preventDefault();
                submitProductForm('draft');
            });

            // Publish product
            document.getElementById('publishBtn').addEventListener('click', function(e) {
                e.preventDefault();
                submitProductForm('active'); // Using 'active' as published status
            });

            // Edit product event delegation
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('edit-product') || e.target.parentElement.classList
                    .contains('edit-product')) {
                    e.preventDefault();
                    const productId = e.target.dataset.id || e.target.parentElement.dataset.id;
                    loadProductData(productId);
                }

                if (e.target.classList.contains('delete-product') || e.target.parentElement.classList
                    .contains('delete-product')) {
                    e.preventDefault();
                    const productId = e.target.dataset.id || e.target.parentElement.dataset.id;
                    confirmDeleteBtn.dataset.id = productId;
                    deleteProductModal.show();
                }
            });

            // Update product
            updateProductBtn.addEventListener('click', function() {
                const formData = new FormData(document.getElementById('editProductForm'));
                const productId = document.getElementById('edit_product_id').value;

                // Reset validation
                resetEditValidation();

                fetch(`/products/${productId}`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update table row
                            updateProductInTable(data.product);

                            // Close modal
                            editProductModal.hide();

                            // Show success message
                            showTemporaryAlert('Product updated successfully', 'success');
                        } else {
                            // Show validation errors
                            showEditValidationErrors(data.errors);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while updating the product');
                    });
            });

            // Confirm delete
            confirmDeleteBtn.addEventListener('click', function() {
                const productId = this.dataset.id;

                fetch(`/products/${productId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove from table
                            document.querySelector(`tr[data-id="${productId}"]`).remove();

                            // Close modal
                            deleteProductModal.hide();

                            // Show success message
                            showTemporaryAlert('Product deleted successfully', 'success');

                            // Update table info
                            updateTableInfo();
                        } else {
                            alert('Error deleting product');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the product');
                    });
            });

            // Bulk actions
            selectAllCheckbox.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.row-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateBulkActions();
            });

            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('row-checkbox')) {
                    updateBulkActions();
                }
            });

            bulkDeleteBtn.addEventListener('click', function() {
                const selectedIds = getSelectedProductIds();
                if (selectedIds.length === 0) return;

                if (confirm(`Are you sure you want to delete ${selectedIds.length} products?`)) {
                    fetch("{{ route('deleteproducts') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                ids: selectedIds
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Remove deleted rows
                                selectedIds.forEach(id => {
                                    document.querySelector(`tr[data-id="${id}"]`).remove();
                                });

                                // Reset bulk actions
                                selectAllCheckbox.checked = false;
                                updateBulkActions();

                                // Show success message
                                showTemporaryAlert(
                                    `${selectedIds.length} products deleted successfully`, 'success'
                                );

                                // Update table info
                                updateTableInfo();
                            } else {
                                alert('Error deleting products');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while deleting products');
                        });
                }
            });

            clearSelectionBtn.addEventListener('click', function() {
                const checkboxes = document.querySelectorAll('.row-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
                selectAllCheckbox.checked = false;
                updateBulkActions();
            });

            // Helper functions
            function loadProductData(productId) {
                fetch(`/products/${productId}/edit`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('edit_product_id').value = data.id;
                        document.getElementById('edit_product_name').value = data.name;
                        document.getElementById('edit_product_price').value = data.price;
                        document.getElementById('edit_product_offer_price').value = data.offer_price || '';
                        document.getElementById('edit_product_offer_duration').value = data.offer_duration ?
                            data.offer_duration.replace(' ', 'T').substring(0, 16) : '';
                        document.getElementById('edit_product_in_stock').value = data.in_stock;
                        document.getElementById('edit_product_category').value = data.category || '';
                        document.getElementById('edit_product_color').value = data.color || '';
                        document.getElementById('edit_product_size').value = data.size || '';
                        document.getElementById('edit_product_status').value = data.status || 'active';
                        document.getElementById('edit_product_sale_count').value = data.sale_count || 0;
                        document.getElementById('edit_product_specification').value = data.specification || '';
                        document.getElementById('edit_product_is_featured').checked = data.is_featured == 1;
                        document.getElementById('edit_product_is_fav').checked = data.is_fav == 1;

                        // Set image previews
                        const editImagePreviews = document.getElementById('editImagePreviews');
                        editImagePreviews.innerHTML = '';

                        if (data.images) {
                            try {
                                const images = typeof data.images === 'string' ? JSON.parse(data.images) : data
                                    .images;
                                if (Array.isArray(images) && images.length > 0) {
                                    images.forEach(image => {
                                        const img = document.createElement('img');
                                        img.src = "{{ asset('storage/') }}/" + image;
                                        img.className = 'product-image-preview';
                                        editImagePreviews.appendChild(img);
                                    });
                                    document.getElementById('editImagePreviewContainer').style.display =
                                        'block';
                                } else {
                                    document.getElementById('editImagePreviewContainer').style.display = 'none';
                                }
                            } catch (e) {
                                console.error('Error parsing images:', e);
                                document.getElementById('editImagePreviewContainer').style.display = 'none';
                            }
                        } else {
                            document.getElementById('editImagePreviewContainer').style.display = 'none';
                        }

                        editProductModal.show();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while loading product data');
                    });
            }

            function addProductToTable(product) {
                const newRow = document.createElement('tr');
                newRow.setAttribute('data-id', product.id);
                newRow.innerHTML = `
                <td class="text-center">
                    <div class="form-check">
                        <input class="form-check-input row-checkbox" type="checkbox" value="${product.id}">
                    </div>
                </td>
                <td>${product.id}</td>
                <td>
                    <div class="d-flex align-items-center">
                        ${product.images && product.images.length > 0 ? 
                            `<img src="{{ asset('storage/') }}/${product.images[0]}" alt="${product.title}" class="product-image-preview me-2">` : 
                            '<div class="product-image-placeholder me-2">No Image</div>'
                        }
                        <div>
                            <b>${product.title}</b>
                            ${product.brand ? `<div class="text-muted small">${product.brand}</div>` : ''}
                        </div>
                    </div>
                </td>
                <td>${product.category ? product.category.name : 'N/A'}</td>
                <td>$${parseFloat(product.price).toFixed(2)}</td>
                <td>
                    <span class="badge ${product.quantity > 0 ? 'bg-success' : 'bg-danger'}">
                        ${product.quantity}
                    </span>
                </td>
                <td>
                    <span class="badge ${product.status === 'published' ? 'bg-success' : 'bg-secondary'}">
                        ${product.status.charAt(0).toUpperCase() + product.status.slice(1)}
                    </span>
                </td>
                <td class="text-end">
                    <div class="dropdown">
                        <a class="btn btn-light rounded btn-sm font-sm" href="#" data-bs-toggle="dropdown">
                            <i class="material-icons md-more_horiz"></i>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item edit-product" href="#" data-id="${product.id}">Edit info</a>
                            <a class="dropdown-item text-danger delete-product" href="#" data-id="${product.id}">Delete</a>
                        </div>
                    </div>
                </td>
            `;
                productsTableBody.appendChild(newRow);
                updateTableInfo();
            }

            function updateProductInTable(product) {
                const row = document.querySelector(`tr[data-id="${product.id}"]`);
                if (row) {
                    // Update product name
                    row.querySelector('td:nth-child(3) b').textContent = product.name;

                    // Update category
                    row.querySelector('td:nth-child(4)').textContent = product.category || 'N/A';

                    // Update price
                    row.querySelector('td:nth-child(5)').textContent = '$' + parseFloat(product.price).toFixed(2);

                    // Update stock
                    const stockBadge = row.querySelector('td:nth-child(6) span');
                    stockBadge.textContent = product.in_stock;
                    stockBadge.className = `badge ${product.in_stock > 0 ? 'bg-success' : 'bg-danger'}`;

                    // Update status
                    const statusBadge = row.querySelector('td:nth-child(7) span');
                    statusBadge.textContent = product.status.charAt(0).toUpperCase() + product.status.slice(1);
                    statusBadge.className =
                        `badge ${product.status === 'active' ? 'bg-success' : product.status === 'inactive' ? 'bg-danger' : 'bg-secondary'}`;

                    // Update featured status if column exists
                    const featuredCell = row.querySelector('td:nth-child(8)');
                    if (featuredCell) {
                        featuredCell.innerHTML = product.is_featured == 1 ?
                            '<i class="material-icons md-star text-warning"></i>' :
                            '<i class="material-icons md-star_border text-muted"></i>';
                    }
                }
            }

            function updateBulkActions() {
                const selectedIds = getSelectedProductIds();
                const count = selectedIds.length;

                if (count > 0) {
                    bulkActions.classList.add('show');
                    selectedCount.textContent = `${count} product${count === 1 ? '' : 's'} selected`;
                } else {
                    bulkActions.classList.remove('show');
                }

                // Update select all checkbox state
                const totalCheckboxes = document.querySelectorAll('.row-checkbox').length;
                const checkedCheckboxes = document.querySelectorAll('.row-checkbox:checked').length;
                selectAllCheckbox.checked = totalCheckboxes > 0 && checkedCheckboxes === totalCheckboxes;
                selectAllCheckbox.indeterminate = totalCheckboxes > 0 && checkedCheckboxes > 0 &&
                    checkedCheckboxes < totalCheckboxes;
            }

            function getSelectedProductIds() {
                const checkboxes = document.querySelectorAll('.row-checkbox:checked');
                return Array.from(checkboxes).map(checkbox => checkbox.value);
            }


            function resetValidation() {
    const inputs = document.getElementById('productForm').querySelectorAll('.is-invalid');
    inputs.forEach(input => {
        input.classList.remove('is-invalid');
    });
}

function showValidationErrors(errors) {
    for (const field in errors) {
        const input = document.querySelector(`[name="${field}"]`);
        const errorDiv = document.getElementById(field + 'Error');
        
        if (input && errorDiv) {
            input.classList.add('is-invalid');
            errorDiv.textContent = errors[field][0];
        }
    }
}

function addProductToTable(product) {
    const productsTableBody = document.getElementById('productsTableBody');
    const newRow = document.createElement('tr');
    newRow.setAttribute('data-id', product.id);
    newRow.innerHTML = `
        <td class="text-center">
            <div class="form-check">
                <input class="form-check-input row-checkbox" type="checkbox" value="${product.id}">
            </div>
        </td>
        <td>${product.id}</td>
        <td>
            <div class="d-flex align-items-center">
                ${product.images ? 
                    `<img src="{{ asset('storage/') }}/${JSON.parse(product.images)[0]}" alt="${product.name}" class="product-image-preview me-2">` : 
                    '<div class="product-image-placeholder me-2">No Image</div>'
                }
                <div>
                    <b>${product.name}</b>
                </div>
            </div>
        </td>
        <td>${product.category || 'N/A'}</td>
        <td>$${parseFloat(product.price).toFixed(2)}</td>
        <td>
            <span class="badge ${product.in_stock > 0 ? 'bg-success' : 'bg-danger'}">
                ${product.in_stock}
            </span>
        </td>
        <td>
            <span class="badge ${product.status === 'active' ? 'bg-success' : product.status === 'inactive' ? 'bg-danger' : 'bg-secondary'}">
                ${product.status.charAt(0).toUpperCase() + product.status.slice(1)}
            </span>
        </td>
        <td>
            ${product.is_featured == 1 ? 
                '<i class="material-icons md-star text-warning"></i>' : 
                '<i class="material-icons md-star_border text-muted"></i>'
            }
        </td>
        <td class="text-end">
            <div class="dropdown">
                <a class="btn btn-light rounded btn-sm font-sm" href="#" data-bs-toggle="dropdown">
                    <i class="material-icons md-more_horiz"></i>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item edit-product" href="#" data-id="${product.id}">Edit info</a>
                    <a class="dropdown-item text-danger delete-product" href="#" data-id="${product.id}">Delete</a>
                </div>
            </div>
        </td>
    `;
    productsTableBody.appendChild(newRow);
    updateTableInfo();
}

         

            function showEditValidationErrors(errors) {
                for (const field in errors) {
                    const input = document.getElementById('edit_product_' + field);
                    const errorDiv = document.getElementById('edit' + field.charAt(0).toUpperCase() + field.slice(
                        1) + 'Error');

                    if (input && errorDiv) {
                        input.classList.add('is-invalid');
                        errorDiv.textContent = errors[field][0];
                    }
                }
            }

         

            function resetEditValidation() {
                const inputs = document.getElementById('editProductForm').querySelectorAll('.is-invalid');
                inputs.forEach(input => {
                    input.classList.remove('is-invalid');
                });
            }

            function showTemporaryAlert(message, type) {
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
                alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;

                document.querySelector('.content-main').insertBefore(alertDiv, document.querySelector('.card'));

                setTimeout(() => {
                    alertDiv.remove();
                }, 3000);
            }

            function updateTableInfo() {
                const totalRows = document.querySelectorAll('#productsTableBody tr').length;
                document.getElementById('tableInfo').textContent = `Showing ${totalRows} of ${totalRows} entries`;
            }
        });
    </script>

    <style>
        .product-image-preview {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 0.25rem;
        }

        .product-image-placeholder {
            width: 50px;
            height: 50px;
            background-color: #f8f9fa;
            border: 1px dashed #dee2e6;
            border-radius: 0.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            color: #6c757d;
        }

        .bulk-actions {
            display: none;
            margin-bottom: 1rem;
            padding: 0.75rem;
            background-color: #f8f9fa;
            border-radius: 0.375rem;
        }

        .bulk-actions.show {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        @media (max-width: 992px) {
            .content-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .table-responsive {
                font-size: 0.875rem;
            }

            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
        }
    </style>
@endsection
