<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="BiblioTech Admin — Secure Login">
    <title>Admin Login — BiblioTech</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700;0,14..32,800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #0b0f1a;
            color: #e2e8f0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        /* Animated background orbs */
        body::before {
            content: '';
            position: fixed;
            top: -20%;
            left: 50%;
            transform: translateX(-50%);
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(99,102,241,0.18) 0%, transparent 60%);
            pointer-events: none;
            animation: orb1 8s ease-in-out infinite alternate;
        }
        body::after {
            content: '';
            position: fixed;
            bottom: -20%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(139,92,246,0.12) 0%, transparent 60%);
            pointer-events: none;
            animation: orb2 10s ease-in-out infinite alternate;
        }
        @keyframes orb1 { from { transform: translateX(-50%) scale(1); } to { transform: translateX(-40%) scale(1.15); } }
        @keyframes orb2 { from { transform: scale(1); } to { transform: scale(1.2) translate(-5%, -5%); } }

        /* Card */
        .login-card {
            background: #1a2235;
            border: 1px solid #2a3550;
            border-radius: 20px;
            padding: 2.75rem 2.5rem;
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 1;
            box-shadow: 0 24px 60px rgba(0,0,0,0.5), 0 0 0 1px rgba(99,102,241,0.08);
            animation: cardIn 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        @keyframes cardIn {
            from { opacity: 0; transform: translateY(24px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        .login-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            border-radius: 20px 20px 0 0;
        }

        /* Logo area */
        .card-logo {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            margin-bottom: 1.75rem;
        }
        .card-logo-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            box-shadow: 0 4px 14px rgba(99,102,241,0.4);
        }
        .card-logo-text { font-size: 1.25rem; font-weight: 800; color: #6366f1; letter-spacing: -0.5px; }
        .card-logo-text span { color: #e2e8f0; }

        .card-title { font-size: 1.5rem; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 0.3rem; }
        .card-subtitle { font-size: 0.875rem; color: #94a3b8; margin-bottom: 0.25rem; }

        .admin-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: rgba(99,102,241,0.12);
            border: 1px solid rgba(99,102,241,0.25);
            color: #818cf8;
            border-radius: 999px;
            font-size: 0.67rem;
            font-weight: 700;
            padding: 0.22rem 0.7rem;
            margin: 0.75rem 0 1.75rem;
            text-transform: uppercase;
            letter-spacing: 0.75px;
        }

        /* Form */
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; font-size: 0.78rem; font-weight: 600; color: #94a3b8; margin-bottom: 0.4rem; text-transform: uppercase; letter-spacing: 0.4px; }
        input {
            width: 100%;
            padding: 0.7rem 0.95rem;
            background: rgba(255,255,255,0.04);
            border: 1px solid #2a3550;
            border-radius: 8px;
            color: #e2e8f0;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.2s ease;
            font-family: inherit;
        }
        input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.18);
            background: rgba(255,255,255,0.06);
        }
        input::placeholder { color: #475569; }

        .error { color: #ef4444; font-size: 0.8rem; margin-top: 0.3rem; font-weight: 500; }
        .alert {
            padding: 0.875rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.25rem;
            font-size: 0.875rem;
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.25);
            color: #ef4444;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }
        .remember input[type=checkbox] {
            width: 16px;
            height: 16px;
            accent-color: #6366f1;
            cursor: pointer;
            flex-shrink: 0;
        }
        .remember label { margin: 0; font-size: 0.85rem; color: #94a3b8; text-transform: none; letter-spacing: 0; cursor: pointer; font-weight: 400; }

        .btn-submit {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: inherit;
            box-shadow: 0 4px 14px rgba(99,102,241,0.35);
            letter-spacing: 0.2px;
        }
        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 22px rgba(99,102,241,0.5);
            filter: brightness(1.05);
        }
        .btn-submit:active { transform: translateY(0); }

        .back-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.82rem;
        }
        .back-link a { color: #6366f1; text-decoration: none; font-weight: 500; }
        .back-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="login-card">
    <div class="card-logo">
        <div class="card-logo-icon">🏛️</div>
        <div class="card-logo-text">Biblio<span>Tech</span></div>
    </div>

    <div class="card-title">Welcome back</div>
    <div class="card-subtitle">Sign in to your admin account</div>
    <div class="admin-badge">🔑 Admin Portal</div>

    @if($errors->any())
        <div class="alert">⚠ {{ $errors->first() }}</div>
    @endif
    @if(session('error'))
        <div class="alert">⚠ {{ session('error') }}</div>
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
        <button type="submit" class="btn-submit">Sign In to Admin</button>
    </form>

    <div class="back-link">
        <a href="{{ url('/') }}">← Back to BiblioTech</a>
    </div>
</div>
</body>
</html>
