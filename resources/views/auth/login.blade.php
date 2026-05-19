<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Beauty Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #FCE4EC 0%, #F8BBD9 50%, #E1BEE7 100%);
            display: flex; align-items: center; justify-content: center;
        }
        .auth-card {
            background: white; border-radius: 20px;
            padding: 40px; width: 100%; max-width: 420px;
            box-shadow: 0 20px 60px rgba(233,30,140,0.15);
        }
        .brand { text-align: center; margin-bottom: 30px; }
        .brand-icon { font-size: 3rem; }
        .brand h4 { color: #E91E8C; font-weight: 700; margin-top: 8px; }
        .btn-pink {
            background: #E91E8C; color: white; border: none;
            padding: 12px; border-radius: 10px; font-weight: 600;
            width: 100%; transition: all 0.3s;
        }
        .btn-pink:hover { background: #C2185B; color: white; transform: translateY(-1px); }
        .form-control {
            border-radius: 10px; padding: 12px 16px;
            border: 1.5px solid #eee;
        }
        .form-control:focus { border-color: #E91E8C; box-shadow: 0 0 0 3px rgba(233,30,140,0.1); }
        .form-label { font-weight: 600; font-size: 0.9rem; color: #444; }
        .input-group-text { border-radius: 0 10px 10px 0; border-color: #eee; background: #fafafa; }
    </style>
</head>
<body>
<div class="auth-card">
    <div class="brand">
        <div class="brand-icon">💄</div>
        <h4>Beauty Shop</h4>
        <p class="text-muted small mb-0">Login to your account</p>
    </div>

    {{-- Alerts --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success rounded-3">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif

    <form action="{{ route('login.submit') }}" method="POST">
        @csrf

        {{-- Email --}}
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <div class="input-group">
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="aapka@email.com"
                       value="{{ old('email') }}" autocomplete="email">
                <span class="input-group-text"><i class="bi bi-envelope text-muted"></i></span>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
                <input type="password" name="password" id="passwordInput"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="••••••••">
                <span class="input-group-text" style="cursor:pointer;"
                      onclick="togglePassword()">
                    <i class="bi bi-eye" id="eyeIcon"></i>
                </span>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Remember --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label small" for="remember">Remember me</label>
            </div>
            <a href="#" class="small text-decoration-none" style="color:#E91E8C;">
Forgot Password?
            </a>
        </div>

        <button type="submit" class="btn btn-pink">
            <i class="bi bi-box-arrow-in-right me-2"></i>Login
        </button>
    </form>

    <hr class="my-4">
    <p class="text-center text-muted small mb-0">
       Don't have an account?
        <a href="{{ route('register') }}" style="color:#E91E8C;" class="fw-bold text-decoration-none">
           Register
        </a>
    </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePassword() {
    const input = document.getElementById('passwordInput');
    const icon  = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
    }
}
</script>
</body>
</html>