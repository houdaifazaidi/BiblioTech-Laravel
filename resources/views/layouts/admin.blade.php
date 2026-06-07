<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="BiblioTech Library Management System - Admin Panel">
    <title>@yield('title', 'Admin') — BiblioTech</title>
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
            --bg: #0f1117;
            --sidebar: #161b27;
            --surface: #1e2535;
            --border: #2a3349;
            --accent: #6366f1;
            --accent-hover: #818cf8;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --text: #e2e8f0;
            --muted: #94a3b8;
            --radius: 10px;
        }

        [data-theme="light"] {
            --bg: #f8fafc;
            --sidebar: #ffffff;
            --surface: #ffffff;
            --border: #e2e8f0;
            --text: #0f172a;
            --muted: #64748b;
            --hover-bg: rgba(0,0,0,0.03);
            --th-bg: rgba(0,0,0,0.02);
            --input-bg: #f1f5f9;
        }

        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; display: flex; }

        /* Sidebar */
        .sidebar { width: 240px; background: var(--sidebar); border-right: 1px solid var(--border); display: flex; flex-direction: column; padding: 1.5rem 1rem; position: fixed; top: 0; left: 0; height: 100vh; z-index: 100; }
        .sidebar-brand { font-size: 1.3rem; font-weight: 700; color: var(--accent); letter-spacing: -0.5px; padding: 0 0.5rem 1.5rem; border-bottom: 1px solid var(--border); }
        .sidebar-brand span { color: var(--text); }
        .sidebar-nav { flex: 1; padding-top: 1rem; }
        .nav-section { font-size: 0.65rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; color: var(--muted); padding: 1rem 0.5rem 0.5rem; }
        .nav-link { display: flex; align-items: center; gap: 0.6rem; padding: 0.6rem 0.75rem; border-radius: 8px; color: var(--muted); text-decoration: none; font-size: 0.875rem; font-weight: 500; transition: all 0.15s ease; margin-bottom: 2px; }
        .nav-link:hover, .nav-link.active { background: rgba(99,102,241,0.12); color: var(--accent-hover); }
        .nav-link .icon { width: 18px; height: 18px; flex-shrink: 0; }
        .sidebar-footer { padding-top: 1rem; border-top: 1px solid var(--border); }

        /* Main */
        .main { margin-left: 240px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .topbar { background: var(--sidebar); border-bottom: 1px solid var(--border); padding: 1rem 2rem; display: flex; align-items: center; justify-content: space-between; }
        .topbar-title { font-size: 1.1rem; font-weight: 600; }
        .topbar-admin { font-size: 0.875rem; color: var(--muted); }
        .content { padding: 2rem; flex: 1; }

        /* Cards */
        .card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 1.5rem; }
        .card-title { font-size: 1rem; font-weight: 600; margin-bottom: 1rem; }

        /* Stats Grid */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 1.25rem; }
        .stat-value { font-size: 2rem; font-weight: 700; }
        .stat-label { font-size: 0.8rem; color: var(--muted); margin-top: 0.25rem; }

        /* Tables */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        th { text-align: left; padding: 0.75rem 1rem; background: var(--th-bg, rgba(255,255,255,0.03)); color: var(--muted); font-weight: 500; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--border); }
        td { padding: 0.85rem 1rem; border-bottom: 1px solid rgba(255,255,255,0.04); vertical-align: middle; }
        tr:hover td { background: var(--hover-bg, rgba(255,255,255,0.02)); }

        /* Badges */
        .badge { display: inline-flex; align-items: center; padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .badge-active { background: rgba(16,185,129,0.12); color: #10b981; }
        .badge-overdue { background: rgba(239,68,68,0.12); color: #ef4444; }
        .badge-returned { background: rgba(99,102,241,0.12); color: #6366f1; }
        .badge-success { background: rgba(16,185,129,0.12); color: #10b981; }
        .badge-danger { background: rgba(239,68,68,0.12); color: #ef4444; }

        /* Buttons */
        .btn { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.875rem; font-weight: 500; cursor: pointer; border: none; text-decoration: none; transition: all 0.15s ease; }
        .btn-primary { background: var(--accent); color: #fff; }
        .btn-primary:hover { background: var(--accent-hover); }
        .btn-danger { background: rgba(239,68,68,0.15); color: #ef4444; border: 1px solid rgba(239,68,68,0.3); }
        .btn-danger:hover { background: #ef4444; color: #fff; }
        .btn-secondary { background: rgba(255,255,255,0.06); color: var(--text); border: 1px solid var(--border); }
        .btn-secondary:hover { background: rgba(255,255,255,0.1); }
        .btn-sm { padding: 0.3rem 0.7rem; font-size: 0.8rem; }

        /* Forms */
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; font-size: 0.8rem; font-weight: 500; color: var(--muted); margin-bottom: 0.4rem; }
        input[type=text], input[type=email], input[type=password], input[type=number], input[type=file], select, textarea {
            width: 100%; padding: 0.6rem 0.875rem; background: var(--input-bg, rgba(255,255,255,0.04)); border: 1px solid var(--border); border-radius: 8px; color: var(--text); font-size: 0.875rem; outline: none; transition: border-color 0.15s ease; font-family: inherit; }
        input:focus, select:focus, textarea:focus { border-color: var(--accent); }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .form-error { color: var(--danger); font-size: 0.8rem; margin-top: 0.3rem; }

        /* Alerts */
        .alert { padding: 0.875rem 1rem; border-radius: 8px; margin-bottom: 1rem; font-size: 0.875rem; }
        .alert-success { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.25); color: #10b981; }
        .alert-danger { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.25); color: #ef4444; }

        /* Search bar */
        .search-bar { display: flex; gap: 0.5rem; margin-bottom: 1.25rem; }
        .search-bar input { flex: 1; }

        /* Pagination */
        .pagination { display: flex; gap: 0.4rem; justify-content: center; margin-top: 1.5rem; flex-wrap: wrap; }
        .pagination a, .pagination span { display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 8px; font-size: 0.875rem; text-decoration: none; border: 1px solid var(--border); color: var(--text); transition: all 0.15s; }
        .pagination a:hover { background: var(--accent); border-color: var(--accent); }
        .pagination .active span { background: var(--accent); border-color: var(--accent); color: #fff; }
        .pagination .disabled span { opacity: 0.35; }

        /* Modal */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); z-index: 1000; align-items: center; justify-content: center; }
        .modal-overlay.open { display: flex; }
        .modal { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; padding: 2rem; max-width: 480px; width: 90%; }
        .modal-title { font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem; }
        .modal-body { color: var(--muted); font-size: 0.9rem; margin-bottom: 1.5rem; line-height: 1.6; }
        .modal-actions { display: flex; flex-direction: column; gap: 0.5rem; }
        .modal-actions .btn { justify-content: center; padding: 0.7rem; }

        @media (max-width: 768px) { .sidebar { display: none; } .main { margin-left: 0; } .form-grid { grid-template-columns: 1fr; } }
    </style>
    @stack('styles')
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-brand">Biblio<span>Tech</span></div>
    <nav class="sidebar-nav">
        <div class="nav-section">Overview</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h4v4H3zm0 6h4v4H3zm7-6h11M10 13h11"/></svg>
            Dashboard
        </a>
        <div class="nav-section">Library</div>
        <a href="{{ route('admin.books.index') }}" class="nav-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
            <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
            Books
        </a>
        <a href="{{ route('admin.members.index') }}" class="nav-link {{ request()->routeIs('admin.members.*') ? 'active' : '' }}">
            <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zm8 0a3 3 0 100-6 3 3 0 000 6m4 10v-2a3 3 0 00-2.236-2.908"/></svg>
            Members
        </a>
    </nav>
    <div class="sidebar-footer">
        <button id="theme-toggle" class="btn btn-secondary" style="width:100%; justify-content:center; margin-bottom:0.5rem;">
            <span class="theme-icon-light">☀️ Light Mode</span>
            <span class="theme-icon-dark" style="display:none;">🌙 Dark Mode</span>
        </button>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="btn btn-secondary" style="width:100%; justify-content:center;">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/></svg>
                Log Out
            </button>
        </form>
    </div>
</aside>
<div class="main">
    <header class="topbar">
        <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
        <div class="topbar-admin">👤 {{ auth()->guard('admin')->user()->name ?? 'Admin' }}</div>
    </header>
    <main class="content">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @yield('content')
    </main>
</div>
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
