<div>
    <main class="main-content">
            <header class="top-header">
                <div class="header-left">
                    <h1>Orders</h1>
                </div>
                <div class="header-right">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search orders...">
                    </div>
                    <div class="user-menu">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=667eea&color=fff" alt="Admin">
                        <span>Admin</span>
                    </div>
                </div>
            </header>

            <div class="content-area">
                <div class="page-actions">
                    <div class="filter-group">
                        <select class="filter-select">
                            <option>All Status</option>
                            <option>Completed</option>
                            <option>Processing</option>
                            <option>Pending</option>
                            <option>Cancelled</option>
                        </select>
                        <select class="filter-select">
                            <option>Last 7 days</option>
                            <option>Last 30 days</option>
                            <option>Last 3 months</option>
                        </select>
                    </div>
                    <button class="btn btn-secondary">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>

                <div class="table-card">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="checkbox" class="row-checkbox"></td>
                                <td><strong>#ORD-001</strong></td>
                                <td>John Doe</td>
                                <td>2025-10-05</td>
                                <td>3</td>
                                <td>$125.00</td>
                                <td><span class="badge success">Completed</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="View" onclick="openModal('orderDetailModal')"><i class="fas fa-eye"></i></button>
                                        <button class="btn-icon" title="Print"><i class="fas fa-print"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="row-checkbox"></td>
                                <td><strong>#ORD-002</strong></td>
                                <td>Jane Smith</td>
                                <td>2025-10-05</td>
                                <td>2</td>
                                <td>$89.50</td>
                                <td><span class="badge warning">Pending</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="View" onclick="openModal('orderDetailModal')"><i class="fas fa-eye"></i></button>
                                        <button class="btn-icon" title="Print"><i class="fas fa-print"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="row-checkbox"></td>
                                <td><strong>#ORD-003</strong></td>
                                <td>Mike Johnson</td>
                                <td>2025-10-04</td>
                                <td>1</td>
                                <td>$210.00</td>
                                <td><span class="badge info">Processing</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="View" onclick="openModal('orderDetailModal')"><i class="fas fa-eye"></i></button>
                                        <button class="btn-icon" title="Print"><i class="fas fa-print"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="row-checkbox"></td>
                                <td><strong>#ORD-004</strong></td>
                                <td>Sarah Williams</td>
                                <td>2025-10-04</td>
                                <td>4</td>
                                <td>$156.75</td>
                                <td><span class="badge success">Completed</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="View" onclick="openModal('orderDetailModal')"><i class="fas fa-eye"></i></button>
                                        <button class="btn-icon" title="Print"><i class="fas fa-print"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="row-checkbox"></td>
                                <td><strong>#ORD-005</strong></td>
                                <td>Robert Brown</td>
                                <td>2025-10-03</td>
                                <td>2</td>
                                <td>$95.25</td>
                                <td><span class="badge danger">Cancelled</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="View" onclick="openModal('orderDetailModal')"><i class="fas fa-eye"></i></button>
                                        <button class="btn-icon" title="Print"><i class="fas fa-print"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="table-pagination">
                        <span>Showing 1-5 of 1,245 orders</span>
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


            <div id="orderDetailModal" class="modal">
        <div class="modal-content modal-large">
            <div class="modal-header">
                <h2>Order Details - #ORD-001</h2>
                <button class="modal-close" onclick="closeModal('orderDetailModal')">&times;</button>
            </div>
            <div class="modal-body">
                <div class="order-detail-grid">
                    <div class="order-info">
                        <h3>Customer Information</h3>
                        <p><strong>Name:</strong> John Doe</p>
                        <p><strong>Email:</strong> john.doe@email.com</p>
                        <p><strong>Phone:</strong> +1 234 567 8900</p>
                        <p><strong>Address:</strong> 123 Main St, City, State 12345</p>
                    </div>
                    <div class="order-info">
                        <h3>Order Information</h3>
                        <p><strong>Order ID:</strong> #ORD-001</p>
                        <p><strong>Date:</strong> 2025-10-05</p>
                        <p><strong>Status:</strong> <span class="badge success">Completed</span></p>
                        <p><strong>Payment:</strong> Credit Card</p>
                    </div>
                </div>
                <h3>Order Items</h3>
                <table class="order-items-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Wireless Headphones</td>
                            <td>1</td>
                            <td>$89.99</td>
                            <td>$89.99</td>
                        </tr>
                        <tr>
                            <td>Laptop Backpack</td>
                            <td>2</td>
                            <td>$39.99</td>
                            <td>$79.98</td>
                        </tr>
                    </tbody>
                </table>
                <div class="order-total">
                    <p><strong>Subtotal:</strong> $169.97</p>
                    <p><strong>Tax:</strong> $13.60</p>
                    <p><strong>Shipping:</strong> $10.00</p>
                    <h3><strong>Total:</strong> $193.57</h3>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal('orderDetailModal')">Close</button>
                <button class="btn btn-primary"><i class="fas fa-print"></i> Print Invoice</button>
            </div>
        </div>
    </div>
</div>