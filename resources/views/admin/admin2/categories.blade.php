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
            <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside"><i class="material-icons md-apps"></i></button>
            <ul class="nav">
                <li class="nav-item"><a class="nav-link btn-icon" href="#"><i class="material-icons md-notifications animation-shake"></i><span class="badge rounded-pill">3</span></a></li>
                <li class="nav-item"><a class="nav-link btn-icon darkmode" href="#"><i class="material-icons md-nights_stay"></i></a></li>
                <li class="nav-item"><a class="requestfullscreen nav-link btn-icon" href="#"><i class="material-icons md-cast"></i></a></li>
                <li class="dropdown nav-item"><a class="dropdown-toggle" id="dropdownLanguage" data-bs-toggle="dropdown" href="#" aria-expanded="false"><i class="material-icons md-public"></i></a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownLanguage"><a class="dropdown-item text-brand" href="#"><img src="assets/imgs/theme/flag-us.png" alt="English">English</a><a class="dropdown-item" href="#"><img src="assets/imgs/theme/flag-fr.png" alt="Français">Fran&ccedil;ais</a><a class="dropdown-item" href="#"><img src="assets/imgs/theme/flag-jp.png" alt="Français">&#x65E5;&#x672C;&#x8A9E;</a><a class="dropdown-item" href="#"><img src="assets/imgs/theme/flag-cn.png" alt="Français">&#x4E2D;&#x56FD;&#x4EBA;</a></div>
                </li>
                <li class="dropdown nav-item"><a class="dropdown-toggle" id="dropdownAccount" data-bs-toggle="dropdown" href="#" aria-expanded="false"><img class="img-xs rounded-circle" src="assets/imgs/people/avatar2.jpg" alt="User"></a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownAccount"><a class="dropdown-item" href="#"><i class="material-icons md-perm_identity"></i>Edit Profile</a><a class="dropdown-item" href="#"><i class="material-icons md-settings"></i>Account Settings</a><a class="dropdown-item" href="#"><i class="material-icons md-account_balance_wallet"></i>Wallet</a><a class="dropdown-item" href="#"><i class="material-icons md-receipt"></i>Billing</a><a class="dropdown-item" href="#"><i class="material-icons md-help_outline"></i>Help center</a>
                        <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#"><i class="material-icons md-exit_to_app"></i>Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </header>
    
    <section class="content-main">
        <div class="content-header">
            <div>
                <h2 class="content-title card-title">Categories</h2>
                <p>Add, edit or delete a category</p>
            </div>
            <div>
                <input class="form-control bg-white" type="text" placeholder="Search Categories" id="searchInput">
            </div>
        </div>
        
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert" style="display: none;">
            <strong>Success!</strong> Category created successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        
        <div class="bulk-actions" id="bulkActions">
            <span id="selectedCount">0 categories selected</span>
            <button class="btn btn-danger btn-sm" id="bulkDeleteBtn">Delete Selected</button>
            <button class="btn btn-light btn-sm" id="clearSelectionBtn">Clear Selection</button>
        </div>
        
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <form id="categoryForm" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label" for="name">Category Name *</label>
                                <input class="form-control" id="name" name="name" type="text" placeholder="Enter category name" required>
                                <div class="invalid-feedback" id="nameError"></div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="category_image">Category Image</label>
                                <input class="form-control" id="category_image" name="category_image" type="file" accept="image/*">
                                <div class="form-text">Upload an image for this category (optional)</div>
                            </div>
                            <div class="mb-4" id="imagePreviewContainer" style="display: none;">
                                <label class="form-label">Image Preview</label>
                                <div>
                                    <img id="imagePreview" src="#" alt="Image Preview" class="category-image-preview">
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary" id="submitBtn">Create Category</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-9">
                        <div class="table-responsive">
                            <table class="table table-hover" id="categoriesTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="selectAll">
                                            </div>
                                        </th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="categoriesTableBody">
                                    @forelse($categories as $category)
                                    <tr data-id="{{ $category->id }}">
                                        <td class="text-center">
                                            <div class="form-check">
                                                <input class="form-check-input row-checkbox" type="checkbox" value="{{ $category->id }}">
                                            </div>
                                        </td>
                                        <td>{{ $category->id }}</td>
                                        <td><b>{{ $category->name }}</b></td>
                                        <td>
                                            @if($category->category_image)
                                            <img src="{{ asset('storage/' . $category->category_image) }}" alt="{{ $category->name }}" class="category-image-preview">
                                            @else
                                            <span class="text-muted">No image</span>
                                            @endif
                                        </td>
                                        <td>{{ $category->created_at->format('M j, Y') }}</td>
                                        <td>{{ $category->updated_at->format('M j, Y') }}</td>
                                        <td class="text-end">
                                            <div class="dropdown">
                                                <a class="btn btn-light rounded btn-sm font-sm" href="#" data-bs-toggle="dropdown">
                                                    <i class="material-icons md-more_horiz"></i>
                                                </a>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item edit-category" href="#" data-id="{{ $category->id }}">Edit info</a>
                                                    <a class="dropdown-item text-danger delete-category" href="#" data-id="{{ $category->id }}">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                        <div>No Categories found</div>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted" id="tableInfo">
                                Showing {{ $categories->firstItem() ?? 0 }} to {{ $categories->lastItem() ?? 0 }} of {{ $categories->total() }} entries
                            </div>
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <footer class="main-footer font-xs">
        <div class="row pb-30 pt-15">
            <div class="col-sm-6">
                <script>document.write(new Date().getFullYear())</script> &copy;, Ecom - HTML Ecommerce Template .
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end">All rights reserved</div>
            </div>
        </div>
    </footer>
</main>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCategoryForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_category_id" name="id">
                    <div class="mb-3">
                        <label for="edit_category_name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="edit_category_name" name="name" required>
                        <div class="invalid-feedback" id="editNameError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_category_image" class="form-label">Category Image</label>
                        <input class="form-control" type="file" id="edit_category_image" name="category_image" accept="image/*">
                    </div>
                    <div class="mb-3" id="editImagePreviewContainer">
                        <label class="form-label">Current Image</label>
                        <div>
                            <img id="edit_image_preview" src="#" alt="Current Image" class="category-image-preview">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="updateCategoryBtn">Update Category</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCategoryModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this category? This action cannot be undone.
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
        const categoryForm = document.getElementById('categoryForm');
        const categoriesTableBody = document.getElementById('categoriesTableBody');
        const searchInput = document.getElementById('searchInput');
        const selectAllCheckbox = document.getElementById('selectAll');
        const bulkActions = document.getElementById('bulkActions');
        const selectedCount = document.getElementById('selectedCount');
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
        const clearSelectionBtn = document.getElementById('clearSelectionBtn');
        const successAlert = document.getElementById('successAlert');
        const imagePreview = document.getElementById('imagePreview');
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        const editCategoryModal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
        const deleteCategoryModal = new bootstrap.Modal(document.getElementById('deleteCategoryModal'));
        const updateCategoryBtn = document.getElementById('updateCategoryBtn');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        
        // Image preview for create form
        document.getElementById('category_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreviewContainer.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                imagePreviewContainer.style.display = 'none';
            }
        });
        
        // Form submission with AJAX
        categoryForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = document.getElementById('submitBtn');
            
            // Reset validation
            resetValidation();
            
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Creating...';
            
            fetch("{{ route('createcategoryadmin') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status == 'success') {
                    // Show success message
                    
                    
                    // Reset form
                    categoryForm.reset();
                    imagePreviewContainer.style.display = 'none';
                    showTemporaryAlert('Category created successfully');
                    // Add new category to table
                    // addCategoryToTable(data.category);
                    
                    // Hide success message after 3 seconds
                    setTimeout(() => {
                       location.reload();
                    }, 3000);
                    
                } else {
                    // Show validation errors
                    showValidationErrors(data.errors);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while creating the category');
            })
            .finally(() => {
                // Reset button state
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Create Category';
            });
        });
        
        // Edit category event delegation
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('edit-category') || e.target.parentElement.classList.contains('edit-category')) {
                e.preventDefault();
                const categoryId = e.target.dataset.id || e.target.parentElement.dataset.id;
                loadCategoryData(categoryId);
            }
            
            if (e.target.classList.contains('delete-category') || e.target.parentElement.classList.contains('delete-category')) {
                e.preventDefault();
                const categoryId = e.target.dataset.id || e.target.parentElement.dataset.id;
                confirmDeleteBtn.dataset.id = categoryId;
                deleteCategoryModal.show();
            }
        });
        
        // Update category
        updateCategoryBtn.addEventListener('click', function() {
            const formData = new FormData(document.getElementById('editCategoryForm'));
            const categoryId = document.getElementById('edit_category_id').value;
            
            // Reset validation
            resetEditValidation();
            
            fetch(`/categories/${categoryId}`, {
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
                    updateCategoryInTable(data.category);
                    
                    // Close modal
                    editCategoryModal.hide();
                    
                    // Show success message
                    showTemporaryAlert('Category updated successfully', 'success');
                } else {
                    // Show validation errors
                    showEditValidationErrors(data.errors);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the category');
            });
        });
        
        // Confirm delete
        confirmDeleteBtn.addEventListener('click', function() {
            const categoryId = this.dataset.id;
            
            fetch(`/categories/${categoryId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove from table
                    document.querySelector(`tr[data-id="${categoryId}"]`).remove();
                    
                    // Close modal
                    deleteCategoryModal.hide();
                    
                    // Show success message
                    showTemporaryAlert('Category deleted successfully', 'success');
                    
                    // Update table info
                    updateTableInfo();
                } else {
                    alert('Error deleting category');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the category');
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
            const selectedIds = getSelectedCategoryIds();
            if (selectedIds.length === 0) return;
            
            if (confirm(`Are you sure you want to delete ${selectedIds.length} categories?`)) {
                fetch("{{ route('deletecategory') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ ids: selectedIds })
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
                        showTemporaryAlert(`${selectedIds.length} categories deleted successfully`, 'success');
                        
                        // Update table info
                        updateTableInfo();
                    } else {
                        alert('Error deleting categories');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting categories');
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
        
        // Search functionality
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#categoriesTableBody tr');
            
            rows.forEach(row => {
                const name = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                if (name.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        
        // Helper functions
        function loadCategoryData(categoryId) {
            fetch(`/categories/${categoryId}/edit`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('edit_category_id').value = data.id;
                document.getElementById('edit_category_name').value = data.name;
                
                // Set image preview
                const editImagePreview = document.getElementById('edit_image_preview');
                if (data.category_image) {
                    editImagePreview.src = "{{ asset('storage/') }}/" + data.category_image;
                    document.getElementById('editImagePreviewContainer').style.display = 'block';
                } else {
                    document.getElementById('editImagePreviewContainer').style.display = 'none';
                }
                
                editCategoryModal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while loading category data');
            });
        }
        
        function addCategoryToTable(category) {
            const newRow = document.createElement('tr');
            newRow.setAttribute('data-id', category.id);
            newRow.innerHTML = `
                <td class="text-center">
                    <div class="form-check">
                        <input class="form-check-input row-checkbox" type="checkbox" value="${category.id}">
                    </div>
                </td>
                <td>${category.id}</td>
                <td><b>${category.name}</b></td>
                <td>
                    ${category.category_image ? 
                        `<img src="{{ asset('storage/') }}/${category.category_image}" alt="${category.name}" class="category-image-preview">` : 
                        '<span class="text-muted">No image</span>'
                    }
                </td>
                <td>${new Date(category.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</td>
                <td>${new Date(category.updated_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</td>
                <td class="text-end">
                    <div class="dropdown">
                        <a class="btn btn-light rounded btn-sm font-sm" href="#" data-bs-toggle="dropdown">
                            <i class="material-icons md-more_horiz"></i>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item edit-category" href="#" data-id="${category.id}">Edit info</a>
                            <a class="dropdown-item text-danger delete-category" href="#" data-id="${category.id}">Delete</a>
                        </div>
                    </div>
                </td>
            `;
            categoriesTableBody.appendChild(newRow);
            updateTableInfo();
        }
        
        function updateCategoryInTable(category) {
            const row = document.querySelector(`tr[data-id="${category.id}"]`);
            if (row) {
                row.querySelector('td:nth-child(3)').innerHTML = `<b>${category.name}</b>`;
                row.querySelector('td:nth-child(4)').innerHTML = category.category_image ? 
                    `<img src="{{ asset('storage/') }}/${category.category_image}" alt="${category.name}" class="category-image-preview">` : 
                    '<span class="text-muted">No image</span>';
                row.querySelector('td:nth-child(5)').textContent = new Date(category.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                row.querySelector('td:nth-child(6)').textContent = new Date(category.updated_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
            }
        }
        
        function updateBulkActions() {
            const selectedIds = getSelectedCategoryIds();
            const count = selectedIds.length;
            
            if (count > 0) {
                bulkActions.classList.add('show');
                selectedCount.textContent = `${count} categor${count === 1 ? 'y' : 'ies'} selected`;
            } else {
                bulkActions.classList.remove('show');
            }
            
            // Update select all checkbox state
            const totalCheckboxes = document.querySelectorAll('.row-checkbox').length;
            const checkedCheckboxes = document.querySelectorAll('.row-checkbox:checked').length;
            selectAllCheckbox.checked = totalCheckboxes > 0 && checkedCheckboxes === totalCheckboxes;
            selectAllCheckbox.indeterminate = totalCheckboxes > 0 && checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes;
        }
        
        function getSelectedCategoryIds() {
            const checkboxes = document.querySelectorAll('.row-checkbox:checked');
            return Array.from(checkboxes).map(checkbox => checkbox.value);
        }
        
        function showValidationErrors(errors) {
            for (const field in errors) {
                const input = document.getElementById(field);
                const errorDiv = document.getElementById(field + 'Error');
                
                if (input && errorDiv) {
                    input.classList.add('is-invalid');
                    errorDiv.textContent = errors[field][0];
                }
            }
        }
        
        function showEditValidationErrors(errors) {
            for (const field in errors) {
                const input = document.getElementById('edit_' + field);
                const errorDiv = document.getElementById('edit' + field.charAt(0).toUpperCase() + field.slice(1) + 'Error');
                
                if (input && errorDiv) {
                    input.classList.add('is-invalid');
                    errorDiv.textContent = errors[field][0];
                }
            }
        }
        
        function resetValidation() {
            const inputs = categoryForm.querySelectorAll('.is-invalid');
            inputs.forEach(input => {
                input.classList.remove('is-invalid');
            });
        }
        
        function resetEditValidation() {
            const inputs = document.getElementById('editCategoryForm').querySelectorAll('.is-invalid');
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
            const visibleRows = document.querySelectorAll('#categoriesTableBody tr:not([style*="display: none"])').length;
            const totalRows = document.querySelectorAll('#categoriesTableBody tr').length;
            document.getElementById('tableInfo').textContent = `Showing ${visibleRows} of ${totalRows} entries`;
        }
    });
</script>

<style>
    .category-image-preview {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 0.25rem;
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
    
    @media (max-width: 768px) {
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