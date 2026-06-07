<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — BiblioTech</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #0f1117; color: #e2e8f0; min-height: 100vh; display: flex; align-items: center; justify-content: center; background: radial-gradient(ellipse at 50% 0%, rgba(99,102,241,0.15) 0%, transparent 70%), #0f1117; }
        .card { background: #1e2535; border: 1px solid #2a3349; border-radius: 16px; padding: 2.5rem; width: 100%; max-width: 420px; }
        .logo { font-size: 1.4rem; font-weight: 700; color: #6366f1; margin-bottom: 0.25rem; }
        .logo span { color: #e2e8f0; }
        .subtitle { font-size: 0.875rem; color: #64748b; margin-bottom: 2rem; }
        .admin-badge { display: inline-flex; align-items: center; gap: 0.4rem; background: rgba(99,102,241,0.1); border: 1px solid rgba(99,102,241,0.25); color: #818cf8; border-radius: 999px; font-size: 0.7rem; font-weight: 600; padding: 0.25rem 0.75rem; margin-bottom: 1.5rem; letter-spacing: 0.5px; text-transform: uppercase; }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; font-size: 0.8rem; font-weight: 500; color: #94a3b8; margin-bottom: 0.4rem; }
        input { width: 100%; padding: 0.65rem 0.875rem; background: rgba(255,255,255,0.04); border: 1px solid #2a3349; border-radius: 8px; color: #e2e8f0; font-size: 0.875rem; outline: none; transition: border-color 0.15s; font-family: inherit; }
        input:focus { border-color: #6366f1; }
        .btn { width: 100%; padding: 0.7rem; background: #6366f1; color: #fff; border: none; border-radius: 8px; font-size: 0.9rem; font-weight: 600; cursor: pointer; transition: background 0.15s; }
        .btn:hover { background: #818cf8; }
        .error { color: #ef4444; font-size: 0.8rem; margin-top: 0.3rem; }
        .alert { padding: 0.875rem 1rem; border-radius: 8px; margin-bottom: 1rem; font-size: 0.875rem; background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.25); color: #ef4444; }
        .remember { display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.25rem; }
        .remember input[type=checkbox] { width: auto; accent-color: #6366f1; }
        .remember label { margin: 0; font-size: 0.85rem; color: #94a3b8; }
    </style>
</head>
<body>
<div class="card">
    <div class="logo">Biblio<span>Tech</span></div>
    <p class="subtitle">Library Management System</p>
    <div class="admin-badge">🔑 Admin Portal</div>

    @if($errors->any())
        <div class="alert">{{ $errors->first() }}</div>
    @endif
    @if(session('error'))
        <div class="alert">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@bibliotech.com">
            @error('email') <div class="error">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required placeholder="••••••••">
        </div>
        <div class="remember">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Remember me</label>
        </div>
        <button type="submit" class="btn">Sign In to Admin</button>
    </form>
</div>
</body>
</html>
