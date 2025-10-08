<div>
     <main class="main-content">
            <header class="top-header">
                <div class="header-left">
                    <h1>Customers</h1>
                </div>
                <div class="header-right">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search customers...">
                    </div>
                    <div class="user-menu">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=667eea&color=fff" alt="Admin">
                        <span>Admin</span>
                    </div>
                </div>
            </header>

            <div class="content-area">
                <div class="page-actions">
                    <button class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Add New Customer
                    </button>
                    <div class="filter-group">
                        <select class="filter-select">
                            <option>All Customers</option>
                            <option>Active</option>
                            <option>Inactive</option>
                        </select>
                        <button class="btn btn-secondary">
                            <i class="fas fa-download"></i> Export
                        </button>
                    </div>
                </div>

                <div class="table-card">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Orders</th>
                                <th>Total Spent</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="checkbox" class="row-checkbox"></td>
                                <td>
                                    <div class="customer-cell">
                                        <img src="https://ui-avatars.com/api/?name=John+Doe&background=667eea&color=fff" alt="John Doe">
                                        <span>John Doe</span>
                                    </div>
                                </td>
                                <td>john.doe@email.com</td>
                                <td>+1 234 567 8900</td>
                                <td>15</td>
                                <td>$1,245.00</td>
                                <td><span class="badge success">Active</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="View"><i class="fas fa-eye"></i></button>
                                        <button class="btn-icon" title="Edit"><i class="fas fa-edit"></i></button>
                                        <button class="btn-icon" title="Delete"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="row-checkbox"></td>
                                <td>
                                    <div class="customer-cell">
                                        <img src="https://ui-avatars.com/api/?name=Jane+Smith&background=f56565&color=fff" alt="Jane Smith">
                                        <span>Jane Smith</span>
                                    </div>
                                </td>
                                <td>jane.smith@email.com</td>
                                <td>+1 234 567 8901</td>
                                <td>8</td>
                                <td>$680.50</td>
                                <td><span class="badge success">Active</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="View"><i class="fas fa-eye"></i></button>
                                        <button class="btn-icon" title="Edit"><i class="fas fa-edit"></i></button>
                                        <button class="btn-icon" title="Delete"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="row-checkbox"></td>
                                <td>
                                    <div class="customer-cell">
                                        <img src="https://ui-avatars.com/api/?name=Mike+Johnson&background=48bb78&color=fff" alt="Mike Johnson">
                                        <span>Mike Johnson</span>
                                    </div>
                                </td>
                                <td>mike.j@email.com</td>
                                <td>+1 234 567 8902</td>
                                <td>12</td>
                                <td>$980.00</td>
                                <td><span class="badge success">Active</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="View"><i class="fas fa-eye"></i></button>
                                        <button class="btn-icon" title="Edit"><i class="fas fa-edit"></i></button>
                                        <button class="btn-icon" title="Delete"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="row-checkbox"></td>
                                <td>
                                    <div class="customer-cell">
                                        <img src="https://ui-avatars.com/api/?name=Sarah+Williams&background=ed8936&color=fff" alt="Sarah Williams">
                                        <span>Sarah Williams</span>
                                    </div>
                                </td>
                                <td>sarah.w@email.com</td>
                                <td>+1 234 567 8903</td>
                                <td>20</td>
                                <td>$2,150.75</td>
                                <td><span class="badge success">Active</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="View"><i class="fas fa-eye"></i></button>
                                        <button class="btn-icon" title="Edit"><i class="fas fa-edit"></i></button>
                                        <button class="btn-icon" title="Delete"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="row-checkbox"></td>
                                <td>
                                    <div class="customer-cell">
                                        <img src="https://ui-avatars.com/api/?name=Robert+Brown&background=9f7aea&color=fff" alt="Robert Brown">
                                        <span>Robert Brown</span>
                                    </div>
                                </td>
                                <td>robert.b@email.com</td>
                                <td>+1 234 567 8904</td>
                                <td>3</td>
                                <td>$245.00</td>
                                <td><span class="badge warning">Inactive</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="View"><i class="fas fa-eye"></i></button>
                                        <button class="btn-icon" title="Edit"><i class="fas fa-edit"></i></button>
                                        <button class="btn-icon" title="Delete"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="table-pagination">
                        <span>Showing 1-5 of 3,567 customers</span>
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
</div>