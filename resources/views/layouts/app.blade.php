<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="BiblioTech — Your Digital Library">
    <title>@yield('title', 'Library') — BiblioTech</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg: #0a0d16;
            --surface: #111827;
            --surface2: #1e293b;
            --border: #1f2d45;
            --accent: #6366f1;
            --accent2: #8b5cf6;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --text: #e2e8f0;
            --muted: #64748b;
            --radius: 12px;
        }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }

        /* Navbar */
        .navbar { background: rgba(17,24,39,0.85); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 100; padding: 0 2rem; }
        .nav-inner { max-width: 1200px; margin: 0 auto; display: flex; align-items: center; height: 60px; gap: 1rem; }
        .nav-brand { font-size: 1.2rem; font-weight: 700; color: var(--accent); text-decoration: none; letter-spacing: -0.5px; margin-right: auto; }
        .nav-brand span { color: var(--text); }
        .nav-link { color: var(--muted); text-decoration: none; font-size: 0.875rem; font-weight: 500; padding: 0.4rem 0.75rem; border-radius: 8px; transition: all 0.15s; }
        .nav-link:hover, .nav-link.active { background: rgba(99,102,241,0.1); color: var(--accent); }
        .nav-btn { padding: 0.45rem 1rem; border-radius: 8px; font-size: 0.875rem; font-weight: 500; cursor: pointer; text-decoration: none; transition: all 0.15s; border: none; }
        .nav-btn-outline { border: 1px solid var(--border); color: var(--text); background: transparent; }
        .nav-btn-outline:hover { border-color: var(--accent); color: var(--accent); }
        .nav-btn-solid { background: var(--accent); color: #fff; }
        .nav-btn-solid:hover { background: #818cf8; }

        /* Hero / Page header */
        .page-header { background: linear-gradient(135deg, #1e1b4b 0%, #0f172a 60%); padding: 3rem 2rem; text-align: center; }
        .page-header h1 { font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem; }
        .page-header p { color: var(--muted); font-size: 1rem; }

        /* Main container */
        .container { max-width: 1200px; margin: 0 auto; padding: 2rem; }

        /* Cards */
        .card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 1.5rem; }
        .card-title { font-size: 1rem; font-weight: 600; margin-bottom: 1rem; }

        /* Book Grid */
        .books-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1.25rem; }
        .book-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .book-card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(99,102,241,0.15); border-color: var(--accent); }
        .book-cover { width: 100%; aspect-ratio: 2/3; object-fit: cover; background: var(--surface2); display: block; }
        .book-info { padding: 0.875rem; }
        .book-title { font-size: 0.875rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .book-author { font-size: 0.75rem; color: var(--muted); margin-top: 0.2rem; }
        .book-genre { display: inline-block; margin-top: 0.5rem; font-size: 0.65rem; font-weight: 600; padding: 0.15rem 0.5rem; border-radius: 999px; background: rgba(99,102,241,0.12); color: var(--accent); }
        .book-availability { font-size: 0.75rem; margin-top: 0.4rem; }
        .available { color: var(--success); }
        .unavailable { color: var(--danger); }

        /* Filters */
        .filters { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1.5rem; align-items: center; }
        .filters input, .filters select { padding: 0.5rem 0.875rem; background: var(--surface); border: 1px solid var(--border); border-radius: 8px; color: var(--text); font-size: 0.875rem; outline: none; font-family: inherit; }
        .filters input:focus, .filters select:focus { border-color: var(--accent); }
        .filters input[type=text] { flex: 1; min-width: 200px; }
        .filter-label { font-size: 0.75rem; color: var(--muted); }

        /* Buttons */
        .btn { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.875rem; font-weight: 500; cursor: pointer; border: none; text-decoration: none; transition: all 0.15s ease; }
        .btn-primary { background: var(--accent); color: #fff; }
        .btn-primary:hover { background: #818cf8; }
        .btn-danger { background: rgba(239,68,68,0.12); color: #ef4444; border: 1px solid rgba(239,68,68,0.25); }
        .btn-danger:hover { background: #ef4444; color: #fff; }
        .btn-success { background: rgba(16,185,129,0.12); color: #10b981; border: 1px solid rgba(16,185,129,0.25); }
        .btn-success:hover { background: #10b981; color: #fff; }
        .btn-secondary { background: rgba(255,255,255,0.05); color: var(--text); border: 1px solid var(--border); }
        .btn-sm { padding: 0.3rem 0.7rem; font-size: 0.8rem; }
        .btn:disabled { opacity: 0.4; cursor: not-allowed; }

        /* Badges */
        .badge { display: inline-flex; align-items: center; padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .badge-active  { background: rgba(16,185,129,0.12); color: #10b981; }
        .badge-overdue { background: rgba(239,68,68,0.12); color: #ef4444; }
        .badge-returned { background: rgba(99,102,241,0.12); color: #6366f1; }

        /* Loans table */
        .loans-list { display: flex; flex-direction: column; gap: 1rem; }
        .loan-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 1.25rem; display: flex; gap: 1rem; align-items: flex-start; }
        .loan-cover { width: 60px; height: 90px; object-fit: cover; border-radius: 6px; flex-shrink: 0; background: var(--surface2); }
        .loan-details { flex: 1; }
        .loan-title { font-weight: 600; font-size: 0.95rem; }
        .loan-meta { font-size: 0.8rem; color: var(--muted); margin-top: 0.25rem; }
        .loan-penalty { margin-top: 0.5rem; font-size: 0.8rem; color: var(--danger); font-weight: 600; }
        .loan-actions { display: flex; flex-direction: column; gap: 0.4rem; align-items: flex-end; flex-shrink: 0; }

        /* Alerts */
        .alert { padding: 0.875rem 1rem; border-radius: 8px; margin-bottom: 1rem; font-size: 0.875rem; }
        .alert-success { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.25); color: #10b981; }
        .alert-danger { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.25); color: #ef4444; }

        /* Forms */
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; font-size: 0.8rem; font-weight: 500; color: var(--muted); margin-bottom: 0.4rem; }
        input[type=text], input[type=email], input[type=password], input[type=number], textarea {
            width: 100%; padding: 0.65rem 0.875rem; background: var(--surface); border: 1px solid var(--border); border-radius: 8px; color: var(--text); font-size: 0.875rem; outline: none; transition: border-color 0.15s ease; font-family: inherit; }
        input:focus, textarea:focus { border-color: var(--accent); }
        .form-error { color: var(--danger); font-size: 0.8rem; margin-top: 0.3rem; }

        /* Auth form */
        .auth-wrapper { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem; background: radial-gradient(ellipse at 50% 0%, rgba(99,102,241,0.12) 0%, transparent 70%); }
        .auth-card { background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 2.5rem; width: 100%; max-width: 420px; }
        .auth-title { font-size: 1.5rem; font-weight: 700; margin-bottom: 0.25rem; }
        .auth-subtitle { font-size: 0.875rem; color: var(--muted); margin-bottom: 2rem; }

        /* Pagination */
        .pagination { display: flex; gap: 0.4rem; justify-content: center; margin-top: 2rem; flex-wrap: wrap; }
        .pagination a, .pagination span { display: inline-flex; align-items: center; justify-content: center; min-width: 36px; height: 36px; border-radius: 8px; font-size: 0.875rem; text-decoration: none; border: 1px solid var(--border); color: var(--text); padding: 0 0.5rem; transition: all 0.15s; }
        .pagination a:hover { background: var(--accent); border-color: var(--accent); }
        .pagination .active span { background: var(--accent); border-color: var(--accent); color: #fff; }
        .pagination .disabled span { opacity: 0.35; }

        @media (max-width: 600px) { .books-grid { grid-template-columns: repeat(2, 1fr); } .filters { flex-direction: column; } }
    </style>
    @stack('styles')
</head>
<body>
<nav class="navbar">
    <div class="nav-inner">
        <a href="{{ route('member.books.index') }}" class="nav-brand">Biblio<span>Tech</span></a>
        <a href="{{ route('member.books.index') }}" class="nav-link {{ request()->routeIs('member.books.*') ? 'active' : '' }}">Browse</a>
        @auth('web')
            <a href="{{ route('member.dashboard') }}" class="nav-link {{ request()->routeIs('member.dashboard') ? 'active' : '' }}">My Loans</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="nav-btn nav-btn-outline">Log Out</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="nav-btn nav-btn-outline">Log In</a>
            <a href="{{ route('register') }}" class="nav-btn nav-btn-solid">Sign Up</a>
        @endauth
    </div>
</nav>
<main>
    @if(session('success'))
        <div class="container" style="padding-bottom:0;">
            <div class="alert alert-success">{{ session('success') }}</div>
        </div>
    @endif
    @if(session('error'))
        <div class="container" style="padding-bottom:0;">
            <div class="alert alert-danger">{{ session('error') }}</div>
        </div>
    @endif
    @yield('content')
</main>
@stack('scripts')
</body>
</html>
