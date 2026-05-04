<!DOCTYPE html>
<html>
<head>
    <title>Panel Pengguna - VIGATE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="description" content="Dashboard VIGATE untuk user dengan tampilan mobile-friendly.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon_io/favicon-16x16.png">
    <link rel="manifest" href="/favicon_io/site.webmanifest">
    <meta name="theme-color" content="#0d6efd">
    <meta name="msapplication-TileColor" content="#0d6efd">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            scroll-behavior: smooth;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: white;
            padding: 20px 0;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }

        .sidebar-header h4 {
            font-weight: 700;
            letter-spacing: 1px;
            margin: 0;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
        }

        .sidebar-menu li {
            margin: 0;
        }

        .sidebar-menu a {
            color: rgba(255,255,255,0.85);
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 20px;
            text-decoration: none;
            transition: all 0.25s ease;
            border-left: 3px solid transparent;
            border-radius: 0 24px 24px 0;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255,255,255,0.12);
            color: white;
            border-left: 3px solid #60a5fa;
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.08);
        }

        .sidebar-menu i {
            margin-right: 12px;
            font-size: 18px;
            width: 20px;
        }

        .sidebar-toggle,
        .sidebar-close {
            display: none;
            background: transparent;
            border: none;
            color: #1e293b;
            font-size: 24px;
            cursor: pointer;
        }

        .sidebar-close {
            color: white;
            position: absolute;
            top: 18px;
            right: 18px;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15,23,42,0.5);
            z-index: 900;
            opacity: 0;
            transition: opacity 0.25s ease;
        }

        .mobile-nav {
            display: none;
            position: fixed;
            inset: auto 0 0 0;
            z-index: 1100;
            background: rgba(255,255,255,0.98);
            border-top: 1px solid #e2e8f0;
            padding: 8px 10px;
            box-shadow: 0 -8px 18px rgba(15,23,42,0.08);
            backdrop-filter: blur(10px);
        }

        .mobile-nav-link {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            width: 24%;
            padding: 10px 0;
            color: #64748b;
            text-decoration: none;
            font-size: 11px;
            transition: color 0.25s ease, transform 0.25s ease;
        }

        .mobile-nav-link i {
            font-size: 18px;
        }

        .mobile-nav-link.active,
        .mobile-nav-link:hover {
            color: #0d6efd;
            transform: translateY(-1px);
        }

        .sidebar.open + .sidebar-overlay,
        .sidebar.open ~ .sidebar-overlay {
            display: block;
            opacity: 1;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .section-title {
            font-size: 1.05rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #0f172a;
        }

        .dashboard-summary {
            margin-bottom: 20px;
        }

        .dashboard-summary .card-box {
            min-height: 140px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 24px;
        }

        .dashboard-summary .card-box h4,
        .dashboard-summary .card-box h5,
        .dashboard-summary .card-box h6 {
            margin-bottom: 0.75rem;
        }

        .dashboard-card {
            border-radius: 16px;
        }

        .action-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .table-responsive table {
            width: 100%;
            min-width: 100%;
        }

        .table th,
        .table td {
            word-break: normal;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* CONTENT */
        .content {
            margin-left: 260px;
            padding-top: 150px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin 0.3s ease;
        }

        /* TOPBAR */
        .topbar {
            position: fixed;
            top: 0;
            left: 260px;
            right: 0;
            width: calc(100% - 260px);
            min-height: 74px;
            z-index: 1020;
            backdrop-filter: blur(10px);
            background: rgba(255,255,255,0.96);
            padding: 15px 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .topbar-left h5 {
            margin: 0;
            color: #1e293b;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .topbar-logo img {
            width: 32px;
            height: 32px;
            object-fit: cover;
            border-radius: 8px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .profile-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding-right: 20px;
            border-right: 1px solid #e2e8f0;
        }

        .profile-info .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #60a5fa, #3b82f6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
        }

        .avatar-toggle {
            border: none;
            background: transparent;
            padding: 0;
            cursor: pointer;
        }

        .profile-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            min-width: 210px;
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 14px;
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.12);
            padding: 12px;
            z-index: 1050;
        }

        .profile-dropdown.active {
            display: block;
        }

        .profile-dropdown-header {
            display: flex;
            flex-direction: column;
            gap: 4px;
            margin-bottom: 10px;
        }

        .profile-dropdown .user-name,
        .profile-dropdown .user-role {
            margin: 0;
        }

        .profile-info .user-details {
            display: flex;
            flex-direction: column;
        }

        .profile-info .user-name {
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }

        .profile-info .user-role {
            font-size: 12px;
            color: #64748b;
            margin: 0;
        }

        .logout-btn {
            background: #ef4444;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
        }

        .logout-btn:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }

        /* BREADCRUMB */
        .breadcrumb-area {
            position: fixed;
            top: 74px;
            left: 260px;
            width: calc(100% - 260px);
            background: white;
            padding: 15px 30px;
            border-bottom: 1px solid #e2e8f0;
            z-index: 1015;
        }

        .breadcrumb {
            margin: 0;
            background: transparent;
            padding: 0;
        }

        .breadcrumb-item {
            font-size: 14px;
        }

        .breadcrumb-item.active {
            color: #64748b;
            font-weight: 600;
        }

        .breadcrumb-item a {
            color: #3b82f6;
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            text-decoration: underline;
        }

        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            padding: 20px 30px;
            min-height: calc(100vh - 140px);
        }

        .card-box {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .card-box:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #f8fafc;
            border-top: none;
            font-weight: 600;
            color: #1e293b;
            padding: 15px;
            border-bottom: 2px solid #e2e8f0;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #e2e8f0;
        }

        .badge {
            font-size: 12px;
            padding: 6px 12px;
        }

        /* SCROLLBAR */
        .sidebar::-webkit-scrollbar {
            width: 8px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 4px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.3);
        }

        @media (max-width: 991px) {
            .sidebar {
                display: none;
            }

            .sidebar-toggle {
                display: none;
            }

            .topbar {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                z-index: 1020;
                padding: 12px 16px;
                flex-wrap: nowrap;
                gap: 12px;
                justify-content: space-between;
                align-items: center;
                border-bottom: 1px solid #e2e8f0;
                min-height: 56px;
            }

            .topbar-left {
                flex: 1 1 auto;
                min-width: 0;
            }

            .topbar-left h5 {
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                margin: 0;
            }

            .topbar-right {
                display: flex;
                align-items: center;
                justify-content: flex-end;
                gap: 10px;
                flex: 0 0 auto;
            }

            .profile-info {
                padding-right: 0;
                border-right: none;
                min-width: 0;
                position: relative;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .profile-info .user-details,
            .desktop-logout-form {
                display: none;
            }

            .profile-dropdown {
                right: 0;
            }

            .profile-dropdown .logout-btn {
                width: 100%;
                justify-content: center;
            }

            .breadcrumb-area,
            .main-content,
            .card-box,
            .topbar,
            .sidebar-header {
                padding-left: 16px;
                padding-right: 16px;
            }

            .breadcrumb-area {
                padding-top: 12px;
                padding-bottom: 12px;
            }

            .main-content {
                padding: 16px;
            }

            .content {
                margin-left: 0;
                padding-top: 140px;
                padding-bottom: 98px;
            }

            .topbar,
            .breadcrumb-area {
                left: 0;
                width: 100%;
            }

            .breadcrumb-area {
                top: 64px;
            }

            .mobile-nav {
                display: flex;
                justify-content: space-between;
            }
        }

        @media (max-width: 575px) {
            .topbar {
                padding: 12px 14px;
            }

            .mobile-nav {
                padding: 10px 8px;
            }

            .topbar-right {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            .profile-info {
                justify-content: space-between;
                width: 100%;
            }

            .logout-btn {
                width: 100%;
                justify-content: center;
            }

            .breadcrumb {
                flex-wrap: wrap;
                gap: 8px;
            }

            .breadcrumb-item {
                font-size: 13px;
            }

            .card-box {
                padding: 18px;
            }

            .table-responsive table {
                min-width: auto;
            }

            .table th,
            .table td {
                white-space: normal;
            }

            .topbar-left h5 {
                font-size: 1rem;
            }

            .profile-info .user-name {
                font-size: 0.98rem;
            }

            .profile-info .user-role {
                font-size: 0.85rem;
            }
        }

    </style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="/favicon_io/android-chrome-192x192.png" alt="VIGATE" style="width:48px; height:48px; display:block; margin:0 auto 12px; border-radius:50%; box-shadow:0 10px 20px rgba(0,0,0,0.12);">
            <h4><i class=""></i> VIGATE</h4>
            <button class="sidebar-close" id="closeSidebar" aria-label="Tutup menu">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

    <ul class="sidebar-menu">
        <li>
            <a href="/user/dashboard" class="{{ request()->is('user/dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-door"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="/user/profile" class="{{ request()->is('user/profile') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i>
                <span>Profile</span>
            </a>
        </li>
        <li>
            <a href="/user/vehicles" class="{{ request()->is('user/vehicles*') ? 'active' : '' }}">
                <i class="bi bi-car-front-fill"></i>
                <span>Management Vehicles</span>
            </a>
        </li>
        <li>
            <a href="/user/history" class="{{ request()->is('user/history') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span>Access History</span>
            </a>
        </li>

    </ul>
</div>

<!-- CONTENT -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>
<div class="content">

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="topbar-left">
            <div class="topbar-logo">
                <img src="/favicon_io/android-chrome-192x192.png" alt="VIGATE logo">
            </div>
            <h5>User Dashboard</h5>
        </div>

        <div class="topbar-right">
            <div class="profile-info">
                <button type="button" class="user-avatar avatar-toggle" aria-expanded="false" aria-label="Buka menu akun">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </button>
                <div class="user-details">
                    <p class="user-name">{{ auth()->user()->name ?? 'User' }}</p>
                    <p class="user-role">User</p>
                </div>
                <div class="profile-dropdown" aria-hidden="true">
                    <div class="profile-dropdown-header">
                        <p class="user-name">{{ auth()->user()->name ?? 'User' }}</p>
                        <p class="user-role">User</p>
                    </div>
                    <form action="{{ route('user.logout') }}" method="POST" class="mobile-logout-form">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="bi bi-box-arrow-right"></i>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
            <form action="{{ route('user.logout') }}" method="POST" class="desktop-logout-form">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="bi bi-box-arrow-right"></i>
                    Keluar
                </button>
            </form>
        </div>
    </div>

    <!-- BREADCRUMB -->
    <div class="breadcrumb-area">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/user/dashboard"><i class="bi bi-house-door"></i> Beranda</a>
                </li>
                @if(request()->is('user/dashboard'))
                    <li class="breadcrumb-item active"><i class="bi bi-speedometer2"></i> Dashboard</li>
                @elseif(request()->is('user/vehicles*'))
                    <li class="breadcrumb-item active"><i class="bi bi-car-front-fill"></i> Manajemen Kendaraan</li>
                @elseif(request()->is('user/history'))
                    <li class="breadcrumb-item active"><i class="bi bi-clock-history"></i> Riwayat Akses</li>
                @elseif(request()->is('user/profile'))
                    <li class="breadcrumb-item active"><i class="bi bi-person-circle"></i> Profil</li>
                @endif
            </ol>
        </nav>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        @yield('content')
    </div>

    <div class="mobile-nav" aria-label="Navigasi bawah">
        <a href="/user/dashboard" class="mobile-nav-link {{ request()->is('user/dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i>
            <span>Beranda</span>
        </a>
        <a href="/user/vehicles" class="mobile-nav-link {{ request()->is('user/vehicles*') ? 'active' : '' }}">
            <i class="bi bi-car-front-fill"></i>
            <span>Kendaraan</span>
        </a>
        <a href="/user/history" class="mobile-nav-link {{ request()->is('user/history') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i>
            <span>Riwayat</span>
        </a>
        <a href="/user/profile" class="mobile-nav-link {{ request()->is('user/profile') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i>
            <span>Profil</span>
        </a>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebar = document.getElementById('sidebar');
    const openSidebar = document.getElementById('openSidebar');
    const closeSidebar = document.getElementById('closeSidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    function toggleSidebar(open) {
        if (!sidebar) return;
        if (open) {
            sidebar.classList.add('open');
            sidebarOverlay.style.display = 'block';
        } else {
            sidebar.classList.remove('open');
            sidebarOverlay.style.display = 'none';
        }
    }

    openSidebar?.addEventListener('click', () => toggleSidebar(true));
    closeSidebar?.addEventListener('click', () => toggleSidebar(false));
    sidebarOverlay?.addEventListener('click', () => toggleSidebar(false));

    const avatarToggle = document.querySelector('.avatar-toggle');
    const profileDropdown = document.querySelector('.profile-dropdown');
    if (avatarToggle && profileDropdown) {
        avatarToggle.addEventListener('click', function(event) {
            event.stopPropagation();
            const isOpen = profileDropdown.classList.toggle('active');
            avatarToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            profileDropdown.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
        });

        document.addEventListener('click', function(event) {
            if (!profileDropdown.contains(event.target) && !avatarToggle.contains(event.target)) {
                profileDropdown.classList.remove('active');
                avatarToggle.setAttribute('aria-expanded', 'false');
                profileDropdown.setAttribute('aria-hidden', 'true');
            }
        });
    }
</script>
</body>
</html>