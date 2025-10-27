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
                <h1>Sliders</h1>
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
                <button class="btn btn-primary" onclick="openModal('SliderModal')">
                    <i class="fas fa-plus"></i> Add New Slider
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
                            <th>Slider Text</th>

                            <th>Slider Description</th>
                            <th>Slider Link</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sliders as $item)
                            <tr>
                                <td><input type="checkbox" class="row-checkbox" data-id="{{ $item->id }}"></td>
                                <td>
                                    <div class="product-cell">
                                        <div class="product-image"><img style="width: 50px; height: 50px;"
                                                src="{{ asset('storage') }}/{{ $item->slider_image }}" alt=""
                                                srcset=""></div>
                                        <span>{{ $item->slider_title }}</span>
                                    </div>
                                </td>
                                <td>{{ $item->slider_description }}</td>
                                <td>{{ $item->slider_link }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit"><i class="fas fa-edit"></i></button>
                                        <button class="btn-icon" title="Delete"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td>No Sliders Found</td>

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

    <div id="SliderModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New Slider</h2>
                <button class="modal-close" onclick="closeModal('SliderModal')">&times;</button>
            </div>

            <div class="modal-body">

                <!-- Product Name -->
                <div class="form-group">
                    <label>Slider Text</label>
                    <input type="text" class="form-input" name="slider_title" placeholder="Enter Slider Title">
                </div>
                <div class="form-group">
                    <label>Slider Description</label>
                    <input type="text" class="form-input" name="slider_description"
                        placeholder="Enter Slider Description">
                </div>
                <div class="form-group">
                    <label>Slider Link</label>
                    <input type="text" class="form-input" name="slider_link" placeholder="Enter Slider Link">
                </div>

                <!-- Images Upload -->
                <div class="form-group">
                    <label>Slider Images</label>
                    <input type="file" class="form-input" name="slider_image" accept="image/*">
                    <small>Upload one images</small>
                </div>



            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal('SliderModal')">Cancel</button>
                <button class="btn btn-primary">Add Product</button>
            </div>
        </div>
    </div>

    <!-- add product script-->
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const modal = document.getElementById('SliderModal');
            const addSliderBtn = modal.querySelector('.btn.btn-primary');
            const imageInput = modal.querySelector('input[name="slider_image"]');

            // 🔹 Create image preview container
            const previewContainer = document.createElement('div');
            previewContainer.classList.add('image-preview-container');
            previewContainer.style.display = 'flex';
            previewContainer.style.flexWrap = 'wrap';
            previewContainer.style.gap = '10px';
            previewContainer.style.marginTop = '10px';
            imageInput.insertAdjacentElement('afterend', previewContainer);

            // 🔹 Show preview when file is chosen
            imageInput.addEventListener('change', (e) => {
                previewContainer.innerHTML = '';
                const file = e.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (ev) => {
                        const img = document.createElement('img');
                        img.src = ev.target.result;
                        img.style.width = '100px';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';
                        img.style.borderRadius = '8px';
                        img.style.boxShadow = '0 0 4px rgba(0,0,0,0.3)';
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });

            // 🔹 Handle Add Slider button click
            addSliderBtn.addEventListener('click', async (e) => {
                e.preventDefault();

                const originalText = addSliderBtn.innerHTML;
                addSliderBtn.disabled = true;
                addSliderBtn.innerHTML = `<i class="fa fa-spinner fa-spin"></i> Adding...`;

                const formData = new FormData();
                modal.querySelectorAll('input[name], textarea[name]').forEach(input => {
                    const name = input.name;
                    if (input.type === 'file') {
                        if (input.files[0]) formData.append(name, input.files[0]);
                    } else {
                        formData.append(name, input.value);
                    }
                });

                // ✅ Append CSRF token
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                'content');
                if (token) formData.append('_token', token);

                try {
                    const response = await fetch("{{ route('createSlider') }}", {
                        method: "POST",
                        headers: {
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "X-Requested-With": "XMLHttpRequest" // ensures Laravel detects AJAX
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (!response.ok || !data.success) {
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

                    toastr.success(data.message || 'Slider added successfully.');
                    location.reload();

                    // Reset form inputs
                    modal.querySelectorAll('input, textarea').forEach(el => el.value = '');
                    previewContainer.innerHTML = '';

                    // Close modal
                    if (typeof closeModal === 'function') closeModal('SliderModal');

                } catch (error) {
                    console.error('Error:', error);
                    toastr.error('An unexpected error occurred. Please try again.');
                } finally {
                    addSliderBtn.disabled = false;
                    addSliderBtn.innerHTML = originalText;
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

                    fetch("{{ route('deleteSlider') }}", {
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
                                alert(data.message || "Sliders deleted successfully!");
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
