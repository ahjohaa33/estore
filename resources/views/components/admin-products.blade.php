<div>
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
                        <select class="filter-select">
                            <option>All Categories</option>
                            <option>Electronics</option>
                            <option>Clothing</option>
                            <option>Accessories</option>
                        </select>
                        <select class="filter-select">
                            <option>All Status</option>
                            <option>Active</option>
                            <option>Out of Stock</option>
                            <option>Draft</option>
                        </select>
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
                            <tr>
                                <td><input type="checkbox" class="row-checkbox"></td>
                                <td>
                                    <div class="product-cell">
                                        <div class="product-image"></div>
                                        <span>Wireless Headphones</span>
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
                            <tr>
                                <td><input type="checkbox" class="row-checkbox"></td>
                                <td>
                                    <div class="product-cell">
                                        <div class="product-image"></div>
                                        <span>Smart Watch Pro</span>
                                    </div>
                                </td>
                                <td>Electronics</td>
                                <td>$249.99</td>
                                <td>89</td>
                                <td><span class="badge success">Active</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit"><i class="fas fa-edit"></i></button>
                                        <button class="btn-icon" title="Delete"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="row-checkbox"></td>
                                <td>
                                    <div class="product-cell">
                                        <div class="product-image"></div>
                                        <span>Laptop Backpack</span>
                                    </div>
                                </td>
                                <td>Accessories</td>
                                <td>$39.99</td>
                                <td>234</td>
                                <td><span class="badge success">Active</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit"><i class="fas fa-edit"></i></button>
                                        <button class="btn-icon" title="Delete"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="row-checkbox"></td>
                                <td>
                                    <div class="product-cell">
                                        <div class="product-image"></div>
                                        <span>Denim Jacket</span>
                                    </div>
                                </td>
                                <td>Clothing</td>
                                <td>$79.99</td>
                                <td>0</td>
                                <td><span class="badge danger">Out of Stock</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit"><i class="fas fa-edit"></i></button>
                                        <button class="btn-icon" title="Delete"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="row-checkbox"></td>
                                <td>
                                    <div class="product-cell">
                                        <div class="product-image"></div>
                                        <span>Running Shoes</span>
                                    </div>
                                </td>
                                <td>Clothing</td>
                                <td>$129.99</td>
                                <td>67</td>
                                <td><span class="badge success">Active</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit"><i class="fas fa-edit"></i></button>
                                        <button class="btn-icon" title="Delete"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
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
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" class="form-input" placeholder="Enter product name">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-input">
                            <option>Select category</option>
                            <option>Electronics</option>
                            <option>Clothing</option>
                            <option>Accessories</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" class="form-input" placeholder="0.00">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Stock Quantity</label>
                        <input type="number" class="form-input" placeholder="0">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-input">
                            <option>Active</option>
                            <option>Draft</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-input" rows="4" placeholder="Enter product description"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal('addProductModal')">Cancel</button>
                <button class="btn btn-primary">Add Product</button>
            </div>
        </div>
    </div>
</div>