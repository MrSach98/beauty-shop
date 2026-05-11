<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register — Beauty Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #FCE4EC 0%, #F8BBD9 50%, #E1BEE7 100%);
            display: flex; align-items: center; justify-content: center; padding: 30px 0;
        }
        .auth-card {
            background: white; border-radius: 20px;
            padding: 40px; width: 100%; max-width: 440px;
            box-shadow: 0 20px 60px rgba(233,30,140,0.15);
        }
        .brand { text-align: center; margin-bottom: 28px; }
        .brand-icon { font-size: 2.5rem; }
        .brand h4 { color: #E91E8C; font-weight: 700; margin-top: 6px; }
        .btn-pink {
            background: #E91E8C; color: white; border: none;
            padding: 12px; border-radius: 10px; font-weight: 600;
            width: 100%; transition: all 0.3s;
        }
        .btn-pink:hover { background: #C2185B; color: white; }
        .form-control {
            border-radius: 10px; padding: 11px 16px;
            border: 1.5px solid #eee;
        }
        .form-control:focus { border-color: #E91E8C; box-shadow: 0 0 0 3px rgba(233,30,140,0.1); }
        .form-label { font-weight: 600; font-size: 0.88rem; color: #444; }
    </style>
</head>
<body>
<div class="auth-card">
    <div class="brand">
        <div class="brand-icon">💄</div>
        <h4>Beauty Shop</h4>
        <p class="text-muted small mb-0">Naya account banao</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger rounded-3">
            <ul class="mb-0 small ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register.submit') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Pura Naam</label>
            <input type="text" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   placeholder="Aapka naam" value="{{ old('name') }}">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="aapka@email.com" value="{{ old('email') }}">
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="text" name="phone" maxlength="10"
                   class="form-control @error('phone') is-invalid @enderror"
                   placeholder="10 digit mobile number" value="{{ old('phone') }}">
            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Min 6 characters">
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label class="form-label">Password Confirm Karo</label>
            <input type="password" name="password_confirmation"
                   class="form-control" placeholder="Password dobara daalo">
        </div>

        <button type="submit" class="btn btn-pink">
            <i class="bi bi-person-plus me-2"></i>Account Banao
        </button>
    </form>

    <hr class="my-4">
    <p class="text-center text-muted small mb-0">
        Pehle se account hai?
        <a href="{{ route('login') }}" style="color:#E91E8C;" class="fw-bold text-decoration-none">
            Login Karo
        </a>
    </p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>