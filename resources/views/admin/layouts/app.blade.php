<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — CouponHub Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    {{-- Select2 (searchable dropdowns) --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            /* Repoint Bootstrap's own variable so bg-opacity-10 /
               text-opacity / border-opacity utilities keep working. */
            --bs-primary: #6366f1;
            --bs-primary-rgb: 99, 102, 241;
        }
        body { font-family: 'Manrope', sans-serif; background: #f4f6fb; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Space Grotesk', sans-serif; }

        /* Sidebar */
        .admin-sidebar {
            width: 240px; min-height: 100vh; background: linear-gradient(135deg, #131e37 0%, #1a1747 100%);
            position: fixed; top: 0; left: 0; z-index: 1000;
            display: flex; flex-direction: column;
            transition: transform .3s ease;
        }
        .admin-sidebar .sidebar-brand {
            padding: 1.25rem 1.5rem; background: rgba(0,0,0,.15);
            color: #fff; font-weight: 700; font-size: 1.1rem;
            text-decoration: none; display: flex; align-items: center; gap: .5rem;
        }
        .admin-sidebar .sidebar-brand:hover { color: #93c5fd; }
        .nav-section-label {
            font-size: .65rem; font-weight: 700; letter-spacing: 1px;
            color: #64748b; text-transform: uppercase;
            padding: .75rem 1.5rem .25rem;
        }
        .sidebar-nav .nav-link {
            color: #94a3b8; padding: .6rem 1.5rem;
            display: flex; align-items: center; gap: .6rem;
            font-size: .875rem; border-left: 3px solid transparent;
            transition: all .15s;
        }
        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.active {
            color: #fff; background: rgba(255,255,255,.06);
            border-left-color: var(--primary);
        }
        .sidebar-nav .nav-link i { font-size: 1rem; width: 20px; text-align: center; }
        .sidebar-footer {
            margin-top: auto; padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,.08);
        }

        /* Main content */
        .admin-main { margin-left: 240px; min-height: 100vh; }
        .admin-topbar {
            background: #fff; border-bottom: 1px solid #e2e8f0;
            padding: .75rem 1.5rem; position: sticky; top: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
        }
        .admin-content { padding: 1.5rem; }

        /* Cards */
        .stat-card { border: none; border-radius: 12px; transition: transform .2s; }
        .stat-card:hover { transform: translateY(-2px); }
        .stat-icon { width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }

        /* Table */
        .table th { font-size: .75rem; font-weight: 600; text-transform: uppercase;
            letter-spacing: .5px; color: #64748b; }
        .table td { vertical-align: middle; }
        .badge { border-radius: 6px; }

        /* Forms */
        .form-label { font-weight: 500; font-size: .875rem; }
        .form-control, .form-select { border-radius: 8px; font-size: .9rem; }
        .form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(99,102,241,.15); }

        /* Quill rich text editor */
        .ql-toolbar.ql-snow {
            border-color: #ced4da; border-radius: 8px 8px 0 0; background: #f8f9fa;
        }
        .ql-container.ql-snow {
            border-color: #ced4da; border-radius: 0 0 8px 8px; font-size: .9rem;
        }
        .ql-editor { min-height: 260px; font-family: 'Manrope', sans-serif; }
        .ql-editor.ql-blank::before { font-style: normal; color: #6c757d; }
        .ql-container.ql-snow:focus-within {
            border-color: var(--primary); box-shadow: 0 0 0 3px rgba(99,102,241,.15);
        }

        /* Bootstrap primary → brand indigo */
        .btn-primary {
            --bs-btn-bg: var(--primary); --bs-btn-border-color: var(--primary);
            --bs-btn-hover-bg: var(--primary-dark); --bs-btn-hover-border-color: var(--primary-dark);
            --bs-btn-active-bg: var(--primary-dark); --bs-btn-active-border-color: var(--primary-dark);
        }
        .btn-outline-primary {
            --bs-btn-color: var(--primary); --bs-btn-border-color: var(--primary);
            --bs-btn-hover-bg: var(--primary); --bs-btn-hover-border-color: var(--primary);
        }
        /* Page header */
        .page-header { margin-bottom: 1.5rem; }
        .page-header h1 { font-size: 1.4rem; font-weight: 700; margin: 0; }

        @media (max-width: 991px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-sidebar.show { transform: translateX(0); }
            .admin-main { margin-left: 0; }
        }
    </style>
</head>
<body>

<div class="admin-sidebar" id="adminSidebar">
    <a class="sidebar-brand" href="{{ route('admin.dashboard') }}">
        <img src="{{ asset('uploads/logos/logo.svg') }}" alt="{{ config('app.name') }}" height="28">
    </a>

    <nav class="sidebar-nav mt-2">
        <div class="nav-section-label">Main</div>
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="nav-section-label mt-2">Manage</div>
        <a class="nav-link {{ request()->routeIs('admin.stores.*') ? 'active' : '' }}" href="{{ route('admin.stores.index') }}">
            <i class="bi bi-shop"></i> Stores
        </a>
        <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
            <i class="bi bi-tags"></i> Categories
        </a>
        <a class="nav-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}" href="{{ route('admin.coupons.index') }}">
            <i class="bi bi-ticket-perforated"></i> Coupons
        </a>
        <a class="nav-link {{ request()->routeIs('admin.sponsors.*') ? 'active' : '' }}" href="{{ route('admin.sponsors.index') }}">
            <i class="bi bi-award"></i> Sponsors
        </a>

        <div class="nav-section-label mt-2">Settings</div>
        <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.homepage') }}">
            <i class="bi bi-house-gear"></i> Home Page Setting
        </a>
    </nav>

    <div class="sidebar-footer">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                <i class="bi bi-box-arrow-left me-1"></i> Logout
            </button>
        </form>
    </div>
</div>

<div class="admin-main">
    <div class="admin-topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-outline-secondary d-lg-none" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <span class="fw-semibold text-muted small">@yield('title', 'Dashboard')</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-globe me-1"></i>View Site
            </a>
            <span class="small text-muted"><i class="bi bi-person-circle me-1"></i>{{ session('admin_user', 'Admin') }}</span>
        </div>
    </div>

    <div class="admin-content">

        {{-- Flash Messages --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    // Sidebar toggle for mobile
    document.getElementById('sidebarToggle')?.addEventListener('click', function () {
        document.getElementById('adminSidebar').classList.toggle('show');
    });
    // Auto-dismiss alerts
    setTimeout(function () {
        document.querySelectorAll('.alert-dismissible').forEach(function (el) {
            bootstrap.Alert.getOrCreateInstance(el).close();
        });
    }, 4000);

    // Every dropdown gets a searchable Select2 by default
    $(function () {
        $('select').each(function () {
            $(this).select2({
                theme: 'bootstrap-5',
                width: '100%',
                dropdownParent: $(this).closest('.modal').length ? $(this).closest('.modal') : $(document.body),
                minimumResultsForSearch: 0
            });
        });
    });
</script>
@stack('scripts')
</body>
</html>
