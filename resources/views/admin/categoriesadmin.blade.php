@extends('admin.layout')
@section('content')
    <div>
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
                        <h1>Categories</h1>
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
                        <button class="btn btn-primary" onclick="openModal('addCategoryModal')">
                            <i class="fas fa-plus"></i> Add New Category
                        </button>
                        <div class="filter-group">


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
                                    

                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $item)
                                    <tr>
                                        <td><input type="checkbox" class="row-checkbox" data-id="{{ $item->id }}"></td>
                                        <td>
                                            <div class="product-cell">
                                                <div class="product-image"><img style="width: 50px; height: 40px;" src="{{ asset('storage') }}/{{ $item->category_image }}" alt="" srcset=""></div>
                                                <span>{{ $item->name }}</span>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn-icon" title="Edit"><i class="fas fa-edit"></i></button>
                                                <button class="btn-icon" title="Delete"><i
                                                        class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>No categories to show</td>

                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
<div class="table-pagination">
    <span>
        Showing {{ $categories->firstItem() }}-{{ $categories->lastItem() }}
        of {{ $categories->total() }} categories
    </span>

    <div class="pagination-buttons">
        {{-- Previous --}}
        @if ($categories->onFirstPage())
            <button class="btn-pagination" disabled>
                <i class="fas fa-chevron-left"></i>
            </button>
        @else
            <a href="{{ $categories->previousPageUrl() }}" class="btn-pagination">
                <i class="fas fa-chevron-left"></i>
            </a>
        @endif

        {{-- Page Numbers --}}
        @for ($i = 1; $i <= $categories->lastPage(); $i++)
            @if ($i == $categories->currentPage())
                <span class="btn-pagination active">{{ $i }}</span>
            @else
                <a href="{{ $categories->url($i) }}" class="btn-pagination">{{ $i }}</a>
            @endif
        @endfor

        {{-- Next --}}
        @if ($categories->hasMorePages())
            <a href="{{ $categories->nextPageUrl() }}" class="btn-pagination">
                <i class="fas fa-chevron-right"></i>
            </a>
        @else
            <button class="btn-pagination" disabled>
                <i class="fas fa-chevron-right"></i>
            </button>
        @endif
    </div>
</div>


                    </div>
                </div>
            </main>

            <div id="addCategoryModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Add New Category</h2>
                        <button class="modal-close" onclick="closeModal('addCategoryModal')">&times;</button>
                    </div>

                    <div class="modal-body">

                        <!-- Category Name -->
                        <div class="form-group">
                            <label>Category Name</label>
                            <input type="text" class="form-input" name="name" placeholder="Enter category name">
                        </div>

                        <!-- Single Image Upload -->
                        <div class="form-group">
                            <label>Category Image</label>
                            <input type="file" class="form-input" name="category_image" accept="image/*">

                            <small>Upload one image only (max 300x300px)</small>
                            <div id="imagePreviewContainer" style="margin-top:10px;">
                                <img id="imagePreview" src="" alt=""
                                    style="display:none; max-width:150px; max-height:150px; border-radius:6px; border:1px solid #ccc;">
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" onclick="closeModal('addCategoryModal')">Cancel</button>
                        <button class="btn btn-primary">Add Category</button>
                    </div>
                </div>
            </div>


            <!--category add script-->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const addCategoryModal = document.getElementById('addCategoryModal');
                    const addButton = addCategoryModal.querySelector('.btn-primary');
                    const nameInput = addCategoryModal.querySelector('input[name="name"]');
                    const imageInput = addCategoryModal.querySelector('input[name="category_image"]');
                    const previewImg = document.getElementById('imagePreview');

                    // Handle image preview & validation
                    imageInput.addEventListener('change', function() {
                        const file = this.files[0];
                        if (!file) {
                            previewImg.style.display = 'none';
                            return;
                        }

                        const img = new Image();
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            img.src = e.target.result;
                        };

                        img.onload = function() {
                            // if (img.width > 500 || img.height > 500) {
                            //     toastr.error('Image dimensions must not exceed 300x300 pixels.');
                            //     imageInput.value = '';
                            //     previewImg.style.display = 'none';
                            //     return;
                            // }

                            // Display preview
                            previewImg.src = img.src;
                            previewImg.style.display = 'block';
                        };

                        reader.readAsDataURL(file);
                    });

                    addButton.addEventListener('click', async function(e) {
                        e.preventDefault();

                        if (addButton.disabled) return; // Prevent multiple submits

                        if (!nameInput.value.trim()) {
                            toastr.warning("Please enter a category name.");
                            return;
                        }

                        const formData = new FormData();
                        formData.append('name', nameInput.value);

                        if (imageInput.files.length > 0) {
                            formData.append('category_image', imageInput.files[0]);
                        }

                        // Add CSRF token for Laravel
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content');
                        formData.append('_token', csrfToken);

                        // Set button to loading state
                        addButton.disabled = true;
                        const originalText = addButton.innerHTML;
                        addButton.innerHTML =
                        '<span class="spinner-border spinner-border-sm"></span> Saving...';

                        try {
                            const response = await fetch("{{ route('createcategoryadmin') }}", {
                                method: "POST",
                                headers: {
                                    "Accept": "application/json", // ✅ tells Laravel to return JSON
                                },
                                body: formData,
                            });

                            const data = await response.json();

                            if (response.ok) {
                                toastr.success(data.message || "✅ Category created successfully!");
                                nameInput.value = '';
                                imageInput.value = '';
                                previewImg.style.display = 'none';
                                closeModal('addCategoryModal');
                                location.reload();
                            } else {
                                toastr.error(data.message ||
                                    "❌ Failed to create category. Please check input and try again.");
                            }

                        } catch (error) {
                            console.error(error);
                            toastr.error("⚠️ An unexpected error occurred. Please try again.");
                        } finally {
                            addButton.disabled = false;
                            addButton.innerHTML = originalText;
                        }
                    });
                });

                // Helper to close modal
                function closeModal(modalId) {
                    document.getElementById(modalId).style.display = 'none';
                }
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
                       
                        const selectedIds = Array.from(document.querySelectorAll(".row-checkbox:checked"))
                            .map(cb => cb.getAttribute("data-id"));

                        // === Case 1: Bulk Delete ===
                        if (action === "Delete") {
                            if (selectedIds.length === 0) {
                                alert("Please select at least one product to delete.");
                                return;
                            }
                            if (!confirm("Are you sure you want to delete selected products?")) return;

                            fetch("{{ route('deletecategory') }}", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                        "X-Requested-With": "XMLHttpRequest" 
                                    },
                                    body: JSON.stringify({
                                        ids: selectedIds
                                    })
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        
                                        alert(data.message || "Categories deleted successfully!");
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


                    });
                });
            </script>


        </div>
    </div>
@endsection
