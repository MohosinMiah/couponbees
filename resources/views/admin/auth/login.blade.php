<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — CouponHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #6366f1; --primary-dark: #4f46e5; }
        body { background: linear-gradient(135deg, #0f172a 0%, #1a1747 100%); font-family: 'Manrope', sans-serif; min-height: 100vh;
               display: flex; align-items: center; justify-content: center; }
        h1 { font-family: 'Space Grotesk', sans-serif; }
        .login-card { width: 100%; max-width: 400px; border-radius: 16px; border: none; }
        .login-header { background: rgba(0,0,0,.15); border-radius: 16px 16px 0 0; padding: 2rem; text-align: center; }
        .form-control { border-radius: 8px; padding: .65rem 1rem; }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(99,102,241,.15); }
        .btn-login { border-radius: 8px; padding: .65rem; font-weight: 600; background: var(--primary); border-color: var(--primary); }
        .btn-login:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
    </style>
</head>
<body>
<div class="login-card card shadow-lg">
    <div class="login-header">
        <div class="mb-2"><img src="{{ asset('uploads/logos/logo.svg') }}" alt="{{ config('app.name') }}" height="40"></div>
        <h1 class="h4 text-white fw-bold mb-0">Admin</h1>
        <p class="text-secondary small mb-0">Sign in to manage your coupons</p>
    </div>
    <div class="card-body p-4">

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
            <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold small">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                           value="{{ old('username') }}" placeholder="admin" required autofocus>
                </div>
                @error('username')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold small">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                           placeholder="••••••••" required>
                </div>
                @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary btn-login w-100">
                <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
            </button>
        </form>

        <div class="mt-3 p-3 bg-light rounded-3 small text-muted text-center">
            Default: <strong>admin</strong> / <strong>admin123</strong>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
