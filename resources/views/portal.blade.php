<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yuasa Fleet | Customer Portal</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:Arial,sans-serif; }
        body { background:#f4f6fa; color:#1e293b; }

        /* ── Auth screens ───────────────────────────────── */
        .auth-screen {
            display:flex; align-items:center; justify-content:center;
            min-height:100vh;
            background:linear-gradient(135deg,#111827 0%,#1e3a5f 100%);
        }
        .auth-box {
            background:white; border-radius:16px; padding:40px 38px;
            width:100%; max-width:440px; box-shadow:0 20px 60px #00000030;
        }
        .auth-brand { font-size:24px; font-weight:bold; text-align:center; margin-bottom:4px; }
        .auth-brand span { color:#f59e0b; }
        .auth-subtitle { text-align:center; font-size:13px; color:#64748b; margin-bottom:28px; }
        .auth-tabs { display:flex; border-bottom:2px solid #e2e8f0; margin-bottom:24px; }
        .auth-tab {
            flex:1; padding:10px; text-align:center; cursor:pointer;
            font-size:13px; font-weight:600; color:#64748b;
            border-bottom:2px solid transparent; margin-bottom:-2px;
        }
        .auth-tab.active { color:#f59e0b; border-bottom-color:#f59e0b; }
        .form-group { margin-bottom:15px; }
        .form-group label { display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:5px; }
        .form-group input {
            width:100%; padding:11px 13px; border:1.5px solid #e2e8f0;
            border-radius:8px; font-size:13px; outline:none; transition:border-color .2s;
        }
        .form-group input:focus { border-color:#f59e0b; }
        .pw-wrap { position:relative; display:flex; align-items:center; }
        .pw-wrap input { padding-right:42px!important; }
        .pw-eye {
            position:absolute; right:11px; background:none; border:none;
            padding:4px; cursor:pointer; color:#94a3b8; font-size:15px;
            line-height:1; display:flex; align-items:center;
        }
        .pw-eye:hover { color:#374151; background:none; }
        .auth-btn {
            width:100%; padding:12px; background:#f59e0b; color:#111827;
            border:none; border-radius:8px; font-size:15px; font-weight:bold;
            cursor:pointer; margin-top:4px; transition:background .2s;
        }
        .auth-btn:hover { background:#d97706; }
        .auth-btn:disabled { background:#fcd34d; cursor:not-allowed; }
        .auth-error {
            background:#fef2f2; border:1px solid #fecaca; color:#b91c1c;
            border-radius:8px; padding:10px 13px; font-size:13px;
            margin-bottom:14px; display:none;
        }
        .auth-success {
            background:#f0fdf4; border:1px solid #bbf7d0; color:#166534;
            border-radius:8px; padding:10px 13px; font-size:13px;
            margin-bottom:14px; display:none;
        }

        /* ── App shell ──────────────────────────────────── */
        #portalApp { display:none; }
        .portal-header {
            background:#111827; color:white;
            padding:0 30px; display:flex; align-items:center;
            justify-content:space-between; height:62px;
            position:sticky; top:0; z-index:10;
        }
        .portal-brand { font-size:20px; font-weight:bold; }
        .portal-brand span { color:#f59e0b; }
        .portal-nav { display:flex; gap:6px; align-items:center; }
        .pnav-btn {
            background:none; border:none; color:#d1d5db; padding:8px 14px;
            border-radius:7px; cursor:pointer; font-size:13px; font-weight:600;
        }
        .pnav-btn:hover, .pnav-btn.active { background:#f59e0b; color:#111827; }
        .pnav-signout {
            background:#1f2937; border:1px solid #374151; color:#f87171;
            padding:8px 14px; border-radius:7px; cursor:pointer; font-size:13px;
            font-weight:600; margin-left:8px;
        }
        .pnav-signout:hover { background:#374151; }
        .portal-main { max-width:1100px; margin:0 auto; padding:30px 20px; }
        .portal-section { display:none; }
        .portal-section.active { display:block; }

        /* ── Cards ──────────────────────────────────────── */
        .section-title { font-size:22px; font-weight:bold; margin-bottom:6px; }
        .section-sub   { color:#64748b; font-size:14px; margin-bottom:24px; }
        .vehicle-grid {
            display:grid;
            grid-template-columns:repeat(auto-fill,minmax(280px,1fr));
            gap:20px;
        }
        .vehicle-card {
            background:white; border-radius:13px;
            box-shadow:0 3px 12px #00000008; border:2px solid transparent;
            transition:border-color .2s, box-shadow .2s;
            overflow:hidden;
        }
        .vehicle-card:hover { border-color:#f59e0b; box-shadow:0 6px 20px #00000012; }
        .vehicle-card-img {
            width:100%; height:180px; object-fit:cover;
            background:#f1f5f9; display:block;
        }
        .vehicle-card-img-placeholder {
            width:100%; height:180px; background:#f1f5f9;
            display:flex; align-items:center; justify-content:center;
            font-size:48px;
        }
        .vehicle-card-body { padding:18px 20px 20px; }
        .vehicle-card-icon { display:none; }
        .vehicle-card-name { font-size:16px; font-weight:700; margin-bottom:6px; }
        .vehicle-card-meta { font-size:13px; color:#64748b; line-height:1.7; }
        .vehicle-card-rate {
            font-size:20px; font-weight:bold; color:#f59e0b; margin:14px 0 14px;
        }
        .vehicle-card-rate span { font-size:13px; color:#64748b; font-weight:normal; }
        .vc-badge {
            display:inline-block; padding:4px 10px; border-radius:20px;
            font-size:11px; font-weight:600;
            background:#dcfce7; color:#166534; margin-bottom:14px;
        }
        .book-btn {
            width:100%; padding:10px; background:#f59e0b; color:#111827;
            border:none; border-radius:8px; font-weight:bold; cursor:pointer;
            font-size:13px;
        }
        .book-btn:hover { background:#d97706; }

        /* ── Payment form sections ──────────────────────── */
        .pay-form-section { display: none; margin-bottom: 14px; }
        .pay-form-section.show { display: block; }
        .pay-company-box {
            background: #f8fafc; border: 1px solid #e2e8f0;
            border-radius: 10px; padding: 14px 16px; margin-bottom: 14px;
        }
        .pay-company-row {
            display: flex; align-items: center; gap: 10px;
            padding: 6px 0; border-bottom: 1px solid #e5e7eb; font-size: 13px;
        }
        .pay-company-row:last-child { border-bottom: none; }
        .pay-network {
            display: inline-block; padding: 2px 8px; border-radius: 4px;
            font-size: 11px; font-weight: 700; min-width: 44px; text-align: center;
        }
        .pay-network.mtn    { background: #fef3c7; color: #92400e; }
        .pay-network.airtel { background: #fee2e2; color: #991b1b; }
        .pay-number { font-weight: 700; color: #1e293b; flex: 1; }
        .pay-name   { font-size: 12px; color: #64748b; }
        .pay-field-group { margin-bottom: 13px; }
        .pay-field-group label {
            display: block; font-size: 13px; font-weight: 600;
            color: #374151; margin-bottom: 5px;
        }
        .pay-field-group input, .pay-field-group select {
            width: 100%; padding: 10px 13px; border: 1.5px solid #e2e8f0;
            border-radius: 8px; font-size: 13px; outline: none;
            transition: border-color .2s; background: white;
        }
        .pay-field-group input:focus { border-color: #f59e0b; }
        .radio-card {
            flex: 1; border: 1.5px solid #e2e8f0; border-radius: 8px;
            padding: 9px 12px; cursor: pointer; font-size: 13px;
            display: flex; align-items: center; gap: 6px;
            transition: border-color .15s;
        }
        .radio-card:has(input:checked) { border-color: #f59e0b; background: #fffbeb; }

        /* ── Payment method cards ───────────────────────── */
        .pay-methods {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 16px;
        }
        .pay-method-card {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 14px 12px;
            cursor: pointer;
            transition: border-color .15s, background .15s;
            text-align: center;
        }
        .pay-method-card:hover { border-color: #f59e0b; background: #fffbeb; }
        .pay-method-card.selected { border-color: #f59e0b; background: #fef3c7; }
        .pay-method-card .pm-icon { font-size: 26px; margin-bottom: 5px; }
        .pay-method-card .pm-label { font-size: 12px; font-weight: 700; color: #374151; }
        .pay-instructions {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 13px;
            color: #374151;
            line-height: 1.6;
            margin-bottom: 14px;
            display: none;
        }
        .pay-instructions.show { display: block; }
        .pay-instructions strong { color: #1e293b; }
        .pay-amount-box {
            background: #fef3c7;
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 15px;
            font-weight: 700;
            color: #92400e;
            text-align: center;
            margin-bottom: 14px;
        }

        /* ── Booking modal method selector ─────────────── */
        .method-select-wrap { grid-column: 1/-1; }
        .method-select-wrap label { display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px; }
        .method-select-wrap select {
            width:100%; padding:10px 13px; border:1.5px solid #e2e8f0;
            border-radius:8px; font-size:13px; outline:none; background:white;
        }
        .method-select-wrap select:focus { border-color:#f59e0b; }

        /* ── Pay btn in bookings table ──────────────────── */
        .pay-btn {
            padding: 5px 14px;
            background: #f59e0b;
            color: #111827;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 700;
            margin-right: 4px;
        }
        .pay-btn:hover { background: #d97706; }
        .paid-badge {
            display: inline-block;
            padding: 4px 10px;
            background: #dcfce7;
            color: #166534;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }


        .modal-overlay {
            position:fixed; inset:0; background:#00000060;
            display:flex; align-items:center; justify-content:center;
            z-index:100; display:none;
        }
        .modal-overlay.open { display:flex; }
        .modal-box {
            background:white; border-radius:14px; padding:32px;
            width:100%; max-width:500px;
            box-shadow:0 20px 60px #00000030; position:relative;
        }
        .modal-title { font-size:18px; font-weight:700; margin-bottom:18px; }
        .modal-close {
            position:absolute; top:16px; right:18px;
            background:none; border:none; font-size:20px; cursor:pointer; color:#94a3b8;
        }
        .modal-close:hover { color:#374151; background:none; }
        .modal-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
        .modal-full { grid-column:1/-1; }
        .submit-btn {
            width:100%; padding:12px; background:#f59e0b; color:#111827;
            border:none; border-radius:8px; font-weight:bold; cursor:pointer;
            font-size:14px; margin-top:6px;
        }
        .submit-btn:hover { background:#d97706; }
        .submit-btn:disabled { background:#fcd34d; cursor:not-allowed; }
        .modal-msg {
            padding:10px 13px; border-radius:8px; font-size:13px;
            margin-top:12px; display:none;
        }
        .modal-msg.success { background:#f0fdf4; color:#166534; border:1px solid #bbf7d0; }
        .modal-msg.error   { background:#fef2f2; color:#b91c1c; border:1px solid #fecaca; }

        /* ── Bookings table ─────────────────────────────── */
        .panel {
            background:white; border-radius:13px; padding:24px;
            box-shadow:0 3px 12px #00000006;
        }
        .panel-header {
            display:flex; justify-content:space-between; align-items:center;
            margin-bottom:20px;
        }
        .panel-header h2 { font-size:18px; }
        .refresh-btn {
            padding:9px 16px; background:#f59e0b; color:#111827;
            border:none; border-radius:7px; cursor:pointer; font-weight:bold; font-size:13px;
        }
        .refresh-btn:hover { background:#d97706; }
        table { width:100%; border-collapse:collapse; }
        th,td { padding:13px 11px; text-align:left; border-bottom:1px solid #e5e7eb; font-size:13px; }
        th { color:#64748b; font-weight:600; background:#f8fafc; }
        .status-badge {
            display:inline-block; padding:4px 10px; border-radius:20px;
            font-size:11px; font-weight:600;
        }
        .status-pending   { background:#fef3c7; color:#92400e; }
        .status-confirmed { background:#dbeafe; color:#1d4ed8; }
        .status-active    { background:#dcfce7; color:#166534; }
        .status-completed { background:#f1f5f9; color:#475569; }
        .status-cancelled { background:#fee2e2; color:#991b1b; }
        .cancel-btn {
            padding:5px 12px; background:#fee2e2; color:#991b1b;
            border:none; border-radius:6px; cursor:pointer; font-size:12px; font-weight:600;
        }
        .cancel-btn:hover { background:#fecaca; }
        .empty { text-align:center; color:#64748b; padding:30px; }

        /* ── Profile card ───────────────────────────────── */
        .profile-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
        .profile-card {
            background:#f8fafc; border:1px solid #e2e8f0;
            border-radius:12px; padding:22px;
        }
        .profile-card-title {
            font-size:13px; font-weight:700; text-transform:uppercase;
            letter-spacing:.5px; color:#374151; margin-bottom:16px;
        }
        .profile-row {
            display:flex; justify-content:space-between; align-items:center;
            padding:9px 0; border-bottom:1px solid #e5e7eb; font-size:13px;
        }
        .profile-row:last-child { border-bottom:none; }
        .profile-label { color:#64748b; }
        .profile-value { font-weight:600; color:#1e293b; text-align:right; }

        @media(max-width:700px){
            .modal-grid { grid-template-columns:1fr; }
            .profile-grid { grid-template-columns:1fr; }
            .portal-nav { gap:2px; }
            .pnav-btn { padding:7px 10px; font-size:12px; }
        }
    </style>
</head>
<body>

<!-- ══════════════════════════════════════════════════
     AUTH SCREEN
══════════════════════════════════════════════════ -->
<div class="auth-screen" id="authScreen">
    <div class="auth-box">
        <div class="auth-brand">YUASA<span> FLEET</span></div>
        <div class="auth-subtitle">Customer Self-Service Portal</div>

        <div class="auth-tabs">
            <div class="auth-tab active" id="tabLogin" onclick="switchTab('login')">Sign In</div>
            <div class="auth-tab"        id="tabRegister" onclick="switchTab('register')">Create Account</div>
        </div>

        <!-- LOGIN FORM -->
        <div id="loginPane">
            <div class="auth-error" id="loginErr"></div>
            <form id="loginForm">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" id="loginEmail" placeholder="you@example.com" required autocomplete="username">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <div class="pw-wrap">
                        <input type="password" id="loginPass" placeholder="••••••••" required autocomplete="current-password">
                        <button type="button" class="pw-eye" onclick="togglePw('loginPass',this)" tabindex="-1">👁</button>
                    </div>
                </div>
                <button type="submit" class="auth-btn" id="loginBtn">Sign In</button>
            </form>
        </div>

        <!-- REGISTER FORM -->
        <div id="registerPane" style="display:none">
            <div class="auth-error"   id="regErr"></div>
            <div class="auth-success" id="regOk"></div>
            <form id="registerForm">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" id="regName" placeholder="Your full name" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" id="regEmail" placeholder="you@example.com" required>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" id="regPhone" placeholder="+256 7XX XXX XXX" required>
                </div>
                <div class="form-group">
                    <label>Address (optional)</label>
                    <input type="text" id="regAddress" placeholder="Kampala, Uganda">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <div class="pw-wrap">
                        <input type="password" id="regPass" placeholder="Min 8 characters" required>
                        <button type="button" class="pw-eye" onclick="togglePw('regPass',this)" tabindex="-1">👁</button>
                    </div>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <div class="pw-wrap">
                        <input type="password" id="regPassConfirm" placeholder="Repeat password" required>
                        <button type="button" class="pw-eye" onclick="togglePw('regPassConfirm',this)" tabindex="-1">👁</button>
                    </div>
                </div>
                <button type="submit" class="auth-btn" id="regBtn">Create Account</button>
            </form>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════════════
     PORTAL APP
══════════════════════════════════════════════════ -->
<div id="portalApp">

    <header class="portal-header">
        <div class="portal-brand">YUASA<span> FLEET</span></div>
        <nav class="portal-nav">
            <button class="pnav-btn active" onclick="showPortalSection('browse')">🚘 Browse Cars</button>
            <button class="pnav-btn"        onclick="showPortalSection('mybookings')">📅 My Bookings</button>
            <button class="pnav-btn"        onclick="showPortalSection('profile')">👤 Profile</button>
            <button class="pnav-signout"    onclick="portalSignOut()">⏻ Sign Out</button>
        </nav>
    </header>

    <main class="portal-main">

        <!-- BROWSE -->
        <section class="portal-section active" id="browse">
            <div class="section-title">Available Vehicles</div>
            <div class="section-sub">Choose a vehicle and pick your rental dates.</div>
            <div class="vehicle-grid" id="vehicleGrid">
                <p class="empty">Loading vehicles…</p>
            </div>
        </section>

        <!-- MY BOOKINGS -->
        <section class="portal-section" id="mybookings">
            <div class="panel">
                <div class="panel-header">
                    <h2>My Bookings</h2>
                    <button class="refresh-btn" onclick="loadMyBookings()">Refresh</button>
                </div>
                <div id="bookingsTableWrap">
                    <p class="empty">Loading your bookings…</p>
                </div>
            </div>
        </section>

        <!-- PROFILE -->
        <section class="portal-section" id="profile">
            <div class="section-title">My Profile</div>
            <div class="section-sub">Your account and contact details.</div>
            <div class="profile-grid" id="profileGrid">
                <p class="empty">Loading profile…</p>
            </div>
        </section>

    </main>
</div>

<!-- ══════════════════════════════════════════════════
     BOOKING MODAL
══════════════════════════════════════════════════ -->
<div class="modal-overlay" id="bookingModal">
    <div class="modal-box">
        <button class="modal-close" onclick="closeModal()">✕</button>
        <div class="modal-title" id="modalTitle">Book Vehicle</div>
        <form id="bookingForm">
            <input type="hidden" id="bookVehicleId">
            <div class="modal-grid">
                <div class="form-group">
                    <label>Start Date</label>
                    <input type="date" id="bookStart" required>
                </div>
                <div class="form-group">
                    <label>End Date</label>
                    <input type="date" id="bookEnd" required>
                </div>
                <div class="form-group">
                    <label>Pickup Location</label>
                    <input type="text" id="bookPickup" placeholder="e.g. Kampala CBD">
                </div>
                <div class="form-group">
                    <label>Return Location</label>
                    <input type="text" id="bookReturn" placeholder="e.g. Entebbe Airport">
                </div>
                <div class="form-group modal-full">
                    <label>Notes (optional)</label>
                    <input type="text" id="bookNotes" placeholder="Any special requests…">
                </div>
                <div class="method-select-wrap">
                    <label>Preferred Payment Method</label>
                    <select id="bookPayMethod">
                        <option value="">— Select method —</option>
                        <option value="mobile_money">📱 Mobile Money (MTN / Airtel)</option>
                        <option value="bank_transfer">🏦 Bank Transfer</option>
                        <option value="card">💳 Credit / Debit Card</option>
                        <option value="cash">💵 Cash on Pickup</option>
                    </select>
                </div>
                <div class="modal-full">
                    <div id="bookEstimate" style="font-size:14px;color:#64748b;margin-bottom:8px;"></div>
                </div>
            </div>
            <button type="submit" class="submit-btn" id="bookSubmitBtn">Confirm Booking</button>
            <div class="modal-msg" id="bookMsg"></div>
        </form>
    </div>
</div>

<!-- ══════════════════════════════════════════════════
     PAYMENT MODAL
══════════════════════════════════════════════════ -->
<div class="modal-overlay" id="paymentModal">
    <div class="modal-box" style="max-width:500px;max-height:90vh;overflow-y:auto">
        <button class="modal-close" onclick="closePayModal()">✕</button>
        <div class="modal-title">💳 Make Payment</div>
        <input type="hidden" id="payBookingId">

        <div class="pay-amount-box" id="payAmountBox">UGX —</div>
        <div style="font-size:12px;color:#64748b;text-align:center;margin-top:-10px;margin-bottom:16px" id="payBookingRef"></div>

        <!-- Method selector -->
        <div style="font-size:13px;font-weight:600;color:#374151;margin-bottom:10px">Select Payment Method</div>
        <div class="pay-methods">
            <div class="pay-method-card" onclick="selectPayMethod('mobile_money',this)">
                <div class="pm-icon">📱</div><div class="pm-label">Mobile Money</div>
            </div>
            <div class="pay-method-card" onclick="selectPayMethod('bank_transfer',this)">
                <div class="pm-icon">🏦</div><div class="pm-label">Bank Transfer</div>
            </div>
            <div class="pay-method-card" onclick="selectPayMethod('card',this)">
                <div class="pm-icon">💳</div><div class="pm-label">Card</div>
            </div>
            <div class="pay-method-card" onclick="selectPayMethod('cash',this)">
                <div class="pm-icon">💵</div><div class="pm-label">Cash on Pickup</div>
            </div>
        </div>

        <!-- ── MOBILE MONEY FORM ─────────────────────── -->
        <div class="pay-form-section" id="form-mobile_money">
            <div class="pay-company-box">
                <div style="font-size:12px;font-weight:700;color:#64748b;margin-bottom:8px;text-transform:uppercase;letter-spacing:.5px">Send Payment To</div>
                <div class="pay-company-row">
                    <span class="pay-network mtn">MTN</span>
                    <span class="pay-number">0774 000 000</span>
                    <span class="pay-name">Yuasa Investments Ltd</span>
                </div>
                <div class="pay-company-row">
                    <span class="pay-network airtel">Airtel</span>
                    <span class="pay-number">0752 000 000</span>
                    <span class="pay-name">Yuasa Investments Ltd</span>
                </div>
            </div>
            <div style="font-size:12px;color:#64748b;margin-bottom:14px">
                Enter your details below, then send the money from your phone using the number above. Paste your transaction ID once done.
            </div>
            <div class="pay-field-group">
                <label>Your Network</label>
                <div style="display:flex;gap:10px">
                    <label class="radio-card">
                        <input type="radio" name="mmNetwork" value="MTN"> MTN Mobile Money
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="mmNetwork" value="Airtel"> Airtel Money
                    </label>
                </div>
            </div>
            <div class="pay-field-group">
                <label>Your Mobile Money Number</label>
                <input type="tel" id="mmPhone" placeholder="e.g. 0774 123 456" maxlength="20">
            </div>
            <div class="pay-field-group">
                <label>Account Name (as registered on mobile money)</label>
                <input type="text" id="mmName" placeholder="e.g. John Doe">
            </div>
            <div class="pay-field-group">
                <label>Transaction ID / Reference <span style="color:#94a3b8;font-weight:400">(after sending)</span></label>
                <input type="text" id="mmTxId" placeholder="e.g. TXN1234567890">
            </div>
        </div>

        <!-- ── BANK TRANSFER FORM ────────────────────── -->
        <div class="pay-form-section" id="form-bank_transfer">
            <div class="pay-company-box">
                <div style="font-size:12px;font-weight:700;color:#64748b;margin-bottom:8px;text-transform:uppercase;letter-spacing:.5px">Transfer To</div>
                <table style="width:100%;font-size:13px;border-collapse:collapse">
                    <tr><td style="color:#64748b;padding:4px 0;width:140px">Bank</td><td><strong>Stanbic Bank Uganda</strong></td></tr>
                    <tr><td style="color:#64748b;padding:4px 0">Account Name</td><td><strong>Yuasa Investments Ltd</strong></td></tr>
                    <tr><td style="color:#64748b;padding:4px 0">Account Number</td><td><strong>9030012345678</strong></td></tr>
                    <tr><td style="color:#64748b;padding:4px 0">Branch</td><td><strong>Kampala Road</strong></td></tr>
                    <tr><td style="color:#64748b;padding:4px 0">Swift Code</td><td><strong>SBICUGKX</strong></td></tr>
                </table>
            </div>
            <div style="font-size:12px;color:#64748b;margin-bottom:14px">
                Fill in your bank details below and enter the transfer reference after completing the transaction at your bank or via mobile banking.
            </div>
            <div class="pay-field-group">
                <label>Your Bank Name</label>
                <input type="text" id="btBank" placeholder="e.g. Centenary Bank, Equity Bank…">
            </div>
            <div class="pay-field-group">
                <label>Your Account Name</label>
                <input type="text" id="btAccName" placeholder="As it appears on your account">
            </div>
            <div class="pay-field-group">
                <label>Your Account Number</label>
                <input type="text" id="btAccNo" placeholder="e.g. 1234567890">
            </div>
            <div class="pay-field-group">
                <label>Transfer Reference / Receipt Number <span style="color:#94a3b8;font-weight:400">(after transfer)</span></label>
                <input type="text" id="btRef" placeholder="e.g. TRF20261021001">
            </div>
        </div>

        <!-- ── CARD FORM ─────────────────────────────── -->
        <div class="pay-form-section" id="form-card">
            <div class="pay-company-box" style="background:#f0f9ff;border-color:#bae6fd">
                <div style="font-size:12px;color:#0369a1">
                    🔒 Card details are <strong>recorded for verification only</strong>. Payment is confirmed by Yuasa Investments staff. We accept Visa and Mastercard.
                </div>
            </div>
            <div class="pay-field-group">
                <label>Cardholder Name</label>
                <input type="text" id="cardName" placeholder="Name as on card" autocomplete="cc-name">
            </div>
            <div class="pay-field-group">
                <label>Card Number</label>
                <input type="text" id="cardNumber" placeholder="1234 5678 9012 3456" maxlength="19"
                    oninput="fmtCard(this)" autocomplete="cc-number">
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                <div class="pay-field-group">
                    <label>Expiry Date</label>
                    <input type="text" id="cardExpiry" placeholder="MM / YY" maxlength="7"
                        oninput="fmtExpiry(this)" autocomplete="cc-exp">
                </div>
                <div class="pay-field-group">
                    <label>CVV</label>
                    <div style="position:relative">
                        <input type="password" id="cardCvv" placeholder="•••" maxlength="4"
                            style="width:100%" autocomplete="cc-csc">
                        <button type="button" class="pw-eye" onclick="togglePw('cardCvv',this)" tabindex="-1">👁</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── CASH FORM ─────────────────────────────── -->
        <div class="pay-form-section" id="form-cash">
            <div class="pay-company-box" style="text-align:center">
                <div style="font-size:32px;margin-bottom:8px">💵</div>
                <div style="font-weight:700;color:#1e293b;margin-bottom:6px">Pay Cash on Vehicle Pickup</div>
                <div style="font-size:13px;color:#64748b;line-height:1.6">
                    Bring the <strong>exact amount in UGX</strong> when you come to pick up the vehicle.<br>
                    A receipt will be issued on the spot.<br>
                    <strong>Office:</strong> Kireka, Kampala &nbsp;|&nbsp; <strong>Hours:</strong> Mon–Sat, 8am–6pm
                </div>
            </div>
            <div class="pay-field-group">
                <label>Your Name (for receipt)</label>
                <input type="text" id="cashName" placeholder="Your full name">
            </div>
            <div class="pay-field-group">
                <label>Notes (optional)</label>
                <input type="text" id="cashNotes" placeholder="Any message for staff…">
            </div>
        </div>

        <input type="hidden" id="paySelectedMethod" value="">
        <button class="submit-btn" id="paySubmitBtn" onclick="submitPayment()" disabled style="opacity:0.5;margin-top:6px">
            Submit Payment
        </button>
        <div class="modal-msg" id="payMsg"></div>
    </div>
</div>

<script>
    const API = '/api';

    // ── Token helpers ──────────────────────────────────────────
    const getToken  = () => sessionStorage.getItem('portal_token');
    const setToken  = t  => sessionStorage.setItem('portal_token', t);
    const clearToken= () => sessionStorage.removeItem('portal_token');

    // ── Password toggle ────────────────────────────────────────
    function togglePw(id, btn) {
        const inp = document.getElementById(id);
        const show = inp.type === 'text';
        inp.type = show ? 'password' : 'text';
        btn.textContent = show ? '👁' : '🙈';
        btn.style.color = show ? '#94a3b8' : '#f59e0b';
    }

    // ── Tab switch ─────────────────────────────────────────────
    function switchTab(tab) {
        document.getElementById('loginPane').style.display    = tab === 'login'    ? 'block' : 'none';
        document.getElementById('registerPane').style.display = tab === 'register' ? 'block' : 'none';
        document.getElementById('tabLogin').classList.toggle('active',    tab === 'login');
        document.getElementById('tabRegister').classList.toggle('active', tab === 'register');
    }

    // ── API fetch helpers ──────────────────────────────────────
    async function apiGet(endpoint) {
        const res = await fetch(API + endpoint, {
            headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + getToken() }
        });
        if (res.status === 401) { clearToken(); showAuth(); throw new Error('Unauthenticated'); }
        if (!res.ok) throw new Error('HTTP ' + res.status);
        return res.json();
    }

    async function apiPost(endpoint, body) {
        const res = await fetch(API + endpoint, {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'Content-Type': 'application/json',
                       'Authorization': 'Bearer ' + getToken() },
            body: JSON.stringify(body)
        });
        return { ok: res.ok, status: res.status, data: await res.json() };
    }

    // ── UI toggles ─────────────────────────────────────────────
    function showAuth() {
        document.getElementById('authScreen').style.display = 'flex';
        document.getElementById('portalApp').style.display  = 'none';
    }

    function showPortal() {
        document.getElementById('authScreen').style.display = 'none';
        document.getElementById('portalApp').style.display  = 'block';
        loadVehicles();
    }

    function showPortalSection(id) {
        document.querySelectorAll('.portal-section').forEach(s => s.classList.remove('active'));
        document.querySelectorAll('.pnav-btn').forEach(b => b.classList.remove('active'));
        document.getElementById(id).classList.add('active');
        event.currentTarget.classList.add('active');
        if (id === 'mybookings') loadMyBookings();
        if (id === 'profile')    loadProfile();
    }

    // ── Login ──────────────────────────────────────────────────
    document.getElementById('loginForm').addEventListener('submit', async e => {
        e.preventDefault();
        const btn = document.getElementById('loginBtn');
        const err = document.getElementById('loginErr');
        err.style.display = 'none';
        btn.disabled = true; btn.textContent = 'Signing in…';

        const res = await fetch(API + '/login', {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
            body: JSON.stringify({
                email:    document.getElementById('loginEmail').value.trim(),
                password: document.getElementById('loginPass').value
            })
        });
        const data = await res.json();

        if (!res.ok) {
            err.textContent = data.message || Object.values(data.errors||{}).flat()[0] || 'Login failed.';
            err.style.display = 'block';
        } else if (data.user && data.user.role !== 'customer') {
            err.textContent = 'This portal is for customers only. Staff should use the main dashboard.';
            err.style.display = 'block';
        } else {
            setToken(data.token);
            showPortal();
        }

        btn.disabled = false; btn.textContent = 'Sign In';
    });

    // ── Register ───────────────────────────────────────────────
    document.getElementById('registerForm').addEventListener('submit', async e => {
        e.preventDefault();
        const btn = document.getElementById('regBtn');
        const err = document.getElementById('regErr');
        const ok  = document.getElementById('regOk');
        err.style.display = 'none'; ok.style.display = 'none';

        const pass    = document.getElementById('regPass').value;
        const confirm = document.getElementById('regPassConfirm').value;

        if (pass !== confirm) {
            err.textContent = 'Passwords do not match.';
            err.style.display = 'block'; return;
        }

        btn.disabled = true; btn.textContent = 'Creating account…';

        const res = await fetch(API + '/customer/register', {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
            body: JSON.stringify({
                name:                  document.getElementById('regName').value.trim(),
                email:                 document.getElementById('regEmail').value.trim(),
                phone:                 document.getElementById('regPhone').value.trim(),
                address:               document.getElementById('regAddress').value.trim(),
                password:              pass,
                password_confirmation: confirm,
            })
        });
        const data = await res.json();

        if (!res.ok) {
            err.textContent = data.message || Object.values(data.errors||{}).flat()[0] || 'Registration failed.';
            err.style.display = 'block';
        } else {
            setToken(data.token);
            showPortal();
        }

        btn.disabled = false; btn.textContent = 'Create Account';
    });

    // ── Sign out ───────────────────────────────────────────────
    async function portalSignOut() {
        try { await apiPost('/logout', {}); } catch(_) {}
        clearToken(); showAuth();
    }

    // ── Load vehicles ──────────────────────────────────────────
    async function loadVehicles() {
        const grid = document.getElementById('vehicleGrid');
        grid.innerHTML = '<p class="empty">Loading vehicles…</p>';
        try {
            const vehicles = await apiGet('/portal/vehicles');
            if (!vehicles.length) {
                grid.innerHTML = '<p class="empty">No vehicles available at the moment.</p>'; return;
            }
            grid.innerHTML = vehicles.map(v => `
                <div class="vehicle-card">
                    ${v.image_url
                        ? `<img class="vehicle-card-img" src="${v.image_url}" alt="${safe(v.name)}" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">`
                        : ''}
                    <div class="vehicle-card-img-placeholder" style="display:${v.image_url ? 'none' : 'flex'}">🚘</div>
                    <div class="vehicle-card-body">
                        <div class="vehicle-card-name">${safe(v.name)}</div>
                        <div class="vehicle-card-meta">
                            ${safe(v.make)} ${safe(v.model)} &bull; ${safe(v.year)}<br>
                            Type: ${safe(v.type)} &bull; Seats: ${safe(v.seats)}<br>
                            Colour: ${safe(v.color)}
                        </div>
                        <div class="vehicle-card-rate">
                            UGX ${Number(v.daily_rate).toLocaleString()}
                            <span>/ day</span>
                        </div>
                        <span class="vc-badge">Available</span><br>
                        <button class="book-btn" onclick="openBookingModal(${v.id}, '${safe(v.name)}', ${v.daily_rate})">
                            Book This Vehicle
                        </button>
                    </div>
                </div>
            `).join('');
        } catch(err) {
            if (err.message !== 'Unauthenticated')
                grid.innerHTML = '<p class="empty">Could not load vehicles.</p>';
        }
    }

    // ── Booking modal ──────────────────────────────────────────
    let activeDailyRate = 0;

    function openBookingModal(vehicleId, vehicleName, dailyRate) {
        document.getElementById('bookVehicleId').value = vehicleId;
        document.getElementById('modalTitle').textContent = 'Book: ' + vehicleName;
        activeDailyRate = parseFloat(dailyRate);
        document.getElementById('bookMsg').style.display = 'none';
        document.getElementById('bookEstimate').textContent = '';
        document.getElementById('bookStart').value = '';
        document.getElementById('bookEnd').value   = '';
        document.getElementById('bookPickup').value = '';
        document.getElementById('bookReturn').value = '';
        document.getElementById('bookNotes').value  = '';

        // Set min date to today
        document.getElementById('bookStart').min = new Date().toISOString().split('T')[0];
        document.getElementById('bookEnd').min   = new Date().toISOString().split('T')[0];

        document.getElementById('bookingModal').classList.add('open');
    }

    function closeModal() {
        document.getElementById('bookingModal').classList.remove('open');
    }

    // Live cost estimate
    ['bookStart', 'bookEnd'].forEach(id => {
        document.getElementById(id).addEventListener('change', updateEstimate);
    });

    function updateEstimate() {
        const s = document.getElementById('bookStart').value;
        const e = document.getElementById('bookEnd').value;
        const el = document.getElementById('bookEstimate');
        if (s && e && e >= s) {
            const days = Math.max(1, Math.round((new Date(e) - new Date(s)) / 86400000));
            const total = days * activeDailyRate;
            el.innerHTML = `<strong>${days} day${days>1?'s':''}</strong> &times; UGX ${Number(activeDailyRate).toLocaleString()} = <strong style="color:#f59e0b">UGX ${Number(total).toLocaleString()}</strong>`;
        } else {
            el.textContent = '';
        }
    }

    document.getElementById('bookingForm').addEventListener('submit', async e => {
        e.preventDefault();
        const btn = document.getElementById('bookSubmitBtn');
        const msg = document.getElementById('bookMsg');
        msg.style.display = 'none';
        btn.disabled = true; btn.textContent = 'Submitting…';

        const { ok, data } = await apiPost('/portal/book', {
            vehicle_id:      parseInt(document.getElementById('bookVehicleId').value),
            start_date:      document.getElementById('bookStart').value,
            end_date:        document.getElementById('bookEnd').value,
            pickup_location: document.getElementById('bookPickup').value,
            return_location: document.getElementById('bookReturn').value,
            notes:           document.getElementById('bookNotes').value,
        });

        if (ok) {
            msg.textContent   = `Booking submitted! Reference: ${data.booking_number}. A staff member will confirm it shortly.`;
            msg.className     = 'modal-msg success';
            msg.style.display = 'block';
            loadVehicles(); // refresh availability
        } else {
            msg.textContent   = data.message || 'Could not submit booking. Please try again.';
            msg.className     = 'modal-msg error';
            msg.style.display = 'block';
        }

        btn.disabled = false; btn.textContent = 'Confirm Booking';
    });

    // Close modal on overlay click
    document.getElementById('bookingModal').addEventListener('click', e => {
        if (e.target === document.getElementById('bookingModal')) closeModal();
    });

    // ── My bookings ────────────────────────────────────────────
    async function loadMyBookings() {
        const wrap = document.getElementById('bookingsTableWrap');
        wrap.innerHTML = '<p class="empty">Loading…</p>';
        try {
            const bookings = await apiGet('/portal/my-bookings');
            if (!bookings.length) {
                wrap.innerHTML = '<p class="empty">No bookings yet. Browse vehicles to make your first booking.</p>'; return;
            }
            wrap.innerHTML = `
                <table>
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Vehicle</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Days</th>
                            <th>Total (UGX)</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        ${bookings.map(b => {
                            const hasPaid    = b.payment_status === 'paid';
                            const hasPending = b.payment_status === 'pending';
                            const canPay     = ['confirmed','active'].includes(b.status) && !hasPaid && !hasPending;

                            let payCell = '—';
                            if (hasPaid)    payCell = '<span class="paid-badge">✔ Paid</span>';
                            else if (hasPending) payCell = '<span style="color:#92400e;font-size:12px;font-weight:600">⏳ Pending</span>';
                            else if (canPay) payCell = `<button class="pay-btn" onclick="openPayModal(${b.id}, ${b.total_amount}, '${b.booking_number}')">💳 Pay Now</button>`;

                            return `<tr>
                                <td style="font-weight:600">${safe(b.booking_number)}</td>
                                <td>${safe(b.vehicle?.name || '—')}</td>
                                <td>${safe(String(b.start_date).slice(0,10))}</td>
                                <td>${safe(String(b.end_date).slice(0,10))}</td>
                                <td>${safe(b.days)}</td>
                                <td>${Number(b.total_amount).toLocaleString()}</td>
                                <td><span class="status-badge status-${b.status}">${safe(b.status)}</span></td>
                                <td>${payCell}</td>
                                <td>
                                    ${['pending','confirmed'].includes(b.status)
                                        ? `<button class="cancel-btn" onclick="cancelBooking(${b.id})">Cancel</button>`
                                        : ''}
                                </td>
                            </tr>`;
                        }).join('')}
                    </tbody>
                </table>
            `;
        } catch(err) {
            if (err.message !== 'Unauthenticated')
                wrap.innerHTML = '<p class="empty">Could not load bookings.</p>';
        }
    }

    async function cancelBooking(id) {
        if (!confirm('Are you sure you want to cancel this booking?')) return;
        const { ok, data } = await apiPost(`/portal/bookings/${id}/cancel`, {});
        if (ok) { loadMyBookings(); }
        else { alert(data.message || 'Could not cancel booking.'); }
    }

    // ── Payment modal ──────────────────────────────────────────
    function openPayModal(bookingId, amount, bookingRef) {
        document.getElementById('payBookingId').value = bookingId;
        document.getElementById('payAmountBox').textContent = 'UGX ' + Number(amount).toLocaleString();
        document.getElementById('payBookingRef').textContent = 'Booking: ' + (bookingRef || '');
        document.getElementById('paySelectedMethod').value = '';
        document.getElementById('payMsg').style.display = 'none';
        document.getElementById('paySubmitBtn').disabled = true;
        document.getElementById('paySubmitBtn').style.opacity = '0.5';
        document.getElementById('paySubmitBtn').textContent = 'Submit Payment';
        // Reset
        document.querySelectorAll('.pay-method-card').forEach(c => c.classList.remove('selected'));
        document.querySelectorAll('.pay-form-section').forEach(s => s.classList.remove('show'));
        document.getElementById('paymentModal').classList.add('open');
    }

    function closePayModal() {
        document.getElementById('paymentModal').classList.remove('open');
    }

    document.getElementById('paymentModal').addEventListener('click', e => {
        if (e.target === document.getElementById('paymentModal')) closePayModal();
    });

    function selectPayMethod(method, card) {
        document.querySelectorAll('.pay-method-card').forEach(c => c.classList.remove('selected'));
        card.classList.add('selected');
        document.getElementById('paySelectedMethod').value = method;
        document.querySelectorAll('.pay-form-section').forEach(s => s.classList.remove('show'));
        const form = document.getElementById('form-' + method);
        if (form) form.classList.add('show');
        document.getElementById('paySubmitBtn').disabled = false;
        document.getElementById('paySubmitBtn').style.opacity = '1';
    }

    // Card number formatter
    function fmtCard(input) {
        let v = input.value.replace(/\D/g,'').substring(0,16);
        input.value = v.replace(/(.{4})/g,'$1 ').trim();
    }
    // Expiry formatter
    function fmtExpiry(input) {
        let v = input.value.replace(/\D/g,'').substring(0,4);
        if (v.length > 2) v = v.substring(0,2) + ' / ' + v.substring(2);
        input.value = v;
    }

    async function submitPayment() {
        const btn    = document.getElementById('paySubmitBtn');
        const msg    = document.getElementById('payMsg');
        const method = document.getElementById('paySelectedMethod').value;
        const bookingId = parseInt(document.getElementById('payBookingId').value);
        msg.style.display = 'none';

        if (!method) {
            msg.textContent = 'Please select a payment method.';
            msg.className = 'modal-msg error'; msg.style.display = 'block'; return;
        }

        // Build notes from the form fields
        let notes = '';
        if (method === 'mobile_money') {
            const network = document.querySelector('input[name="mmNetwork"]:checked')?.value || '';
            const phone   = document.getElementById('mmPhone').value.trim();
            const name    = document.getElementById('mmName').value.trim();
            const txId    = document.getElementById('mmTxId').value.trim();
            if (!phone) {
                msg.textContent = 'Please enter your mobile money number.';
                msg.className = 'modal-msg error'; msg.style.display = 'block'; return;
            }
            notes = `Network: ${network} | Phone: ${phone} | Name: ${name} | Tx ID: ${txId}`;
        } else if (method === 'bank_transfer') {
            const bank    = document.getElementById('btBank').value.trim();
            const accName = document.getElementById('btAccName').value.trim();
            const accNo   = document.getElementById('btAccNo').value.trim();
            const ref     = document.getElementById('btRef').value.trim();
            if (!bank || !accNo) {
                msg.textContent = 'Please enter your bank name and account number.';
                msg.className = 'modal-msg error'; msg.style.display = 'block'; return;
            }
            notes = `Bank: ${bank} | Acc Name: ${accName} | Acc No: ${accNo} | Ref: ${ref}`;
        } else if (method === 'card') {
            const name   = document.getElementById('cardName').value.trim();
            const number = document.getElementById('cardNumber').value.trim();
            const expiry = document.getElementById('cardExpiry').value.trim();
            if (!name || !number || !expiry) {
                msg.textContent = 'Please fill in all card details.';
                msg.className = 'modal-msg error'; msg.style.display = 'block'; return;
            }
            // Store only last 4 digits for security
            const last4 = number.replace(/\s/g,'').slice(-4);
            notes = `Cardholder: ${name} | Card ending: ****${last4} | Expiry: ${expiry}`;
        } else if (method === 'cash') {
            const name  = document.getElementById('cashName').value.trim();
            const extra = document.getElementById('cashNotes').value.trim();
            notes = `Cash on pickup | Name: ${name}${extra ? ' | Note: ' + extra : ''}`;
        }

        btn.disabled = true; btn.textContent = 'Submitting…';

        const { ok, data } = await apiPost('/portal/pay', {
            booking_id: bookingId,
            method:     method,
            notes:      notes,
        });

        if (ok) {
            msg.textContent   = `✔ Payment submitted! Reference: ${data.reference}. Staff will verify and confirm.`;
            msg.className     = 'modal-msg success';
            msg.style.display = 'block';
            btn.textContent   = 'Submitted ✔';
            setTimeout(() => { closePayModal(); loadMyBookings(); }, 3000);
        } else {
            msg.textContent   = data.message || 'Could not submit payment. Please try again.';
            msg.className     = 'modal-msg error';
            msg.style.display = 'block';
            btn.disabled = false; btn.textContent = 'Submit Payment';
        }
    }

    // ── Profile ────────────────────────────────────────────────
    async function loadProfile() {
        const grid = document.getElementById('profileGrid');
        grid.innerHTML = '<p class="empty">Loading…</p>';
        try {
            const { user, customer } = await apiGet('/portal/profile');
            grid.innerHTML = `
                <div class="profile-card">
                    <div class="profile-card-title">👤 Account</div>
                    <div class="profile-row"><span class="profile-label">Name</span><span class="profile-value">${safe(user.name)}</span></div>
                    <div class="profile-row"><span class="profile-label">Email</span><span class="profile-value">${safe(user.email)}</span></div>
                    <div class="profile-row"><span class="profile-label">Role</span><span class="profile-value">Customer</span></div>
                </div>
                <div class="profile-card">
                    <div class="profile-card-title">📋 Contact Info</div>
                    <div class="profile-row"><span class="profile-label">Phone</span><span class="profile-value">${safe(customer?.phone||'—')}</span></div>
                    <div class="profile-row"><span class="profile-label">Address</span><span class="profile-value">${safe(customer?.address||'—')}</span></div>
                    <div class="profile-row"><span class="profile-label">Customer Type</span><span class="profile-value">${safe(customer?.customer_type||'—')}</span></div>
                    <div class="profile-row"><span class="profile-label">Member Since</span><span class="profile-value">${safe(user.created_at?.slice(0,10)||'—')}</span></div>
                </div>
            `;
        } catch(err) {
            if (err.message !== 'Unauthenticated')
                grid.innerHTML = '<p class="empty">Could not load profile.</p>';
        }
    }

    // ── Helpers ────────────────────────────────────────────────
    function safe(v) {
        const el = document.createElement('span');
        el.textContent = (v == null) ? '—' : String(v);
        return el.innerHTML;
    }

    // ── Boot ───────────────────────────────────────────────────
    (function boot() {
        const token = getToken();
        if (token) {
            fetch(API + '/portal/profile', {
                headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token }
            })
            .then(r => { if (!r.ok) throw new Error('invalid'); return r.json(); })
            .then(() => showPortal())
            .catch(() => { clearToken(); showAuth(); });
        } else {
            showAuth();
        }
    })();
</script>
</body>
</html>
