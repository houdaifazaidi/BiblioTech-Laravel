<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="BiblioTech — Your Digital Library">
    <title>@yield('title', 'Library') — BiblioTech</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        (function() {
            const theme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg: #090d16;
            --surface: #101725;
            --surface2: #1b253b;
            --border: #1e2d4a;
            --accent: #6366f1;
            --accent-glow: rgba(99, 102, 241, 0.15);
            --accent2: #8b5cf6;
            --success: #10b981;
            --success-glow: rgba(16, 185, 129, 0.15);
            --danger: #ef4444;
            --danger-glow: rgba(239, 68, 68, 0.15);
            --warning: #f59e0b;
            --warning-glow: rgba(245, 158, 11, 0.15);
            --text: #f1f5f9;
            --muted: #64748b;
            --radius: 16px;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.15);
            --shadow-md: 0 8px 20px rgba(0, 0, 0, 0.25);
            --shadow-lg: 0 16px 40px rgba(0, 0, 0, 0.4);
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        [data-theme="light"] {
            --bg: #f8fafc;
            --surface: #ffffff;
            --surface2: #f1f5f9;
            --border: #e2e8f0;
            --text: #0f172a;
            --muted: #64748b;
            --nav-bg: rgba(255, 255, 255, 0.85);
            --header-bg: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%);
            --accent-glow: rgba(99, 102, 241, 0.08);
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 6px 16px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 12px 32px rgba(0, 0, 0, 0.12);
        }

        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; -webkit-font-smoothing: antialiased; }
 
        /* Navbar */
        .navbar { background: var(--nav-bg, rgba(9, 13, 22, 0.8)); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 100; padding: 0 2rem; }
        .nav-inner { max-width: 1200px; margin: 0 auto; display: flex; align-items: center; height: 68px; gap: 1rem; }
        .nav-brand { font-size: 1.35rem; font-weight: 800; color: var(--accent); text-decoration: none; letter-spacing: -0.75px; margin-right: auto; display: flex; align-items: center; gap: 0.5rem; }
        .nav-brand span { color: var(--text); }
        .nav-link { color: var(--muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; padding: 0.5rem 1rem; border-radius: 10px; transition: var(--transition); }
        .nav-link:hover, .nav-link.active { background: var(--accent-glow); color: var(--accent); }
        .nav-btn { padding: 0.55rem 1.25rem; border-radius: 10px; font-size: 0.9rem; font-weight: 600; cursor: pointer; text-decoration: none; transition: var(--transition); border: none; outline: none; }
        .nav-btn-outline { border: 1px solid var(--border); color: var(--text); background: transparent; }
        .nav-btn-outline:hover { border-color: var(--accent); color: var(--accent); background: var(--accent-glow); }
        .nav-btn-solid { background: var(--accent); color: #fff; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3); }
        .nav-btn-solid:hover { background: #818cf8; transform: translateY(-1px); box-shadow: 0 6px 16px rgba(99, 102, 241, 0.4); }
 
        /* Hero / Page header */
        .page-header { background: var(--header-bg, linear-gradient(135deg, #101030 0%, #090d16 100%)); padding: 4.5rem 2rem 4rem; text-align: center; border-bottom: 1px solid var(--border); position: relative; overflow: hidden; }
        .page-header::before { content: ''; position: absolute; inset: 0; background: radial-gradient(circle at center, var(--accent-glow) 0%, transparent 70%); pointer-events: none; }
        .page-header h1 { font-size: 2.5rem; font-weight: 800; margin-bottom: 0.75rem; letter-spacing: -0.75px; position: relative; z-index: 1; }
        .page-header p { color: var(--muted); font-size: 1.1rem; max-width: 600px; margin: 0 auto; position: relative; z-index: 1; }

        /* Main container */
        .container { max-width: 1200px; margin: 0 auto; padding: 2.5rem 2rem; }

        /* Cards */
        .card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 2rem; box-shadow: var(--shadow-md); transition: var(--transition); }
        .card-title { font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; letter-spacing: -0.25px; display: flex; align-items: center; gap: 0.5rem; }

        /* Book Grid */
        .books-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.75rem; }
        .book-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; transition: var(--transition); display: flex; flex-direction: column; height: 100%; box-shadow: var(--shadow-sm); }
        .book-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); border-color: rgba(99, 102, 241, 0.35); }
        .book-cover-wrap { position: relative; width: 100%; aspect-ratio: 2/3; overflow: hidden; background: var(--surface2); }
        .book-cover { width: 100%; height: 100%; object-fit: cover; display: block; transition: var(--transition); }
        .book-card:hover .book-cover { transform: scale(1.05); }
        .book-info { padding: 1.25rem; display: flex; flex-direction: column; flex-grow: 1; }
        .book-title { font-size: 0.95rem; font-weight: 700; color: var(--text); line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 0.25rem; }
        .book-author { font-size: 0.8rem; color: var(--muted); margin-bottom: 0.75rem; font-weight: 500; }
        .book-genre { display: inline-block; align-self: flex-start; margin-bottom: 0.75rem; font-size: 0.68rem; font-weight: 700; padding: 0.25rem 0.6rem; border-radius: 999px; background: var(--accent-glow); color: var(--accent); text-transform: uppercase; letter-spacing: 0.5px; }
        .book-availability { font-size: 0.8rem; font-weight: 600; margin-top: auto; display: flex; align-items: center; gap: 0.35rem; }
        .book-availability::before { content: ''; display: inline-block; width: 6px; height: 6px; border-radius: 50%; }
        .available { color: var(--success); }
        .available::before { background: var(--success); }
        .unavailable { color: var(--danger); }
        .unavailable::before { background: var(--danger); }

        /* Filters */
        .filters { display: flex; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem; align-items: center; background: var(--surface); padding: 1.25rem; border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow-sm); }
        .filters input, .filters select { padding: 0.65rem 1rem; background: var(--surface2); border: 1px solid var(--border); border-radius: 10px; color: var(--text); font-size: 0.9rem; outline: none; font-family: inherit; transition: var(--transition); }
        .filters input:focus, .filters select:focus { border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-glow); }
        .filters input[type=text] { flex: 1; min-width: 250px; }
        .filter-label { font-size: 0.85rem; color: var(--muted); font-weight: 500; }

        /* Buttons */
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.65rem 1.25rem; border-radius: 10px; font-size: 0.9rem; font-weight: 600; cursor: pointer; border: none; text-decoration: none; transition: var(--transition); outline: none; }
        .btn-primary { background: var(--accent); color: #fff; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2); }
        .btn-primary:hover { background: #818cf8; transform: translateY(-1px); box-shadow: 0 6px 16px rgba(99, 102, 241, 0.3); }
        .btn-danger { background: var(--danger-glow); color: var(--danger); border: 1px solid rgba(239, 68, 68, 0.2); }
        .btn-danger:hover { background: var(--danger); color: #fff; transform: translateY(-1px); }
        .btn-success { background: var(--success-glow); color: var(--success); border: 1px solid rgba(16, 185, 129, 0.2); }
        .btn-success:hover { background: var(--success); color: #fff; transform: translateY(-1px); }
        .btn-secondary { background: rgba(255, 255, 255, 0.05); color: var(--text); border: 1px solid var(--border); }
        .btn-secondary:hover { background: rgba(255, 255, 255, 0.1); }
        .btn-sm { padding: 0.45rem 0.9rem; font-size: 0.8rem; border-radius: 8px; }
        .btn:disabled { opacity: 0.45; cursor: not-allowed; transform: none !important; box-shadow: none !important; }

        /* Badges */
        .badge { display: inline-flex; align-items: center; padding: 0.25rem 0.65rem; border-radius: 999px; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.75px; }
        .badge-active  { background: var(--success-glow); color: var(--success); border: 1px solid rgba(16, 185, 129, 0.15); }
        .badge-overdue { background: var(--danger-glow); color: var(--danger); border: 1px solid rgba(239, 68, 68, 0.15); }
        .badge-returned { background: var(--accent-glow); color: var(--accent); border: 1px solid rgba(99, 102, 241, 0.15); }

        /* Loans list */
        .loans-list { display: flex; flex-direction: column; gap: 1.25rem; }
        .loan-card { background: var(--surface2); border: 1px solid var(--border); border-radius: var(--radius); padding: 1.5rem; display: flex; gap: 1.5rem; align-items: center; transition: var(--transition); }
        .loan-card:hover { border-color: rgba(99, 102, 241, 0.25); box-shadow: var(--shadow-sm); }
        .loan-cover { width: 70px; height: 105px; object-fit: cover; border-radius: 10px; flex-shrink: 0; background: var(--surface); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); }
        .loan-details { flex: 1; }
        .loan-title { font-weight: 700; font-size: 1.05rem; color: var(--text); line-height: 1.3; }
        .loan-meta { font-size: 0.85rem; color: var(--muted); margin-top: 0.35rem; font-weight: 500; }
        .loan-penalty { margin-top: 0.5rem; font-size: 0.85rem; color: var(--danger); font-weight: 700; display: inline-flex; align-items: center; gap: 0.35rem; background: var(--danger-glow); padding: 0.25rem 0.75rem; border-radius: 8px; border: 1px solid rgba(239, 68, 68, 0.1); }
        .loan-actions { display: flex; flex-direction: column; gap: 0.65rem; align-items: flex-end; flex-shrink: 0; }

        /* Alerts */
        .alert { padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 500; border: 1px solid transparent; box-shadow: var(--shadow-sm); }
        .alert-success { background: var(--success-glow); border-color: rgba(16, 185, 129, 0.2); color: var(--success); }
        .alert-danger { background: var(--danger-glow); border-color: rgba(239, 68, 68, 0.2); color: var(--danger); }

        /* Forms */
        .form-group { margin-bottom: 1.5rem; }
        label { display: block; font-size: 0.85rem; font-weight: 600; color: var(--muted); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; }
        input[type=text], input[type=email], input[type=password], input[type=number], textarea {
            width: 100%; padding: 0.75rem 1rem; background: var(--surface2); border: 1px solid var(--border); border-radius: 10px; color: var(--text); font-size: 0.95rem; outline: none; transition: var(--transition); font-family: inherit; }
        input:focus, textarea:focus { border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-glow); }
        .form-error { color: var(--danger); font-size: 0.85rem; margin-top: 0.4rem; font-weight: 500; }

        /* Pagination */
        .pagination { display: flex; gap: 0.4rem; justify-content: center; margin-top: 2.5rem; flex-wrap: wrap; }
        .pagination a, .pagination span { display: inline-flex; align-items: center; justify-content: center; min-width: 40px; height: 40px; border-radius: 10px; font-size: 0.9rem; font-weight: 600; text-decoration: none; border: 1px solid var(--border); color: var(--text); padding: 0 0.5rem; transition: var(--transition); }
        .pagination a:hover { background: var(--accent); border-color: var(--accent); color: #fff; box-shadow: 0 4px 10px rgba(99, 102, 241, 0.25); }
        .pagination .active span { background: var(--accent); border-color: var(--accent); color: #fff; box-shadow: 0 4px 10px rgba(99, 102, 241, 0.25); }
        .pagination .disabled span { opacity: 0.35; }

        @media (max-width: 768px) {
            .navbar { padding: 0 1rem; }
            .container { padding: 1.5rem 1rem; }
            .loan-card { flex-direction: column; align-items: flex-start; gap: 1rem; }
            .loan-actions { flex-direction: row; align-items: center; justify-content: space-between; width: 100%; }
        }
        @media (max-width: 600px) { .books-grid { grid-template-columns: repeat(2, 1fr); gap: 1rem; } .filters { flex-direction: column; align-items: stretch; } }
    </style>
    @stack('styles')
</head>
<body>
<nav class="navbar">
    <div class="nav-inner">
        <a href="{{ route('member.books.index') }}" class="nav-brand">Biblio<span>Tech</span></a>
        <a href="{{ route('member.books.index') }}" class="nav-link {{ request()->routeIs('member.books.*') ? 'active' : '' }}">Browse</a>
        <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a>
        
        <button id="theme-toggle" class="nav-btn nav-btn-outline" style="padding: 0.4rem 0.6rem; font-size: 1rem; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; margin-left: 0.5rem; margin-right: auto;">
            <span class="theme-icon-light">☀️</span>
            <span class="theme-icon-dark" style="display:none;">🌙</span>
        </button>

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
<script>
const toggleBtn = document.getElementById('theme-toggle');
if (toggleBtn) {
    const lightIcon = toggleBtn.querySelector('.theme-icon-light');
    const darkIcon = toggleBtn.querySelector('.theme-icon-dark');
    
    function updateTogglerUI(theme) {
        if (theme === 'light') {
            lightIcon.style.display = 'none';
            darkIcon.style.display = 'inline';
        } else {
            lightIcon.style.display = 'inline';
            darkIcon.style.display = 'none';
        }
    }
    
    // Initial UI state
    const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
    updateTogglerUI(currentTheme);
    
    toggleBtn.addEventListener('click', () => {
        const activeTheme = document.documentElement.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
        document.documentElement.setAttribute('data-theme', activeTheme);
        localStorage.setItem('theme', activeTheme);
        updateTogglerUI(activeTheme);
    });
}
</script>
@stack('scripts')
</body>
</html>
