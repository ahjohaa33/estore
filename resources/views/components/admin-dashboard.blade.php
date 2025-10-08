        <main class="main-content">
            <header class="top-header">
                <div class="header-left">
                    <h1>Dashboard</h1>
                </div>
                <div class="header-right">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search...">
                    </div>
                    <div class="user-menu">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=667eea&color=fff" alt="Admin">
                        <span>Admin</span>
                    </div>
                </div>
            </header>

            <div class="content-area">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stat-details">
                            <h3>$45,231</h3>
                            <p>Total Revenue</p>
                            <span class="stat-change positive">+12.5%</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon green">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="stat-details">
                            <h3>1,245</h3>
                            <p>Total Orders</p>
                            <span class="stat-change positive">+8.2%</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon purple">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-details">
                            <h3>3,567</h3>
                            <p>Total Customers</p>
                            <span class="stat-change positive">+15.3%</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon orange">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stat-details">
                            <h3>856</h3>
                            <p>Total Products</p>
                            <span class="stat-change negative">-2.1%</span>
                        </div>
                    </div>
                </div>

                <div class="dashboard-grid">
                    <div class="chart-card">
                        <div class="card-header">
                            <h3>Sales Overview</h3>
                            <select class="time-filter">
                                <option>Last 7 days</option>
                                <option>Last 30 days</option>
                                <option>Last 3 months</option>
                            </select>
                        </div>
                        {{-- <canvas id="salesChart"></canvas> --}}
                    </div>

                    <div class="recent-orders">
                        <div class="card-header">
                            <h3>Recent Orders</h3>
                            <a href="orders.html" class="view-all">View All</a>
                        </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#ORD-001</td>
                                    <td>John Doe</td>
                                    <td>$125.00</td>
                                    <td><span class="badge success">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>#ORD-002</td>
                                    <td>Jane Smith</td>
                                    <td>$89.50</td>
                                    <td><span class="badge warning">Pending</span></td>
                                </tr>
                                <tr>
                                    <td>#ORD-003</td>
                                    <td>Mike Johnson</td>
                                    <td>$210.00</td>
                                    <td><span class="badge info">Processing</span></td>
                                </tr>
                                <tr>
                                    <td>#ORD-004</td>
                                    <td>Sarah Williams</td>
                                    <td>$156.75</td>
                                    <td><span class="badge success">Completed</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="dashboard-grid-2">
                    <div class="top-products">
                        <div class="card-header">
                            <h3>Top Products</h3>
                        </div>
                        <div class="product-list">
                            <div class="product-item">
                                <div class="product-info">
                                    <h4>Wireless Headphones</h4>
                                    <p>245 sales</p>
                                </div>
                                <span class="product-revenue">$12,250</span>
                            </div>
                            <div class="product-item">
                                <div class="product-info">
                                    <h4>Smart Watch</h4>
                                    <p>189 sales</p>
                                </div>
                                <span class="product-revenue">$9,450</span>
                            </div>
                            <div class="product-item">
                                <div class="product-info">
                                    <h4>Laptop Backpack</h4>
                                    <p>156 sales</p>
                                </div>
                                <span class="product-revenue">$4,680</span>
                            </div>
                        </div>
                    </div>

                    <div class="quick-stats">
                        <div class="card-header">
                            <h3>Quick Stats</h3>
                        </div>
                        <div class="stats-list">
                            <div class="stats-item">
                                <span class="stats-label">Conversion Rate</span>
                                <span class="stats-value">3.2%</span>
                            </div>
                            <div class="stats-item">
                                <span class="stats-label">Avg. Order Value</span>
                                <span class="stats-value">$142.50</span>
                            </div>
                            <div class="stats-item">
                                <span class="stats-label">Customer Retention</span>
                                <span class="stats-value">68%</span>
                            </div>
                            <div class="stats-item">
                                <span class="stats-label">Pending Orders</span>
                                <span class="stats-value">24</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>