<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BloodLink') — BloodLink</title>

    {{-- Google Fonts: Outfit for Display, Plus Jakarta Sans for Body --}}
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    {{-- DataTables --}}
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    {{-- SweetAlert2 --}}
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

    <style>
        *, *::before, *::after { box-sizing: border-box; }

        :root {
            /* Color Palette: Professional Light Mode */
            --bg-base:        #F3F4F6; /* Light gray background */
            --bg-surface:     #FFFFFF; /* White cards */
            --bg-surface-2:   #F9FAFB; /* Very light gray for hovers/nested */
            --primary:        #E11D48; /* Professional Deep Red */
            --primary-hover:  #BE123C;
            --primary-glow:   rgba(225, 29, 72, 0.15); /* Soft red shadow */
            --accent:         #F43F5E;
            --text-1:         #111827; /* Darkest text */
            --text-2:         #374151; /* Dark gray body text */
            --text-3:         #6B7280; /* Muted gray text */
            --border:         #E5E7EB; /* Light border */
            --border-light:   #F3F4F6;
            
            --sidebar-w:      280px;
            --topbar-h:       76px;
            --radius-lg:      20px;
            --radius-md:      16px;
            --radius-sm:      10px;
            
            --font-display:   'Outfit', sans-serif;
            --font-body:      'Plus Jakarta Sans', sans-serif;

            --shadow-sm:      0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md:      0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            --shadow-lg:      0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.03);
            --shadow-glass:   0 8px 32px 0 rgba(31, 38, 135, 0.07);
            --shadow-red:     0 8px 20px -6px var(--primary-glow);
        }

        body {
            font-family: var(--font-body);
            background-color: var(--bg-base);
            color: var(--text-2);
            margin: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ══════════════════════════════════════
           SCROLLBAR
        ══════════════════════════════════════ */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: var(--bg-base); }
        ::-webkit-scrollbar-thumb { background: #D1D5DB; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #9CA3AF; }

        /* ══════════════════════════════════════
           TYPOGRAPHY & UTILS
        ══════════════════════════════════════ */
        h1, h2, h3, h4, h5, h6, .font-display {
            font-family: var(--font-display);
            color: var(--text-1);
            letter-spacing: -0.01em;
        }
        .text-primary {
            color: var(--primary) !important;
        }

        /* ══════════════════════════════════════
           SIDEBAR (Clean White)
        ══════════════════════════════════════ */
        #sidebar {
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--bg-surface);
            border-right: 1px solid var(--border);
            position: fixed;
            top: 0; left: 0;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: transform .35s cubic-bezier(.4,0,.2,1);
            box-shadow: var(--shadow-sm);
        }

        .sidebar-brand {
            height: var(--topbar-h);
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 12px;
            border-bottom: 1px solid var(--border-light);
        }
        .brand-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: white;
            box-shadow: var(--shadow-red);
        }
        .brand-text {
            font-family: var(--font-display);
            font-size: 22px;
            font-weight: 800;
            color: var(--text-1);
            letter-spacing: -0.5px;
        }
        .brand-text span { color: var(--primary); }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 24px 16px;
            scroll-behavior: smooth;
        }
        
        .nav-section {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--text-3);
            margin: 20px 0 8px 12px;
        }

        .nav-item-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            color: var(--text-2);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            border-radius: var(--radius-sm);
            transition: all .2s ease;
            margin-bottom: 4px;
        }
        .nav-item-link:hover {
            color: var(--primary);
            background: var(--bg-surface-2);
        }
        .nav-item-link.active {
            background: rgba(225, 29, 72, 0.08);
            color: var(--primary);
            font-weight: 700;
            border-left: 3px solid var(--primary);
        }
        .nav-icon {
            width: 24px;
            text-align: center;
            font-size: 16px;
            color: var(--text-3);
            transition: color .2s;
        }
        .nav-item-link:hover .nav-icon { color: var(--primary); }
        .nav-item-link.active .nav-icon { 
            color: var(--primary); 
        }

        .sidebar-user {
            padding: 20px 24px;
            border-top: 1px solid var(--border-light);
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--bg-surface-2);
        }
        .user-avatar {
            width: 40px; height: 40px;
            border-radius: 12px;
            background: rgba(225, 29, 72, 0.1);
            border: 1px solid rgba(225, 29, 72, 0.2);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
            color: var(--primary);
            font-family: var(--font-display);
        }
        .user-info { flex: 1; min-width: 0; }
        .user-name { font-weight: 700; color: var(--text-1); font-size: 14px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-role { font-size: 11px; color: var(--text-3); text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; }
        
        .btn-logout-sidebar {
            background: none; border: none; color: var(--text-3);
            cursor: pointer; padding: 8px; border-radius: 8px;
            transition: all .2s;
        }
        .btn-logout-sidebar:hover { background: rgba(225, 29, 72, 0.1); color: var(--primary); }

        /* ══════════════════════════════════════
           MAIN WRAPPER & TOPBAR
        ══════════════════════════════════════ */
        #main-wrapper {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        #topbar {
            height: var(--topbar-h);
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .page-title {
            font-family: var(--font-display);
            font-size: 20px;
            font-weight: 700;
            color: var(--text-1);
            margin: 0;
        }
        
        .breadcrumb { margin: 0; font-size: 12px; font-weight: 500;}
        .breadcrumb-item a { color: var(--text-3); text-decoration: none; transition: color .2s; }
        .breadcrumb-item a:hover { color: var(--primary); }
        .breadcrumb-item.active { color: var(--text-1); }
        .breadcrumb-item+.breadcrumb-item::before { color: var(--text-3); }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .btn-icon {
            width: 40px; height: 40px;
            border-radius: 12px;
            background: var(--bg-surface);
            border: 1px solid var(--border);
            color: var(--text-2);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: all .2s;
            position: relative;
        }
        .btn-icon:hover {
            border-color: var(--border-light);
            color: var(--primary);
            background: var(--bg-surface-2);
        }
        .notif-badge {
            position: absolute;
            top: -2px; right: -2px;
            width: 10px; height: 10px;
            background: var(--primary);
            border-radius: 50%;
            border: 2px solid var(--bg-surface);
        }

        /* ══════════════════════════════════════
           CONTENT AREA
        ══════════════════════════════════════ */
        #content {
            flex: 1;
            padding: 32px;
        }

        /* ══════════════════════════════════════
           CARDS (Professional Light Mode)
        ══════════════════════════════════════ */
        .card, .bl-card {
            background: var(--bg-surface) !important;
            border: 1px solid var(--border) !important;
            border-radius: var(--radius-lg) !important;
            box-shadow: var(--shadow-sm) !important;
            transition: box-shadow .3s ease, border-color .3s ease !important;
            overflow: hidden;
        }
        .bl-card:hover {
            box-shadow: var(--shadow-md) !important;
        }
        .bl-card-header, .card-header {
            padding: 20px 24px !important;
            border-bottom: 1px solid var(--border-light) !important;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--bg-surface) !important;
            color: var(--text-1) !important;
        }
        .bl-card-title {
            font-family: var(--font-display);
            font-size: 18px;
            font-weight: 700;
            color: var(--text-1);
        }
        .bl-card-sub {
            font-size: 13px;
            color: var(--text-3);
            margin-top: 4px;
            font-weight: 500;
        }
        .bl-card-body, .card-body {
            padding: 24px !important;
            background: var(--bg-surface) !important;
        }
        .card-footer {
            background: var(--bg-surface-2) !important;
            border-top: 1px solid var(--border-light) !important;
        }

        /* ══════════════════════════════════════
           BUTTONS
        ══════════════════════════════════════ */
        .btn-primary {
            background: var(--primary);
            border: none;
            color: white;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 14px;
            box-shadow: var(--shadow-sm);
            transition: all .2s;
        }
        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
            color: white;
        }
        
        .btn-outline {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text-2);
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 14px;
            transition: all .2s;
        }
        .btn-outline:hover {
            background: var(--bg-surface-2);
            border-color: var(--text-3);
            color: var(--text-1);
        }

        /* ══════════════════════════════════════
           TABLES (Global Bootstrap Overrides)
        ══════════════════════════════════════ */
        .table-responsive { border-radius: var(--radius-md); }
        .table, .bl-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            --bs-table-bg: transparent;
            --bs-table-color: var(--text-2);
            --bs-table-border-color: var(--border-light);
            --bs-table-striped-bg: var(--bg-surface-2);
            --bs-table-hover-bg: rgba(0,0,0,0.02);
            margin-bottom: 0;
        }
        .table thead th, .bl-table th {
            font-family: var(--font-body);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-3) !important;
            background: var(--bg-surface-2) !important;
            padding: 14px 16px;
            border-bottom: 1px solid var(--border) !important;
            border-top: none;
            font-weight: 700;
        }
        .table tbody td, .bl-table td {
            padding: 16px;
            font-size: 14px;
            border-bottom: 1px solid var(--border-light) !important;
            color: var(--text-2) !important;
            vertical-align: middle;
            background: var(--bg-surface) !important;
            font-weight: 500;
            transition: background .2s;
        }
        .table tbody tr:hover td, .bl-table tbody tr:hover td {
            background: var(--bg-surface-2) !important;
        }
        .table tbody tr:last-child td, .bl-table tbody tr:last-child td { border-bottom: none !important; }

        /* DataTables UI Overrides */
        .dataTables_wrapper { font-size: 13.5px; color: var(--text-2); padding: 0 16px 16px; }
        .dataTables_wrapper .row:first-child { margin-bottom: 16px; padding-top: 16px; }
        .dataTables_wrapper .dataTables_length select {
            background-color: var(--bg-surface) !important;
            border: 1px solid var(--border) !important;
            color: var(--text-1) !important;
            border-radius: 8px !important;
            padding: 5px 32px 5px 10px !important;
            font-weight: 500;
        }
        .dataTables_wrapper .dataTables_filter input {
            background-color: var(--bg-surface) !important;
            border: 1px solid var(--border) !important;
            color: var(--text-1) !important;
            border-radius: 8px !important;
            padding: 6px 14px !important;
        }
        .dataTables_wrapper .dataTables_info { color: var(--text-3) !important; font-weight: 500; }
        .dataTables_wrapper .dataTables_paginate .paginate_button { 
            color: var(--text-2) !important; 
            border-radius: 8px !important;
            border: 1px solid transparent !important;
            margin: 0 2px !important;
            padding: 5px 12px !important;
            font-weight: 600;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current, 
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: var(--primary) !important;
            color: white !important;
            border: 1px solid var(--primary) !important;
            box-shadow: var(--shadow-sm);
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.current) {
            background: var(--bg-surface-2) !important;
            border: 1px solid var(--border) !important;
            color: var(--text-1) !important;
        }
        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label { color: var(--text-2) !important; font-weight: 600; }

        /* Badges inside tables */
        .badge, .bl-badge {
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 11.5px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            letter-spacing: 0.3px;
        }
        .badge.bg-success, .badge-success { background: #D1FAE5 !important; color: #065F46 !important; }
        .badge.bg-warning, .badge-warning { background: #FEF3C7 !important; color: #92400E !important; }
        .badge.bg-info, .badge-info       { background: #E0F2FE !important; color: #075985 !important; }
        .badge.bg-danger, .badge-danger   { background: #FCE7F3 !important; color: #9D174D !important; }
        .badge.bg-secondary               { background: #F3F4F6 !important; color: #374151 !important; }
        .badge-blood                      { background: #FFE4E6 !important; color: #BE123C !important; border: 1px solid #FECDD3; }

        /* ══════════════════════════════════════
           MODALS
        ══════════════════════════════════════ */
        .modal-content { 
            background: var(--bg-surface) !important; 
            border: none !important; 
            border-radius: var(--radius-lg) !important; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important; 
        }
        .modal-header { 
            background: var(--bg-surface) !important; 
            border-bottom: 1px solid var(--border-light) !important; 
            color: var(--text-1) !important; 
            padding: 20px 24px !important;
            border-radius: var(--radius-lg) var(--radius-lg) 0 0 !important;
        }
        .modal-footer { 
            background: var(--bg-surface-2) !important; 
            border-top: 1px solid var(--border-light) !important; 
            padding: 16px 24px !important;
            border-radius: 0 0 var(--radius-lg) var(--radius-lg) !important;
        }
        .modal-body { 
            background: var(--bg-base) !important; 
            color: var(--text-2) !important; 
            padding: 24px !important;
        }

        /* ══════════════════════════════════════
           FORMS (Clean Professional style)
        ══════════════════════════════════════ */
        .form-label, .bl-label {
            display: flex; align-items: center; gap: 6px;
            font-size: 13px;
            color: var(--text-2);
            font-weight: 600;
            margin-bottom: 8px;
        }
        .bl-icon { color: var(--text-3); font-size: 14px; }
        .form-control, .form-select, .bl-input {
            background: var(--bg-surface) !important;
            border: 1px solid var(--border) !important;
            color: var(--text-1) !important;
            border-radius: 10px !important;
            padding: 10px 14px !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            transition: all .2s !important;
            box-shadow: var(--shadow-sm) !important;
        }
        .form-control:focus, .form-select:focus, .bl-input:focus {
            background: var(--bg-surface) !important;
            border-color: var(--primary) !important;
            color: var(--text-1) !important;
            box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.1) !important;
            outline: none !important;
        }
        .form-control::placeholder, .bl-input::placeholder { color: var(--text-3) !important; }

        .bl-toggle-wrap { position: relative; display: inline-block; }
        .bl-toggle-input { opacity: 0; width: 0; height: 0; position: absolute; }
        .bl-toggle-label { display: block; width: 44px; height: 24px; background: #D1D5DB; border-radius: 30px; cursor: pointer; position: relative; transition: background .2s; }
        .bl-toggle-label::after { content: ''; position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background: white; border-radius: 50%; transition: transform .2s; box-shadow: var(--shadow-sm); }
        .bl-toggle-input:checked + .bl-toggle-label { background: var(--primary); }
        .bl-toggle-input:checked + .bl-toggle-label::after { transform: translateX(20px); }
        .bl-status-text { font-size: 13px; font-weight: 600; color: var(--text-2); }

        /* Legacy inline overrides mapped to Light Mode */
        [style*="color:#111827"], [style*="color: #111827"], [style*="color:#374151"] { color: var(--text-1) !important; }
        [style*="background:#FAFAFA"], [style*="background: #FAFAFA"] { background: var(--bg-base) !important; }
        [style*="background:#FFF0F3"], [style*="background: #FFF0F3"] { background: #FFE4E6 !important; border-color: #FECDD3 !important; color: #BE123C !important; }
        .bg-white { background-color: var(--bg-surface) !important; }
        .text-dark { color: var(--text-1) !important; }
        .btn-close { filter: none; opacity: 0.5; }

        /* ══════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════ */
        @media (max-width: 991px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.open { transform: translateX(0); }
            #main-wrapper { margin-left: 0; }
        }
        /* ══════════════════════════════════════
           SCROLL REVEAL (INTERSECTION OBSERVER)
        ══════════════════════════════════════ */
        .bl-reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.5, 0, 0, 1);
        }
        .bl-reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        /* Penundaan (Delay) Bertingkat */
        .bl-reveal.delay-100 { transition-delay: 100ms; }
        .bl-reveal.delay-200 { transition-delay: 200ms; }
        .bl-reveal.delay-300 { transition-delay: 300ms; }
        .bl-reveal.delay-400 { transition-delay: 400ms; }
    </style>
</head>
<body>

<div id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">
            <i class="fas fa-tint"></i>
        </div>
        <div class="brand-text"><span>blood</span>link</div>
    </div>
    
    <nav class="sidebar-nav">
        @php $role = auth()->user()->role ?? ""; @endphp
        
        @if($role === "admin")
            <div class="nav-section">Main</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-item-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-border-all nav-icon"></i> Dashboard
            </a>
            
            <div class="nav-section">Management</div>
            <a href="{{ route('admin.pendonor.index') }}" class="nav-item-link {{ request()->routeIs('admin.pendonor.*') ? 'active' : '' }}">
                <i class="fas fa-users nav-icon"></i> Pendonor
            </a>
            <a href="{{ route('admin.rumah-sakit.index') }}" class="nav-item-link {{ request()->routeIs('admin.rumah-sakit.*') ? 'active' : '' }}">
                <i class="fas fa-hospital nav-icon"></i> Rumah Sakit
            </a>
            <a href="{{ route('admin.stok-darah.index') }}" class="nav-item-link {{ request()->routeIs('admin.stok-darah.*') ? 'active' : '' }}">
                <i class="fas fa-cubes nav-icon"></i> Stok Darah
            </a>
            <a href="{{ route('admin.jadwal-donor.index') }}" class="nav-item-link {{ request()->routeIs('admin.jadwal-donor.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt nav-icon"></i> Jadwal Donor
            </a>
            <a href="{{ route('admin.donor.index') }}" class="nav-item-link {{ request()->routeIs('admin.donor.*') ? 'active' : '' }}">
                <i class="fas fa-hand-holding-water nav-icon"></i> Data Donor
            </a>
            <a href="{{ route('admin.permintaan-darah.index') }}" class="nav-item-link {{ request()->routeIs('admin.permintaan-darah.*') ? 'active' : '' }}">
                <i class="fas fa-file-medical-alt nav-icon"></i> Permintaan
            </a>
            
            <div class="nav-section">Reports</div>
            <a href="{{ route('admin.laporan.donor') }}" class="nav-item-link {{ request()->routeIs('admin.laporan.donor*') ? 'active' : '' }}">
                <i class="fas fa-chart-line nav-icon"></i> Laporan Donor
            </a>
            <a href="{{ route('admin.laporan.stok') }}" class="nav-item-link {{ request()->routeIs('admin.laporan.stok') ? 'active' : '' }}">
                <i class="fas fa-chart-pie nav-icon"></i> Laporan Stok
            </a>
            
            <div class="nav-section">Settings</div>
            <a href="{{ route('admin.user.index') }}" class="nav-item-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                <i class="fas fa-user-shield nav-icon"></i> Manajemen User
            </a>
        @endif

        @if($role === "petugas_pmi")
            <!-- Petugas Links -->
            <div class="nav-section">Main</div>
            <a href="{{ route('petugas.dashboard') }}" class="nav-item-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                <i class="fas fa-border-all nav-icon"></i> Dashboard
            </a>
            <div class="nav-section">Kelola</div>
            <a href="{{ route('petugas.pendonor.index') }}" class="nav-item-link {{ request()->routeIs('petugas.pendonor.*') ? 'active' : '' }}">
                <i class="fas fa-users nav-icon"></i> Pendonor
            </a>
            <a href="{{ route('petugas.donor.index') }}" class="nav-item-link {{ request()->routeIs('petugas.donor.*') ? 'active' : '' }}">
                <i class="fas fa-hand-holding-water nav-icon"></i> Manajemen Donor
            </a>
            <a href="{{ route('petugas.stok-darah.index') }}" class="nav-item-link {{ request()->routeIs('petugas.stok-darah.*') ? 'active' : '' }}">
                <i class="fas fa-cubes nav-icon"></i> Stok Darah
            </a>
            <a href="{{ route('petugas.jadwal-donor.index') }}" class="nav-item-link {{ request()->routeIs('petugas.jadwal-donor.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt nav-icon"></i> Jadwal Donor
            </a>
            <a href="{{ route('petugas.permintaan-darah.index') }}" class="nav-item-link {{ request()->routeIs('petugas.permintaan-darah.*') ? 'active' : '' }}">
                <i class="fas fa-file-medical-alt nav-icon"></i> Permintaan
            </a>
        @endif

        @if($role === "pendonor")
            <div class="nav-section">Menu Saya</div>
            <a href="{{ route('pendonor.dashboard') }}" class="nav-item-link {{ request()->routeIs('pendonor.dashboard') ? 'active' : '' }}">
                <i class="fas fa-border-all nav-icon"></i> Dashboard
            </a>
            <a href="{{ route('pendonor.daftar') }}" class="nav-item-link {{ request()->routeIs('pendonor.daftar*') ? 'active' : '' }}">
                <i class="fas fa-calendar-plus nav-icon"></i> Daftar Donor
            </a>
            <a href="{{ route('pendonor.riwayat') }}" class="nav-item-link {{ request()->routeIs('pendonor.riwayat') ? 'active' : '' }}">
                <i class="fas fa-history nav-icon"></i> Riwayat Donor
            </a>
            <a href="{{ route('pendonor.profil') }}" class="nav-item-link {{ request()->routeIs('pendonor.profil') ? 'active' : '' }}">
                <i class="fas fa-user-circle nav-icon"></i> Profil Saya
            </a>
        @endif
        
        @if($role === "rumah_sakit")
            <div class="nav-section">Menu</div>
            <a href="{{ route('rs.dashboard') }}" class="nav-item-link {{ request()->routeIs('rs.dashboard') ? 'active' : '' }}">
                <i class="fas fa-border-all nav-icon"></i> Dashboard
            </a>
            <a href="{{ route('rs.stok') }}" class="nav-item-link {{ request()->routeIs('rs.stok') ? 'active' : '' }}">
                <i class="fas fa-cubes nav-icon"></i> Stok Darah
            </a>
            <a href="{{ route('rs.permintaan-darah.index') }}" class="nav-item-link {{ request()->routeIs('rs.permintaan-darah.*') ? 'active' : '' }}">
                <i class="fas fa-file-medical-alt nav-icon"></i> Permintaan Darah
            </a>
        @endif
        
        @if($role === "pimpinan_pmi")
            <div class="nav-section">Utama</div>
            <a href="{{ route('pimpinan.dashboard') }}" class="nav-item-link {{ request()->routeIs('pimpinan.dashboard') ? 'active' : '' }}">
                <i class="fas fa-border-all nav-icon"></i> Dashboard
            </a>
            <div class="nav-section">Laporan & Monitoring</div>
            <a href="{{ route('pimpinan.laporan.donor') }}" class="nav-item-link {{ request()->routeIs('pimpinan.laporan.donor') ? 'active' : '' }}">
                <i class="fas fa-chart-line nav-icon"></i> Laporan Donor
            </a>
            <a href="{{ route('pimpinan.laporan.stok') }}" class="nav-item-link {{ request()->routeIs('pimpinan.laporan.stok') ? 'active' : '' }}">
                <i class="fas fa-chart-pie nav-icon"></i> Laporan Stok
            </a>
            <a href="{{ route('pimpinan.monitoring') }}" class="nav-item-link {{ request()->routeIs('pimpinan.monitoring') ? 'active' : '' }}">
                <i class="fas fa-desktop nav-icon"></i> Monitoring
            </a>
        @endif
    </nav>

    <div class="sidebar-user">
        <div class="user-avatar" style="overflow: hidden; padding: 0;">
            @if(auth()->user()->foto_profil)
                <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                {{ strtoupper(substr(auth()->user()->nama ?? 'U', 0, 1)) }}
            @endif
        </div>
        <div class="user-info">
            <div class="user-name">{{ auth()->user()->nama ?? 'User' }}</div>
            <div class="user-role">{{ str_replace('_',' ', auth()->user()->role ?? '') }}</div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" class="btn-logout-sidebar" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </form>
    </div>
</div>

<div id="main-wrapper">
    <div id="topbar">
        <div class="topbar-left">
            <button class="btn-icon d-lg-none" id="sidebarToggle" style="border:none;">
                <i class="fas fa-bars"></i>
            </button>
            <div>
                <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        @yield('breadcrumb')
                    </ol>
                </nav>
            </div>
        </div>

        <div class="topbar-right">
            <!-- Notification -->
            <div class="dropdown">
                <button class="btn-icon" data-bs-toggle="dropdown">
                    <i class="fas fa-bell"></i>
                    @php
                        $notifCount = auth()->check() ? \App\Models\Notifikasi::where('user_id', auth()->id())->where('is_read', false)->count() : 0;
                    @endphp
                    @if($notifCount > 0)
                        <span class="notif-badge"></span>
                    @endif
                </button>
                <div class="dropdown-menu dropdown-menu-end p-0" style="width: 320px; background: var(--bg-surface); border: 1px solid var(--border); box-shadow: var(--shadow-lg); border-radius: 16px; overflow: hidden; margin-top: 10px;">
                    <div style="padding: 16px 20px; border-bottom: 1px solid var(--border-light); display: flex; justify-content: space-between; align-items: center; background: var(--bg-surface-2);">
                        <span style="font-weight: 700; color: var(--text-1);">Notifications</span>
                        @if($notifCount > 0)
                            <span class="badge bg-danger rounded-pill">{{ $notifCount }} New</span>
                        @endif
                    </div>
                    <div style="max-height: 300px; overflow-y: auto;">
                        @php
                            $notifs = auth()->check() ? \App\Models\Notifikasi::where('user_id', auth()->id())->latest()->take(5)->get() : collect();
                        @endphp
                        @forelse($notifs as $n)
                            <a href="#" style="display: block; padding: 16px 20px; border-bottom: 1px solid var(--border-light); text-decoration: none; transition: background .2s;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='transparent'">
                                <div style="font-size: 13px; font-weight: 600; color: {{ $n->is_read ? 'var(--text-2)' : 'var(--text-1)' }}; margin-bottom: 4px;">{{ $n->judul }}</div>
                                <div style="font-size: 12px; color: var(--text-3);">{{ $n->pesan }}</div>
                            </a>
                        @empty
                            <div style="padding: 32px 20px; text-align: center; color: var(--text-3); font-size: 13px;">
                                <i class="fas fa-bell-slash mb-2" style="font-size: 24px; opacity: 0.5;"></i><br>
                                No new notifications
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Profile Dropdown -->
            <div class="dropdown">
                <button class="btn-icon" data-bs-toggle="dropdown" style="padding:0; border:none; background:transparent;">
                    <div style="width: 40px; height: 40px; border-radius: 12px; background: rgba(225, 29, 72, 0.1); border: 1px solid rgba(225, 29, 72, 0.2); display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--primary); font-family: var(--font-display); font-size: 16px; transition: all 0.2s; overflow: hidden;" onmouseover="this.style.background='rgba(225, 29, 72, 0.2)'" onmouseout="this.style.background='rgba(225, 29, 72, 0.1)'">
                        @if(auth()->user()->foto_profil)
                            <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            {{ strtoupper(substr(auth()->user()->nama ?? 'U', 0, 2)) }}
                        @endif
                    </div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="background: var(--bg-surface); border: 1px solid var(--border); box-shadow: var(--shadow-lg); border-radius: 12px; padding: 8px; margin-top: 10px;">
                    <li><a class="dropdown-item" href="#" style="color: var(--text-2); border-radius: 8px; font-weight: 500;"><i class="fas fa-user-circle me-2"></i> Profile</a></li>
                    <li><hr class="dropdown-divider" style="border-color: var(--border-light);"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item" style="color: var(--primary); font-weight: 600; border-radius: 8px;">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success') || session('error') || session('warning') || $errors->any())
    <div style="padding: 24px 32px 0 32px;">
        @if(session('success'))
            <div class="alert alert-dismissible fade show" style="background: #D1FAE5; border: 1px solid #34D399; color: #065F46; border-radius: 12px; padding: 14px 16px; display: flex; align-items: center; gap: 12px; font-weight: 500; font-size: 14px;">
                <i class="fas fa-check-circle fs-5"></i>
                <div class="flex-grow-1">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-dismissible fade show" style="background: #FEE2E2; border: 1px solid #F87171; color: #991B1B; border-radius: 12px; padding: 14px 16px; display: flex; align-items: center; gap: 12px; font-weight: 500; font-size: 14px;">
                <i class="fas fa-exclamation-circle fs-5"></i>
                <div class="flex-grow-1">{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('warning'))
            <div class="alert alert-dismissible fade show" style="background: #FEF3C7; border: 1px solid #FBBF24; color: #92400E; border-radius: 12px; padding: 14px 16px; display: flex; align-items: center; gap: 12px; font-weight: 500; font-size: 14px;">
                <i class="fas fa-exclamation-triangle fs-5"></i>
                <div class="flex-grow-1">{{ session('warning') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-dismissible fade show" style="background: #FEE2E2; border: 1px solid #F87171; color: #991B1B; border-radius: 12px; padding: 14px 16px; display: flex; align-items: flex-start; gap: 12px; font-weight: 500; font-size: 14px;">
                <i class="fas fa-exclamation-circle fs-5 mt-1"></i>
                <div class="flex-grow-1">
                    <strong>Terdapat kesalahan:</strong>
                    <ul class="mb-0 mt-1 ps-3">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>
    @endif

    <div id="content">
        @yield('content')
    </div>
</div>

<div id="sidebarOverlay" onclick="closeSidebar()" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);z-index:1039;backdrop-filter:blur(2px)"></div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    // Sidebar Mobile
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebarOverlay').style.display = 'none';
    }
    const toggler = document.getElementById('sidebarToggle');
    if (toggler) {
        toggler.addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').style.display = 
                document.getElementById('sidebar').classList.contains('open') ? 'block' : 'none';
        });
    }

    // Sidebar Scroll Position Restore
    (function() {
        const sidebarNav = document.querySelector('.sidebar-nav');
        if (!sidebarNav) return;

        // Restore scroll position immediately (before paint)
        const savedScroll = sessionStorage.getItem('sidebarScrollTop');
        if (savedScroll !== null) {
            sidebarNav.scrollTop = parseInt(savedScroll, 10);
        }

        // Save scroll position on every scroll
        sidebarNav.addEventListener('scroll', function() {
            sessionStorage.setItem('sidebarScrollTop', sidebarNav.scrollTop);
        });

        // Also save before navigating away
        document.querySelectorAll('.nav-item-link').forEach(function(link) {
            link.addEventListener('click', function() {
                sessionStorage.setItem('sidebarScrollTop', sidebarNav.scrollTop);
            });
        });

        // Scroll active item into view smoothly if not already visible
        const activeLink = sidebarNav.querySelector('.nav-item-link.active');
        if (activeLink && savedScroll === null) {
            activeLink.scrollIntoView({ block: 'center', behavior: 'smooth' });
        }
    })();

    // Chart JS Defaults for Light Theme
    if (window.Chart) {
        Chart.defaults.color = '#6B7280';
        Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
        Chart.defaults.scale.grid.color = '#E5E7EB';
        Chart.defaults.plugins.tooltip.backgroundColor = '#111827';
        Chart.defaults.plugins.tooltip.titleColor = '#F9FAFB';
        Chart.defaults.plugins.tooltip.bodyColor = '#D1D5DB';
        Chart.defaults.plugins.tooltip.padding = 12;
        Chart.defaults.plugins.tooltip.cornerRadius = 8;
    }

    // Dropdown hover effect
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('mouseenter', e => {
            if(!item.style.color.includes('primary')) {
                item.style.background = 'var(--bg-surface-2)';
                item.style.color = 'var(--text-1)';
            } else {
                item.style.background = 'rgba(225, 29, 72, 0.05)';
            }
        });
        item.addEventListener('mouseleave', e => {
            item.style.background = 'transparent';
            if(!item.style.color.includes('primary')) {
                item.style.color = 'var(--text-2)';
            }
        });
    });
    // Scroll Reveal Intersection Observer
    document.addEventListener("DOMContentLoaded", function() {
        const revealElements = document.querySelectorAll(".bl-reveal");
        
        if (revealElements.length > 0) {
            const revealObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("active");
                        // Opsional: unobserve setelah muncul jika hanya ingin 1x animasi
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                root: null,
                threshold: 0.1, // Trigger saat 10% elemen masuk layar
                rootMargin: "0px 0px -50px 0px" 
            });

            revealElements.forEach(el => revealObserver.observe(el));
        }
    });
</script>
@stack('scripts')
</body>
</html>
