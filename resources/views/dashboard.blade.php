<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yuasa Fleet | Car Rental Management</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }

        body { background: #f4f6fa; color: #1e293b; }

        /* ── Login Screen ─────────────────────────────────── */
        #loginScreen {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #111827 0%, #1e3a5f 100%);
        }

        .login-box {
            background: white;
            border-radius: 16px;
            padding: 44px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px #00000030;
        }

        .login-brand {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 4px;
            text-align: center;
        }

        .login-brand span { color: #f59e0b; }

        .login-subtitle {
            text-align: center;
            font-size: 13px;
            color: #64748b;
            margin-bottom: 32px;
        }

        .form-group { margin-bottom: 18px; }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
            color: #374151;
        }

        .form-group input {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color .2s;
        }

        .form-group input:focus { border-color: #f59e0b; }

        /* ── Password toggle (login screen) ─────────────── */
        .login-pw-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .login-pw-wrap input {
            padding-right: 44px !important;
            width: 100%;
        }

        .login-pw-eye {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            padding: 4px;
            cursor: pointer;
            color: #94a3b8;
            font-size: 17px;
            line-height: 1;
            display: flex;
            align-items: center;
        }

        .login-pw-eye:hover { color: #374151; background: none; }

        .login-btn {
            width: 100%;
            padding: 13px;
            background: #f59e0b;
            color: #111827;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 6px;
            transition: background .2s;
        }

        .login-btn:hover { background: #d97706; }
        .login-btn:disabled { background: #fcd34d; cursor: not-allowed; }

        .login-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            border-radius: 8px;
            padding: 11px 14px;
            font-size: 13px;
            margin-bottom: 16px;
            display: none;
        }

        /* ── Settings ───────────────────────────────────── */
        .settings-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .settings-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
        }

        .settings-card.full { grid-column: 1 / -1; }

        .settings-card-title {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #374151;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .settings-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
        }

        .settings-row:last-child { border-bottom: none; }

        .settings-row-label { color: #64748b; }

        .settings-row-value {
            font-weight: 600;
            color: #1e293b;
            text-align: right;
        }

        .settings-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            background: #dcfce7;
            color: #166534;
        }

        .settings-badge.admin { background: #fef3c7; color: #92400e; }

        .pw-form { margin-top: 4px; }

        .pw-form .form-group { margin-bottom: 14px; }

        .pw-form .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 5px;
        }

        .pw-form .form-group input {
            width: 100%;
            padding: 10px 13px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 13px;
            outline: none;
            transition: border-color .2s;
            background: white;
        }

        .pw-form .form-group input:focus { border-color: #f59e0b; }

        /* ── Password toggle wrapper ────────────────────── */
        .pw-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .pw-wrap input {
            padding-right: 42px !important;
        }

        .pw-eye {
            position: absolute;
            right: 11px;
            background: none;
            border: none;
            padding: 4px;
            cursor: pointer;
            color: #94a3b8;
            font-size: 16px;
            line-height: 1;
            display: flex;
            align-items: center;
        }

        .pw-eye:hover { color: #374151; background: none; }

        .pw-save-btn {
            padding: 10px 22px;
            font-size: 13px;
        }

        .settings-msg {
            margin-top: 10px;
            font-size: 13px;
            padding: 9px 13px;
            border-radius: 7px;
            display: none;
        }

        .settings-msg.success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .settings-msg.error   { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

        @media (max-width: 700px) {
            .settings-grid { grid-template-columns: 1fr; }
            .settings-card.full { grid-column: auto; }
        }

        /* ── Reports ─────────────────────────────────────── */
        .report-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 10px;
        }

        .report-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 22px;
        }

        .report-card-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
        }

        .report-card-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
        }

        .report-card-title {
            font-size: 14px;
            font-weight: 700;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .report-stat-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
        }

        .report-stat-row:last-child { border-bottom: none; }

        .report-stat-label { color: #64748b; }

        .report-stat-value {
            font-weight: 700;
            color: #1e293b;
            font-size: 14px;
        }

        .report-stat-value.highlight { color: #f59e0b; }
        .report-stat-value.danger    { color: #b91c1c; }
        .report-stat-value.success   { color: #16a34a; }

        .utilisation-bar-wrap {
            margin-top: 14px;
            background: #e2e8f0;
            border-radius: 20px;
            height: 8px;
            overflow: hidden;
        }

        .utilisation-bar {
            height: 100%;
            border-radius: 20px;
            background: #f59e0b;
            transition: width .6s ease;
        }

        .utilisation-label {
            font-size: 11px;
            color: #64748b;
            margin-top: 5px;
            text-align: right;
        }

        @media (max-width: 900px) {
            .report-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 600px) {
            .report-grid { grid-template-columns: 1fr; }
        }

        /* ── Admin Vehicle Cards ─────────────────────────── */
        .admin-vehicle-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 18px;
        }
        .admin-vehicle-card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            background: white;
            transition: box-shadow .2s;
        }
        .admin-vehicle-card:hover { box-shadow: 0 6px 20px #00000012; }
        .admin-vehicle-card img {
            width: 100%; height: 160px; object-fit: cover;
            display: block; background: #f1f5f9;
        }
        .admin-vehicle-card-placeholder {
            width: 100%; height: 160px; background: #f1f5f9;
            display: flex; align-items: center; justify-content: center;
            font-size: 44px;
        }
        .admin-vehicle-card-body { padding: 14px 16px 16px; }
        .admin-vehicle-card-name { font-size: 14px; font-weight: 700; margin-bottom: 4px; }
        .admin-vehicle-card-reg  { font-size: 12px; color: #64748b; margin-bottom: 8px; }
        .admin-vehicle-card-meta { font-size: 12px; color: #475569; line-height: 1.7; }
        .admin-vehicle-card-footer {
            display: flex; justify-content: space-between; align-items: center;
            margin-top: 10px; padding-top: 10px; border-top: 1px solid #f1f5f9;
        }
        .admin-vehicle-status {
            display: inline-block; padding: 3px 9px; border-radius: 20px;
            font-size: 11px; font-weight: 600;
        }
        .status-available   { background: #dcfce7; color: #166534; }
        .status-rented      { background: #dbeafe; color: #1d4ed8; }
        .status-maintenance { background: #fef3c7; color: #92400e; }
        .admin-vehicle-rate { font-size: 13px; font-weight: 700; color: #f59e0b; }

        @media (max-width: 900px) {
            .admin-vehicle-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 500px) {
            .admin-vehicle-grid { grid-template-columns: 1fr; }
        }

        /* ── App Shell ───────────────────────────────────── */
        #appShell { display: none; }

        .layout { display: flex; min-height: 100vh; }

        .sidebar {
            width: 250px;
            background: #111827;
            color: white;
            padding: 25px 18px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .brand { font-size: 23px; font-weight: bold; margin-bottom: 8px; }
        .brand span { color: #f59e0b; }
        .subtitle { font-size: 12px; color: #9ca3af; margin-bottom: 35px; }

        .menu-label {
            color: #9ca3af;
            font-size: 11px;
            margin: 25px 12px 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .nav-link {
            display: block;
            color: #d1d5db;
            text-decoration: none;
            padding: 13px 14px;
            border-radius: 8px;
            margin-bottom: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        .nav-link:hover, .nav-link.active { background: #f59e0b; color: #111827; }

        .logout-btn {
            display: block;
            width: 100%;
            margin-top: 20px;
            padding: 11px 14px;
            background: #1f2937;
            color: #f87171;
            border: 1px solid #374151;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            text-align: left;
        }

        .logout-btn:hover { background: #374151; }

        .main {
            margin-left: 250px;
            width: calc(100% - 250px);
            padding: 30px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .topbar h1 { font-size: 27px; margin-bottom: 8px; }
        .muted { color: #64748b; font-size: 14px; }

        .admin {
            background: white;
            padding: 12px 17px;
            border-radius: 10px;
            box-shadow: 0 2px 10px #00000008;
            font-size: 13px;
        }

        .welcome {
            background: linear-gradient(120deg, #111827, #273449);
            color: white;
            padding: 28px;
            border-radius: 15px;
            margin-bottom: 25px;
        }

        .welcome h2 { font-size: 24px; margin-bottom: 10px; }
        .welcome p { color: #d1d5db; line-height: 1.6; }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 28px;
        }

        .card {
            background: white;
            border-radius: 13px;
            padding: 23px;
            box-shadow: 0 3px 12px #00000006;
        }

        .card-title { color: #64748b; font-size: 13px; margin-bottom: 18px; }
        .card-number { font-size: 30px; font-weight: bold; margin-bottom: 8px; }
        .card-note { color: #64748b; font-size: 12px; }

        .panel {
            background: white;
            padding: 24px;
            border-radius: 13px;
            margin-bottom: 25px;
            box-shadow: 0 3px 12px #00000006;
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 22px;
        }

        .panel-header h2 { font-size: 19px; }

        button {
            border: none;
            background: #f59e0b;
            color: #111827;
            padding: 11px 17px;
            border-radius: 7px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover { background: #d97706; }

        .secondary { background: #e2e8f0; color: #1e293b; }

        .table-wrap { overflow-x: auto; }

        table { width: 100%; border-collapse: collapse; min-width: 650px; }

        th, td {
            padding: 15px 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
        }

        th { color: #64748b; font-weight: 600; background: #f8fafc; }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            background: #dcfce7;
            color: #166534;
        }

        .empty { color: #64748b; text-align: center; padding: 35px; }

        .section { display: none; }
        .section.active { display: block; }

        .notice { margin-top: 15px; font-size: 13px; color: #64748b; }

        .error { color: #b91c1c; }

        .mobile-menu { display: none; }

        @media (max-width: 1100px) {
            .cards { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 700px) {
            .sidebar { display: none; z-index: 10; width: 250px; }
            .sidebar.open { display: block; }
            .main { margin-left: 0; width: 100%; padding: 18px; }
            .mobile-menu { display: inline-block; margin-bottom: 15px; }
            .topbar { align-items: flex-start; flex-direction: column; }
            .cards { grid-template-columns: 1fr; }
            .welcome h2 { font-size: 20px; }
        }
    </style>
</head>

<body>

<!-- ══════════════════════════════════════════════════════
     LOGIN SCREEN
══════════════════════════════════════════════════════ -->
<div id="loginScreen">
    <div class="login-box">
        <div class="login-brand">YUASA<span> FLEET</span></div>
        <div class="login-subtitle">CAR RENTAL MANAGEMENT — Sign in to continue</div>

        <div class="login-error" id="loginError"></div>

        <form id="loginForm">
            <div class="form-group">
                <label for="loginEmail">Email address</label>
                <input type="email" id="loginEmail" placeholder="admin@yuasa.com" required autocomplete="username">
            </div>

            <div class="form-group">
                <label for="loginPassword">Password</label>
                <div class="login-pw-wrap">
                    <input type="password" id="loginPassword" placeholder="••••••••" required autocomplete="current-password">
                    <button type="button" class="login-pw-eye" onclick="togglePw('loginPassword', this)" tabindex="-1" aria-label="Toggle password visibility">👁</button>
                </div>
            </div>

            <button type="submit" class="login-btn" id="loginSubmit">Sign In</button>
        </form>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════
     APP SHELL (hidden until logged in)
══════════════════════════════════════════════════════ -->
<div id="appShell">
<div class="layout">

    <aside class="sidebar" id="sidebar">
        <div class="brand">YUASA<span> FLEET</span></div>
        <div class="subtitle">CAR RENTAL MANAGEMENT</div>

        <div class="menu-label">Main Menu</div>

        <a class="nav-link active" data-section="dashboard">▦ Dashboard</a>
        <a class="nav-link" data-section="vehicles">🚘 Vehicles</a>
        <a class="nav-link" data-section="customers">👥 Customers</a>
        <a class="nav-link" data-section="bookings">📅 Bookings</a>

        <div class="menu-label">Operations</div>

        <a class="nav-link" data-section="payments">💳 Payments</a>
        <a class="nav-link" data-section="maintenance">🔧 Maintenance</a>
        <a class="nav-link" data-section="reports">📊 Reports</a>

        <div class="menu-label">System</div>

        <a class="nav-link" data-section="settings">⚙ Settings</a>

        <button class="logout-btn" id="logoutBtn">⏻ &nbsp;Sign Out</button>

        <a href="/portal" style="display:block;margin-top:12px;padding:10px 14px;background:#1f2937;border:1px solid #374151;border-radius:8px;color:#9ca3af;font-size:12px;text-align:center;text-decoration:none;">
            🔗 Customer Portal ↗
        </a>
    </aside>

    <main class="main">

        <button class="mobile-menu" id="menuButton">☰ Menu</button>

        <header class="topbar">
            <div>
                <h1 id="pageTitle">Dashboard</h1>
                <p class="muted">Manage your car rental operations in one place.</p>
            </div>

            <div class="admin">
                <strong>YUASA INVESTMENTS LTD</strong><br>
                <span class="muted" id="loggedInUser">Fleet Management</span>
            </div>
        </header>

        <!-- DASHBOARD -->
        <section class="section active" id="dashboard">
            <div class="welcome">
                <h2>Welcome to Yuasa Fleet 👋</h2>
                <p>Your central platform for managing rental vehicles, customers, bookings, payments and maintenance.</p>
            </div>

            <div class="cards">
                <div class="card">
                    <div class="card-title">TOTAL VEHICLES</div>
                    <div class="card-number" id="vehicleCount">—</div>
                    <div class="card-note">Registered fleet vehicles</div>
                </div>
                <div class="card">
                    <div class="card-title">TOTAL CUSTOMERS</div>
                    <div class="card-number" id="customerCount">—</div>
                    <div class="card-note">Registered customers</div>
                </div>
                <div class="card">
                    <div class="card-title">TOTAL BOOKINGS</div>
                    <div class="card-number" id="bookingCount">—</div>
                    <div class="card-note">Recorded rental bookings</div>
                </div>
                <div class="card">
                    <div class="card-title">RECORDED PAYMENTS</div>
                    <div class="card-number" id="paymentCount">—</div>
                    <div class="card-note">Payment records</div>
                </div>
            </div>

            <div class="panel">
                <div class="panel-header">
                    <h2>Recent Bookings</h2>
                    <button onclick="showSection('bookings')">View Bookings</button>
                </div>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Customer ID</th>
                                <th>Vehicle ID</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="recentBookings">
                            <tr><td colspan="4" class="empty">Loading booking information...</td></tr>
                        </tbody>
                    </table>
                </div>
                <p class="notice" id="connectionStatus">Connecting to the Yuasa Fleet API...</p>
            </div>
        </section>

        <!-- VEHICLES -->
        <section class="section" id="vehicles">
            <div class="panel">
                <div class="panel-header">
                    <h2>Vehicle Management</h2>
                    <button onclick="loadSectionData('vehicles')">Refresh</button>
                </div>
                <div id="vehiclesContent"></div>
            </div>
        </section>

        <!-- CUSTOMERS -->
        <section class="section" id="customers">
            <div class="panel">
                <div class="panel-header">
                    <h2>Customer Management</h2>
                    <button onclick="loadSectionData('customers')">Refresh</button>
                </div>
                <div class="table-wrap" id="customersContent"></div>
            </div>
        </section>

        <!-- BOOKINGS -->
        <section class="section" id="bookings">
            <div class="panel">
                <div class="panel-header">
                    <h2>Booking Management</h2>
                    <button onclick="loadSectionData('bookings')">Refresh</button>
                </div>
                <div class="table-wrap" id="bookingsContent"></div>
            </div>
        </section>

        <!-- PAYMENTS -->
        <section class="section" id="payments">
            <div class="panel">
                <div class="panel-header">
                    <h2>Payment Records</h2>
                    <button onclick="loadSectionData('payments')">Refresh</button>
                </div>
                <div class="table-wrap" id="paymentsContent"></div>
            </div>
        </section>

        <!-- MAINTENANCE -->
        <section class="section" id="maintenance">
            <div class="panel">
                <div class="panel-header">
                    <h2>Vehicle Maintenance</h2>
                    <button onclick="loadSectionData('maintenance')">Refresh</button>
                </div>
                <div class="table-wrap" id="maintenanceContent"></div>
            </div>
        </section>

        <!-- REPORTS -->
        <section class="section" id="reports">
            <div class="panel">
                <div class="panel-header">
                    <h2>Fleet Reports</h2>
                    <button onclick="loadSectionData('reports')">Refresh Report</button>
                </div>
                <div id="reportsContent">
                    <p class="empty">Loading reports…</p>
                </div>
            </div>
        </section>

        <!-- SETTINGS -->
        <section class="section" id="settings">

            <div class="settings-grid">

                <!-- Account Profile -->
                <div class="settings-card">
                    <div class="settings-card-title">👤 Account Profile</div>
                    <div class="settings-row">
                        <span class="settings-row-label">Full Name</span>
                        <span class="settings-row-value" id="settingName">—</span>
                    </div>
                    <div class="settings-row">
                        <span class="settings-row-label">Email Address</span>
                        <span class="settings-row-value" id="settingEmail">—</span>
                    </div>
                    <div class="settings-row">
                        <span class="settings-row-label">Role</span>
                        <span class="settings-row-value" id="settingRole">—</span>
                    </div>
                    <div class="settings-row">
                        <span class="settings-row-label">Account Status</span>
                        <span class="settings-row-value" id="settingActive">—</span>
                    </div>
                </div>

                <!-- System Info -->
                <div class="settings-card">
                    <div class="settings-card-title">🖥️ System Information</div>
                    <div class="settings-row">
                        <span class="settings-row-label">Application</span>
                        <span class="settings-row-value">Yuasa Fleet</span>
                    </div>
                    <div class="settings-row">
                        <span class="settings-row-label">Company</span>
                        <span class="settings-row-value">Yuasa Investments Ltd</span>
                    </div>
                    <div class="settings-row">
                        <span class="settings-row-label">Environment</span>
                        <span class="settings-row-value">Local</span>
                    </div>
                    <div class="settings-row">
                        <span class="settings-row-label">API Base URL</span>
                        <span class="settings-row-value">/api</span>
                    </div>
                    <div class="settings-row">
                        <span class="settings-row-label">Database</span>
                        <span class="settings-row-value">MySQL · yuasa_fleet</span>
                    </div>
                    <div class="settings-row">
                        <span class="settings-row-label">Auth</span>
                        <span class="settings-row-value">Laravel Sanctum</span>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="settings-card full">
                    <div class="settings-card-title">🔒 Change Password</div>
                    <div class="pw-form">
                        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px">
                            <div class="form-group">
                                <label for="pwCurrent">Current Password</label>
                                <div class="pw-wrap">
                                    <input type="password" id="pwCurrent" placeholder="••••••••">
                                    <button type="button" class="pw-eye" onclick="togglePw('pwCurrent', this)" tabindex="-1" aria-label="Toggle password visibility">👁</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pwNew">New Password</label>
                                <div class="pw-wrap">
                                    <input type="password" id="pwNew" placeholder="••••••••">
                                    <button type="button" class="pw-eye" onclick="togglePw('pwNew', this)" tabindex="-1" aria-label="Toggle password visibility">👁</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pwConfirm">Confirm New Password</label>
                                <div class="pw-wrap">
                                    <input type="password" id="pwConfirm" placeholder="••••••••">
                                    <button type="button" class="pw-eye" onclick="togglePw('pwConfirm', this)" tabindex="-1" aria-label="Toggle password visibility">👁</button>
                                </div>
                            </div>
                        </div>
                        <button class="pw-save-btn" id="pwSaveBtn" onclick="changePassword()">Update Password</button>
                        <div class="settings-msg" id="pwMsg"></div>
                    </div>
                </div>

            </div>
        </section>

    </main>
</div>
</div><!-- #appShell -->

<script>
    const API = '/api';

    // ── Password visibility toggle ───────────────────────────
    function togglePw(inputId, btn) {
        const input = document.getElementById(inputId);
        const showing = input.type === 'text';
        input.type  = showing ? 'password' : 'text';
        btn.textContent = showing ? '👁' : '🙈';
        btn.style.color = showing ? '#94a3b8' : '#f59e0b';
    }

    // ── Token helpers ────────────────────────────────────────
    function getToken()         { return sessionStorage.getItem('yuasa_token'); }
    function setToken(token)    { sessionStorage.setItem('yuasa_token', token); }
    function clearToken()       { sessionStorage.removeItem('yuasa_token'); }

    // ── Authenticated fetch ──────────────────────────────────
    async function apiGet(endpoint) {
        const response = await fetch(API + endpoint, {
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + getToken()
            }
        });

        if (response.status === 401) {
            // Token expired or invalid — kick back to login
            clearToken();
            showLogin();
            throw new Error('Unauthenticated');
        }

        if (!response.ok) {
            throw new Error('API returned HTTP ' + response.status);
        }

        return response.json();
    }

    async function apiPost(endpoint, body) {
        const response = await fetch(API + endpoint, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + getToken()
            },
            body: JSON.stringify(body)
        });

        return response.json();
    }

    // ── UI toggles ───────────────────────────────────────────
    function showLogin() {
        document.getElementById('loginScreen').style.display = 'flex';
        document.getElementById('appShell').style.display    = 'none';
    }

    function showApp(user) {
        document.getElementById('loginScreen').style.display = 'none';
        document.getElementById('appShell').style.display    = 'block';

        if (user && user.name) {
            document.getElementById('loggedInUser').textContent = user.name;
        }
    }

    // ── Login flow ───────────────────────────────────────────
    document.getElementById('loginForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const btn   = document.getElementById('loginSubmit');
        const errEl = document.getElementById('loginError');

        errEl.style.display = 'none';
        btn.disabled        = true;
        btn.textContent     = 'Signing in…';

        const email    = document.getElementById('loginEmail').value.trim();
        const password = document.getElementById('loginPassword').value;

        try {
            const response = await fetch(API + '/login', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ email, password })
            });

            const data = await response.json();

            if (!response.ok) {
                const msg = data.message
                    || (data.errors && Object.values(data.errors).flat()[0])
                    || 'Login failed. Please check your credentials.';
                throw new Error(msg);
            }

            setToken(data.token);
            showApp(data.user);
            loadDashboard();

        } catch (error) {
            errEl.textContent    = error.message;
            errEl.style.display  = 'block';
        } finally {
            btn.disabled    = false;
            btn.textContent = 'Sign In';
        }
    });

    // ── Logout ───────────────────────────────────────────────
    document.getElementById('logoutBtn').addEventListener('click', async function () {
        try { await apiPost('/logout', {}); } catch (_) { /* ignore */ }
        clearToken();
        showLogin();
    });

    // ── Navigation ───────────────────────────────────────────
    const titles = {
        dashboard: 'Dashboard', vehicles: 'Vehicles', customers: 'Customers',
        bookings: 'Bookings', payments: 'Payments', maintenance: 'Maintenance',
        reports: 'Reports', settings: 'Settings'
    };

    function showSection(section) {
        document.querySelectorAll('.section').forEach(item => {
            item.classList.toggle('active', item.id === section);
        });

        document.querySelectorAll('.nav-link').forEach(link => {
            link.classList.toggle('active', link.dataset.section === section);
        });

        document.getElementById('pageTitle').textContent = titles[section] || 'Dashboard';
        document.getElementById('sidebar').classList.remove('open');

        if (section !== 'dashboard' && section !== 'settings') {
            loadSectionData(section);
        }

        if (section === 'settings') {
            loadSettings();
        }
    }

    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', () => showSection(link.dataset.section));
    });

    document.getElementById('menuButton').addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('open');
    });

    // ── Data helpers ─────────────────────────────────────────
    function extractRows(data) {
        if (Array.isArray(data))            return data;
        if (data && Array.isArray(data.data)) return data.data;
        return [];
    }

    function safe(value) {
        const el = document.createElement('span');
        el.textContent = (value == null) ? '—' : String(value);
        return el.innerHTML;
    }

    // Format ISO date strings to YYYY-MM-DD
    function safeDate(value) {
        if (!value) return '—';
        // Handles "2026-10-21T00:00:00.000000Z" → "2026-10-21"
        return safe(String(value).slice(0, 10));
    }

    function makeTable(rows, columns) {
        if (!rows.length) {
            return '<p class="empty">No records found.</p>';
        }

        let html = '<table><thead><tr>';
        columns.forEach(col => { html += '<th>' + safe(col.label) + '</th>'; });
        html += '</tr></thead><tbody>';

        rows.forEach(row => {
            html += '<tr>';
            columns.forEach(col => {
                html += '<td>' + (col.date ? safeDate(row[col.key]) : safe(row[col.key])) + '</td>';
            });
            html += '</tr>';
        });

        return html + '</tbody></table>';
    }

    // ── Section configurations ───────────────────────────────
    const configurations = {
        vehicles: {
            endpoint: '/vehicles',
            target: 'vehiclesContent',
            columns: [
                { key: 'id',                  label: 'ID'           },
                { key: 'registration_number', label: 'Registration' },
                { key: 'make',                label: 'Make'         },
                { key: 'model',               label: 'Model'        },
                { key: 'year',                label: 'Year'         },
                { key: 'status',              label: 'Status'       }
            ]
        },
        customers: {
            endpoint: '/customers',
            target: 'customersContent',
            columns: [
                { key: 'id',    label: 'ID'    },
                { key: 'name',  label: 'Name'  },
                { key: 'email', label: 'Email' },
                { key: 'phone', label: 'Phone' }
            ]
        },
        bookings: {
            endpoint: '/bookings',
            target: 'bookingsContent',
            columns: [
                { key: 'booking_number', label: 'Reference'   },
                { key: 'customer_id',    label: 'Customer ID' },
                { key: 'vehicle_id',     label: 'Vehicle ID'  },
                { key: 'start_date',     label: 'Start Date',  date: true },
                { key: 'end_date',       label: 'End Date',    date: true },
                { key: 'total_amount',   label: 'Total (UGX)' },
                { key: 'status',         label: 'Status'      }
            ]
        },
        payments: {
            endpoint: '/payments',
            target: 'paymentsContent',
            columns: [
                { key: 'payment_reference', label: 'Reference'  },
                { key: 'booking_id',        label: 'Booking ID' },
                { key: 'amount',            label: 'Amount (UGX)'},
                { key: 'method',            label: 'Method'     },
                { key: 'status',            label: 'Status'     }
            ]
        },
        maintenance: {
            endpoint: '/maintenance',
            target: 'maintenanceContent',
            columns: [
                { key: 'id',             label: 'ID'          },
                { key: 'vehicle_id',     label: 'Vehicle ID'  },
                { key: 'task',           label: 'Task'        },
                { key: 'estimated_cost', label: 'Est. Cost'   },
                { key: 'priority',       label: 'Priority'    },
                { key: 'status',         label: 'Status'      }
            ]
        }
    };

    // ── Reports renderer ─────────────────────────────────────
    function renderReports(d) {
        const fleet       = d.fleet       || {};
        const bookings    = d.bookings    || {};
        const customers   = d.customers   || {};
        const payments    = d.payments    || {};
        const maintenance = d.maintenance || {};

        const util = fleet.utilisation_percent ?? 0;

        const fmtUGX = n => 'UGX ' + Number(n || 0).toLocaleString();

        return `
        <div class="report-grid">

            <!-- Fleet -->
            <div class="report-card">
                <div class="report-card-header">
                    <div class="report-card-icon" style="background:#fef3c7">🚘</div>
                    <div class="report-card-title">Fleet</div>
                </div>
                <div class="report-stat-row">
                    <span class="report-stat-label">Total Vehicles</span>
                    <span class="report-stat-value">${fleet.total ?? 0}</span>
                </div>
                <div class="report-stat-row">
                    <span class="report-stat-label">Available</span>
                    <span class="report-stat-value success">${fleet.available ?? 0}</span>
                </div>
                <div class="report-stat-row">
                    <span class="report-stat-label">Rented Out</span>
                    <span class="report-stat-value highlight">${fleet.rented ?? 0}</span>
                </div>
                <div class="report-stat-row">
                    <span class="report-stat-label">In Maintenance</span>
                    <span class="report-stat-value danger">${fleet.maintenance ?? 0}</span>
                </div>
                <div class="utilisation-bar-wrap">
                    <div class="utilisation-bar" style="width:${Math.min(util,100)}%"></div>
                </div>
                <div class="utilisation-label">Fleet utilisation: <strong>${util}%</strong></div>
            </div>

            <!-- Bookings -->
            <div class="report-card">
                <div class="report-card-header">
                    <div class="report-card-icon" style="background:#e0f2fe">📅</div>
                    <div class="report-card-title">Bookings</div>
                </div>
                <div class="report-stat-row">
                    <span class="report-stat-label">Total Bookings</span>
                    <span class="report-stat-value">${bookings.total ?? 0}</span>
                </div>
                <div class="report-stat-row">
                    <span class="report-stat-label">Active</span>
                    <span class="report-stat-value success">${bookings.active ?? 0}</span>
                </div>
                <div class="report-stat-row">
                    <span class="report-stat-label">Upcoming</span>
                    <span class="report-stat-value highlight">${bookings.upcoming ?? 0}</span>
                </div>
            </div>

            <!-- Customers -->
            <div class="report-card">
                <div class="report-card-header">
                    <div class="report-card-icon" style="background:#f0fdf4">👥</div>
                    <div class="report-card-title">Customers</div>
                </div>
                <div class="report-stat-row">
                    <span class="report-stat-label">Total Registered</span>
                    <span class="report-stat-value">${customers.total ?? 0}</span>
                </div>
            </div>

            <!-- Payments -->
            <div class="report-card">
                <div class="report-card-header">
                    <div class="report-card-icon" style="background:#fdf4ff">💳</div>
                    <div class="report-card-title">Payments</div>
                </div>
                <div class="report-stat-row">
                    <span class="report-stat-label">Total Records</span>
                    <span class="report-stat-value">${payments.records ?? 0}</span>
                </div>
                <div class="report-stat-row">
                    <span class="report-stat-label">Total Collected</span>
                    <span class="report-stat-value success">${fmtUGX(payments.paid_total_ugx)}</span>
                </div>
                <div class="report-stat-row">
                    <span class="report-stat-label">Pending Amount</span>
                    <span class="report-stat-value danger">${fmtUGX(payments.pending_total_ugx)}</span>
                </div>
            </div>

            <!-- Maintenance -->
            <div class="report-card">
                <div class="report-card-header">
                    <div class="report-card-icon" style="background:#fff7ed">🔧</div>
                    <div class="report-card-title">Maintenance</div>
                </div>
                <div class="report-stat-row">
                    <span class="report-stat-label">Total Records</span>
                    <span class="report-stat-value">${maintenance.total ?? 0}</span>
                </div>
                <div class="report-stat-row">
                    <span class="report-stat-label">Open / In Progress</span>
                    <span class="report-stat-value highlight">${maintenance.open ?? 0}</span>
                </div>
                <div class="report-stat-row">
                    <span class="report-stat-label">Overdue</span>
                    <span class="report-stat-value danger">${maintenance.overdue ?? 0}</span>
                </div>
            </div>

        </div>`;
    }

    // ── Admin vehicles card renderer ─────────────────────────
    function renderVehiclesGrid(rows) {
        if (!rows.length) return '<p class="empty">No vehicles found.</p>';

        const statusClass = s => ({
            available:   'status-available',
            rented:      'status-rented',
            maintenance: 'status-maintenance',
        }[s] || 'status-available');

        return `<div class="admin-vehicle-grid">` + rows.map(v => `
            <div class="admin-vehicle-card">
                ${v.image_url
                    ? `<img src="${v.image_url}" alt="${safe(v.name)}"
                            onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">`
                    : ''}
                <div class="admin-vehicle-card-placeholder"
                     style="display:${v.image_url ? 'none' : 'flex'}">🚘</div>
                <div class="admin-vehicle-card-body">
                    <div class="admin-vehicle-card-name">${safe(v.name)}</div>
                    <div class="admin-vehicle-card-reg">${safe(v.registration_number)}</div>
                    <div class="admin-vehicle-card-meta">
                        ${safe(v.make)} ${safe(v.model)} &bull; ${safe(v.year)}<br>
                        Type: ${safe(v.type)} &bull; Seats: ${safe(v.seats)} &bull; Colour: ${safe(v.color)}
                    </div>
                    <div class="admin-vehicle-card-footer">
                        <span class="admin-vehicle-status ${statusClass(v.status)}">${safe(v.status)}</span>
                        <span class="admin-vehicle-rate">UGX ${Number(v.daily_rate).toLocaleString()} / day</span>
                    </div>
                </div>
            </div>
        `).join('') + `</div>`;
    }

    // ── Bookings table renderer (with approve actions) ───────
    function statusBadge(status) {
        const map = {
            pending:   'background:#fef3c7;color:#92400e',
            confirmed: 'background:#dbeafe;color:#1d4ed8',
            active:    'background:#dcfce7;color:#166534',
            completed: 'background:#f1f5f9;color:#475569',
            cancelled: 'background:#fee2e2;color:#991b1b',
        };
        const style = map[status] || 'background:#f1f5f9;color:#475569';
        return `<span style="display:inline-block;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;${style}">${safe(status)}</span>`;
    }

    function renderBookingsTable(rows) {
        if (!rows.length) {
            return '<p class="empty">No bookings found.</p>';
        }

        let html = `<table>
            <thead><tr>
                <th>Reference</th>
                <th>Customer</th>
                <th>Vehicle</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Total (UGX)</th>
                <th>Status</th>
                <th>Action</th>
            </tr></thead><tbody>`;

        rows.forEach(row => {
            const custName  = row.customer?.name  || row.customer_id;
            const vehName   = row.vehicle?.name   || row.vehicle_id;
            const startDate = safeDate(row.start_date);
            const endDate   = safeDate(row.end_date);
            const total     = Number(row.total_amount).toLocaleString();

            // Build action buttons based on current status
            let actions = '—';
            if (row.status === 'pending') {
                actions = `
                    <button onclick="approveBooking(${row.id},'confirmed')"
                        style="padding:5px 12px;background:#dbeafe;color:#1d4ed8;border:none;border-radius:6px;cursor:pointer;font-size:12px;font-weight:600;margin-right:4px">
                        ✔ Approve
                    </button>
                    <button onclick="approveBooking(${row.id},'cancelled')"
                        style="padding:5px 12px;background:#fee2e2;color:#991b1b;border:none;border-radius:6px;cursor:pointer;font-size:12px;font-weight:600">
                        ✕ Reject
                    </button>`;
            } else if (row.status === 'confirmed') {
                actions = `
                    <button onclick="approveBooking(${row.id},'active')"
                        style="padding:5px 12px;background:#dcfce7;color:#166534;border:none;border-radius:6px;cursor:pointer;font-size:12px;font-weight:600;margin-right:4px">
                        🚘 Activate
                    </button>`;
            } else if (row.status === 'active') {
                actions = `
                    <button onclick="approveBooking(${row.id},'completed')"
                        style="padding:5px 12px;background:#f1f5f9;color:#475569;border:none;border-radius:6px;cursor:pointer;font-size:12px;font-weight:600">
                        ✔ Complete
                    </button>`;
            }

            html += `<tr>
                <td style="font-weight:600">${safe(row.booking_number)}</td>
                <td>${safe(custName)}</td>
                <td>${safe(vehName)}</td>
                <td>${startDate}</td>
                <td>${endDate}</td>
                <td>${total}</td>
                <td>${statusBadge(row.status)}</td>
                <td style="white-space:nowrap">${actions}</td>
            </tr>`;
        });

        return html + '</tbody></table>';
    }

    async function approveBooking(bookingId, newStatus) {
        const labels = { confirmed:'approved', cancelled:'rejected', active:'activated', completed:'completed' };
        if (!confirm(`Mark this booking as ${labels[newStatus] || newStatus}?`)) return;

        try {
            const response = await fetch(API + `/bookings/${bookingId}/status`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + getToken()
                },
                body: JSON.stringify({ status: newStatus })
            });

            const data = await response.json();

            if (!response.ok) {
                alert(data.message || 'Could not update booking status.');
                return;
            }

            // Refresh the bookings table
            loadSectionData('bookings');
        } catch (err) {
            alert('Network error. Please try again.');
        }
    }

    // ── Load section data ────────────────────────────────────
    async function loadSectionData(section) {
        if (section === 'reports') {
            const target = document.getElementById('reportsContent');
            target.innerHTML = '<p class="empty">Loading reports…</p>';

            try {
                const result = await apiGet('/reports/summary');
                target.innerHTML = renderReports(result);
            } catch (error) {
                if (error.message !== 'Unauthenticated') {
                    target.innerHTML = '<p class="empty error">Could not load the report. Check the API route and database.</p>';
                }
            }
            return;
        }

        if (section === 'vehicles') {
            const target = document.getElementById(configurations.vehicles.target);
            target.innerHTML = '<p class="empty">Loading vehicles…</p>';
            try {
                const result = await apiGet(configurations.vehicles.endpoint);
                target.innerHTML = renderVehiclesGrid(extractRows(result));
            } catch (error) {
                if (error.message !== 'Unauthenticated') {
                    target.innerHTML = '<p class="empty error">Could not load vehicles.</p>';
                }
            }
            return;
        }

        if (section === 'bookings') {
            const target = document.getElementById(configurations.bookings.target);
            target.innerHTML = '<p class="empty">Loading records…</p>';
            try {
                const result = await apiGet(configurations.bookings.endpoint);
                target.innerHTML = renderBookingsTable(extractRows(result));
            } catch (error) {
                if (error.message !== 'Unauthenticated') {
                    target.innerHTML = '<p class="empty error">Could not load bookings.</p>';
                }
            }
            return;
        }

        const config = configurations[section];
        if (!config) return;

        const target = document.getElementById(config.target);
        target.innerHTML = '<p class="empty">Loading records…</p>';

        try {
            const result = await apiGet(config.endpoint);
            target.innerHTML = makeTable(extractRows(result), config.columns);
        } catch (error) {
            if (error.message !== 'Unauthenticated') {
                target.innerHTML =
                    '<p class="empty error">Could not load records. Check the API route and database connection.</p>';
            }
        }
    }

    // ── Dashboard summary ────────────────────────────────────
    async function loadDashboard() {
        const status = document.getElementById('connectionStatus');
        status.textContent = 'Loading business records…';
        status.classList.remove('error');

        const sections = [
            ['vehicles',  'vehicleCount' ],
            ['customers', 'customerCount'],
            ['bookings',  'bookingCount' ],
            ['payments',  'paymentCount' ]
        ];

        const results = await Promise.allSettled(
            sections.map(async ([section, counter]) => {
                const result = await apiGet(configurations[section].endpoint);
                const rows   = extractRows(result);
                document.getElementById(counter).textContent = rows.length;
                return { section, rows };
            })
        );

        let recent = null;

        results.forEach((result, index) => {
            if (result.status === 'fulfilled') {
                if (result.value.section === 'bookings') {
                    recent = result.value.rows;
                }
            } else {
                document.getElementById(sections[index][1]).textContent = '—';
            }
        });

        const recentTarget = document.getElementById('recentBookings');

        if (recent && recent.length) {
            recentTarget.innerHTML = recent.slice(-5).reverse().map(booking => `
                <tr>
                    <td>${safe(booking.booking_number || booking.id)}</td>
                    <td>${safe(booking.customer_id)}</td>
                    <td>${safe(booking.vehicle_id)}</td>
                    <td><span class="badge">${safe(booking.status)}</span></td>
                </tr>
            `).join('');
        } else {
            recentTarget.innerHTML =
                '<tr><td colspan="4" class="empty">No bookings found.</td></tr>';
        }

        status.textContent =
            'API connected. Data loaded successfully.';
    }

    // ── Settings ─────────────────────────────────────────────
    async function loadSettings() {
        try {
            const data = await apiGet('/me');
            const user = data.user || {};

            document.getElementById('settingName').textContent  = user.name  || '—';
            document.getElementById('settingEmail').textContent = user.email || '—';

            const roleEl = document.getElementById('settingRole');
            roleEl.innerHTML = `<span class="settings-badge admin">${user.role || 'user'}</span>`;

            const activeEl = document.getElementById('settingActive');
            activeEl.innerHTML = user.active
                ? '<span class="settings-badge">Active</span>'
                : '<span class="settings-badge" style="background:#fee2e2;color:#991b1b">Inactive</span>';

        } catch (_) { /* session already handles 401 */ }
    }

    async function changePassword() {
        const btn     = document.getElementById('pwSaveBtn');
        const msgEl   = document.getElementById('pwMsg');
        const current = document.getElementById('pwCurrent').value;
        const nw      = document.getElementById('pwNew').value;
        const confirm = document.getElementById('pwConfirm').value;

        msgEl.className  = 'settings-msg';
        msgEl.style.display = 'none';

        if (!current || !nw || !confirm) {
            msgEl.textContent   = 'Please fill in all three password fields.';
            msgEl.className     = 'settings-msg error';
            msgEl.style.display = 'block';
            return;
        }

        if (nw !== confirm) {
            msgEl.textContent   = 'New password and confirmation do not match.';
            msgEl.className     = 'settings-msg error';
            msgEl.style.display = 'block';
            return;
        }

        if (nw.length < 8) {
            msgEl.textContent   = 'New password must be at least 8 characters.';
            msgEl.className     = 'settings-msg error';
            msgEl.style.display = 'block';
            return;
        }

        btn.disabled    = true;
        btn.textContent = 'Saving…';

        try {
            const response = await fetch(API + '/me/password', {
                method: 'PUT',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + getToken()
                },
                body: JSON.stringify({
                    current_password: current,
                    password: nw,
                    password_confirmation: confirm
                })
            });

            const data = await response.json();

            if (!response.ok) {
                const msg = data.message
                    || (data.errors && Object.values(data.errors).flat()[0])
                    || 'Could not update password.';
                throw new Error(msg);
            }

            msgEl.textContent   = 'Password updated successfully.';
            msgEl.className     = 'settings-msg success';
            msgEl.style.display = 'block';

            document.getElementById('pwCurrent').value = '';
            document.getElementById('pwNew').value     = '';
            document.getElementById('pwConfirm').value = '';

        } catch (error) {
            msgEl.textContent   = error.message;
            msgEl.className     = 'settings-msg error';
            msgEl.style.display = 'block';
        } finally {
            btn.disabled    = false;
            btn.textContent = 'Update Password';
        }
    }

    // ── Boot ─────────────────────────────────────────────────
    (function boot() {
        const token = getToken();

        if (token) {
            // Validate the stored token before showing the app
            fetch(API + '/me', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                }
            })
            .then(res => {
                if (!res.ok) throw new Error('invalid');
                return res.json();
            })
            .then(data => {
                showApp(data.user);
                loadDashboard();
            })
            .catch(() => {
                clearToken();
                showLogin();
            });
        } else {
            showLogin();
        }
    })();
</script>

</body>
</html>
