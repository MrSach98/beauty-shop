<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Beauty Shop</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --pink: #E91E8C;
            --dark-pink: #C2185B;
            --sidebar-bg: #1a1a2e;
            --sidebar-text: #a0a0b0;
            --sidebar-active: #E91E8C;
        }
        body { background: #f4f6f9; }

        /* Sidebar */
        #sidebar {
            width: 260px; 
            height: 100vh;
            background: var(--sidebar-bg);
            position: fixed; top: 0; left: 0; z-index: 999;
            transition: all 0.3s;
            overflow-y: auto;
            scrollbar-width: thin;
        }
        .sidebar-brand {
            padding: 20px;
            border-bottom: 1px solid #2a2a4a;
            color: white;
            font-size: 1.2rem;
            font-weight: 700;
        }
        .sidebar-brand span { color: var(--pink); }
        .nav-link {
            color: var(--sidebar-text) !important;
            padding: 10px 20px;
            border-radius: 8px;
            margin: 2px 10px;
            font-size: 0.9rem;
        }
        .nav-link:hover, .nav-link.active {
            background: var(--pink) !important;
            color: white !important;
        }
        .nav-link i { margin-right: 8px; font-size: 1rem; }
        .nav-section {
            font-size: 0.7rem; color: #555577;
            padding: 12px 20px 4px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Main Content */
        #main-content {
            margin-left: 260px;
            min-height: 100vh;
        }
        .topbar {
            background: white;
            padding: 12px 24px;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .page-wrapper { padding: 24px; }
    </style>

    @stack('styles')
</head>
<body>

<!-- Sidebar -->
<div id="sidebar">
    <div class="sidebar-brand">
        💄 Beauty <span>Admin</span>
    </div>

    <nav class="mt-2">
        <div class="nav-section">Main</div>
        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="nav-section">Catalog</div>
        <a href="{{ route('admin.products.index') }}" class="nav-link"><i class="bi bi-box-seam"></i> Products</a>
        <a href="{{ route('admin.categories.index') }}" class="nav-link"><i class="bi bi-grid"></i> Categories</a>
        <a href="{{ route('admin.brands.index') }}"
            class="nav-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
                <i class="bi bi-award"></i> Brands
        </a>

        <div class="nav-section">Sales</div>
        <a href="#" class="nav-link"><i class="bi bi-cart3"></i> Orders</a>
        <a href="#" class="nav-link"><i class="bi bi-people"></i> Customers</a>
        <a href="{{ route('admin.shipping.index') }}"
            class="nav-link {{ request()->routeIs('admin.shipping.*') ? 'active' : '' }}">
                <i class="bi bi-truck"></i> Shipping
        </a>
        <a href="{{ route('admin.shipping.index') }}"
            class="nav-link {{ request()->routeIs('admin.shipping.*') ? 'active' : '' }}">
                <i class="bi bi-truck"></i> Shipping
        </a>

        <div class="nav-section">Content</div>
        <a href="{{ route('admin.banners.index') }}"
        class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
            <i class="bi bi-image"></i> Banners
        </a>
        <a href="#" class="nav-link"><i class="bi bi-star"></i> Reviews</a>

        <div class="nav-section">System</div>
        <a href="#" class="nav-link"><i class="bi bi-bar-chart"></i> Reports</a>
        <a href="{{ route('admin.settings.index') }}"
            class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="bi bi-gear"></i> Settings
        </a>

        <div class="mt-4 px-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-danger w-100 btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </nav>
</div>

<!-- Main -->
<div id="main-content">
    <!-- Topbar -->
    <div class="topbar">
        <h6 class="mb-0 fw-bold">@yield('page-title', 'Dashboard')</h6>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted small">{{ now()->format('d M Y') }}</span>
            <span class="fw-semibold">👋 {{ auth()->user()->name }}</span>
        </div>
    </div>

    <!-- Page Content -->
    <div class="page-wrapper">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>