<div>
    <main class="main-content">
            <header class="top-header">
                <div class="header-left">
                    <h1>Settings</h1>
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
                <div class="settings-container">
                    <div class="settings-tabs">
                        <button class="settings-tab active" data-tab="general">
                            <i class="fas fa-cog"></i> General
                        </button>
                        <button class="settings-tab" data-tab="payment">
                            <i class="fas fa-credit-card"></i> Payment
                        </button>
                        <button class="settings-tab" data-tab="shipping">
                            <i class="fas fa-truck"></i> Shipping
                        </button>
                        <button class="settings-tab" data-tab="notifications">
                            <i class="fas fa-bell"></i> Notifications
                        </button>
                        <button class="settings-tab" data-tab="security">
                            <i class="fas fa-shield-alt"></i> Security
                        </button>
                    </div>

                    <div class="settings-content">
                        <div class="settings-panel active" id="general">
                            <h2>General Settings</h2>
                            <div class="settings-section">
                                <h3>Store Information</h3>
                                <div class="form-group">
                                    <label>Store Name</label>
                                    <input type="text" class="form-input" value="My E-Commerce Store">
                                </div>
                                <div class="form-group">
                                    <label>Store Email</label>
                                    <input type="email" class="form-input" value="store@example.com">
                                </div>
                                <div class="form-group">
                                    <label>Store Phone</label>
                                    <input type="tel" class="form-input" value="+1 234 567 8900">
                                </div>
                                <div class="form-group">
                                    <label>Store Address</label>
                                    <textarea class="form-input" rows="3">123 Main Street, City, State 12345</textarea>
                                </div>
                            </div>

                            <div class="settings-section">
                                <h3>Currency & Timezone</h3>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Currency</label>
                                        <select class="form-input">
                                            <option>USD - US Dollar</option>
                                            <option>EUR - Euro</option>
                                            <option>GBP - British Pound</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Timezone</label>
                                        <select class="form-input">
                                            <option>UTC-5 (EST)</option>
                                            <option>UTC-8 (PST)</option>
                                            <option>UTC+0 (GMT)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-primary">Save Changes</button>
                        </div>

                        <div class="settings-panel" id="payment">
                            <h2>Payment Settings</h2>
                            <div class="settings-section">
                                <h3>Payment Methods</h3>
                                <div class="toggle-setting">
                                    <div class="toggle-info">
                                        <h4>Credit Card</h4>
                                        <p>Accept credit and debit cards</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" checked>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                                <div class="toggle-setting">
                                    <div class="toggle-info">
                                        <h4>PayPal</h4>
                                        <p>Accept payments via PayPal</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" checked>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                                <div class="toggle-setting">
                                    <div class="toggle-info">
                                        <h4>Cash on Delivery</h4>
                                        <p>Allow cash payment on delivery</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox">
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="settings-section">
                                <h3>Gateway Configuration</h3>
                                <div class="form-group">
                                    <label>Stripe API Key</label>
                                    <input type="password" class="form-input" value="sk_test_xxxxxxxxxxxxx">
                                </div>
                                <div class="form-group">
                                    <label>PayPal Client ID</label>
                                    <input type="password" class="form-input" value="AxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxB">
                                </div>
                            </div>

                            <button class="btn btn-primary">Save Changes</button>
                        </div>

                        <div class="settings-panel" id="shipping">
                            <h2>Shipping Settings</h2>
                            <div class="settings-section">
                                <h3>Shipping Zones</h3>
                                <div class="shipping-zone">
                                    <div class="zone-info">
                                        <h4>Domestic Shipping</h4>
                                        <p>United States</p>
                                    </div>
                                    <div class="zone-rate">
                                        <span>$10.00 flat rate</span>
                                        <button class="btn-icon"><i class="fas fa-edit"></i></button>
                                    </div>
                                </div>
                                <div class="shipping-zone">
                                    <div class="zone-info">
                                        <h4>International Shipping</h4>
                                        <p>Worldwide</p>
                                    </div>
                                    <div class="zone-rate">
                                        <span>$25.00 flat rate</span>
                                        <button class="btn-icon"><i class="fas fa-edit"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="settings-section">
                                <h3>Free Shipping</h3>
                                <div class="toggle-setting">
                                    <div class="toggle-info">
                                        <h4>Enable Free Shipping</h4>
                                        <p>Offer free shipping for orders above a certain amount</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" checked>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>Minimum Order Amount</label>
                                    <input type="number" class="form-input" value="100.00">
                                </div>
                            </div>

                            <button class="btn btn-primary">Save Changes</button>
                        </div>

                        <div class="settings-panel" id="notifications">
                            <h2>Notification Settings</h2>
                            <div class="settings-section">
                                <h3>Email Notifications</h3>
                                <div class="toggle-setting">
                                    <div class="toggle-info">
                                        <h4>Order Confirmation</h4>
                                        <p>Send email when order is placed</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" checked>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                                <div class="toggle-setting">
                                    <div class="toggle-info">
                                        <h4>Order Shipped</h4>
                                        <p>Send email when order is shipped</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" checked>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                                <div class="toggle-setting">
                                    <div class="toggle-info">
                                        <h4>Low Stock Alert</h4>
                                        <p>Notify when product stock is low</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" checked>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>

                            <button class="btn btn-primary">Save Changes</button>
                        </div>

                        <div class="settings-panel" id="security">
                            <h2>Security Settings</h2>
                            <div class="settings-section">
                                <h3>Password</h3>
                                <div class="form-group">
                                    <label>Current Password</label>
                                    <input type="password" class="form-input">
                                </div>
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input type="password" class="form-input">
                                </div>
                                <div class="form-group">
                                    <label>Confirm New Password</label>
                                    <input type="password" class="form-input">
                                </div>
                            </div>

                            <div class="settings-section">
                                <h3>Two-Factor Authentication</h3>
                                <div class="toggle-setting">
                                    <div class="toggle-info">
                                        <h4>Enable 2FA</h4>
                                        <p>Add an extra layer of security to your account</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox">
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>

                            <button class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
</div>