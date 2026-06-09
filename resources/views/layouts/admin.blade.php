<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="BiblioTech Library Management System - Admin Panel">
    <title>@yield('title', 'Admin') — BiblioTech Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,300;0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700;0,14..32,800;1,14..32,400&display=swap" rel="stylesheet">
    <script>
        (function() {
            const theme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        /* ── Design Tokens ── */
        :root {
            --bg: #0b0f1a;
            --sidebar: #111827;
            --surface: #1a2235;
            --surface2: #222d42;
            --border: #2a3550;
            --accent: #6366f1;
            --accent2: #8b5cf6;
            --accent-hover: #818cf8;
            --accent-glow: rgba(99, 102, 241, 0.15);
            --success: #10b981;
            --success-glow: rgba(16, 185, 129, 0.12);
            --danger: #ef4444;
            --danger-glow: rgba(239, 68, 68, 0.12);
            --warning: #f59e0b;
            --warning-glow: rgba(245, 158, 11, 0.12);
            --info: #06b6d4;
            --info-glow: rgba(6, 182, 212, 0.12);
            --text: #e2e8f0;
            --muted: #94a3b8;
            --radius: 12px;
            --radius-sm: 8px;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.2);
            --shadow-md: 0 6px 20px rgba(0, 0, 0, 0.3);
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            --input-bg: rgba(255, 255, 255, 0.04);
            --hover-bg: rgba(255, 255, 255, 0.025);
            --th-bg: rgba(255, 255, 255, 0.03);
        }

        [data-theme="light"] {
            --bg: #f0f4f8;
            --sidebar: #ffffff;
            --surface: #ffffff;
            --surface2: #f8fafc;
            --border: #e2e8f0;
            --text: #0f172a;
            --muted: #64748b;
            --accent-glow: rgba(99, 102, 241, 0.08);
            --success-glow: rgba(16, 185, 129, 0.08);
            --danger-glow: rgba(239, 68, 68, 0.08);
            --warning-glow: rgba(245, 158, 11, 0.08);
            --info-glow: rgba(6, 182, 212, 0.08);
            --input-bg: #f8fafc;
            --hover-bg: rgba(0, 0, 0, 0.025);
            --th-bg: rgba(0, 0, 0, 0.02);
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 6px 20px rgba(0, 0, 0, 0.08);
        }

        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; display: flex; -webkit-font-smoothing: antialiased; }

        /* ── Sidebar ── */
        .sidebar {
            width: 250px;
            background: var(--sidebar);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 100;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        /* top accent stripe */
        .sidebar::before {
            content: '';
            display: block;
            height: 3px;
            background: linear-gradient(90deg, var(--accent), var(--accent2));
            flex-shrink: 0;
        }

        .sidebar-header {
            padding: 1.25rem 1.25rem 1rem;
            border-bottom: 1px solid var(--border);
        }
        .sidebar-brand {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--accent);
            letter-spacing: -0.5px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .sidebar-brand-icon {
            width: 28px;
            height: 28px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            box-shadow: 0 3px 10px rgba(99, 102, 241, 0.3);
            flex-shrink: 0;
        }
        .sidebar-brand span { color: var(--text); }
        .sidebar-badge {
            margin-top: 0.6rem;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            background: var(--accent-glow);
            border: 1px solid rgba(99, 102, 241, 0.2);
            color: var(--accent-hover);
            border-radius: 999px;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 0.2rem 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sidebar-nav { flex: 1; padding: 0.75rem 0.75rem; }
        .nav-section {
            font-size: 0.62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--muted);
            padding: 0.9rem 0.6rem 0.4rem;
            opacity: 0.7;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.6rem 0.75rem;
            border-radius: var(--radius-sm);
            color: var(--muted);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: var(--transition);
            margin-bottom: 2px;
            position: relative;
        }
        .nav-link:hover {
            background: var(--accent-glow);
            color: var(--accent-hover);
        }
        .nav-link.active {
            background: var(--accent-glow);
            color: var(--accent-hover);
            font-weight: 600;
        }
        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 20%;
            bottom: 20%;
            width: 3px;
            background: linear-gradient(180deg, var(--accent), var(--accent2));
            border-radius: 0 3px 3px 0;
        }
        .nav-link .icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            opacity: 0.8;
        }
        .nav-link.active .icon { opacity: 1; }

        .sidebar-footer {
            padding: 1rem 0.75rem;
            border-top: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        /* ── Main content ── */
        .main { margin-left: 250px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

        /* ── Topbar ── */
        .topbar {
            background: var(--sidebar);
            border-bottom: 1px solid var(--border);
            padding: 0 2rem;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .topbar-left { display: flex; align-items: center; gap: 0.75rem; }
        .topbar-page-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text);
        }
        .topbar-breadcrumb {
            font-size: 0.78rem;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }
        .topbar-breadcrumb span { color: var(--muted); }
        .topbar-right { display: flex; align-items: center; gap: 0.75rem; }
        .topbar-admin-chip {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: 0.3rem 0.85rem 0.3rem 0.4rem;
            font-size: 0.8rem;
            color: var(--text);
            font-weight: 500;
        }
        .topbar-avatar {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        /* ── Content area ── */
        .content { padding: 2rem; flex: 1; }

        /* ── Cards ── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }
        .card-title { font-size: 1rem; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem; }

        /* ── Stats Grid ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(165px, 1fr));
            gap: 1rem;
            margin-bottom: 1.75rem;
        }
        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.25rem 1.35rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 3px;
            height: 100%;
            background: var(--stat-color, var(--accent));
            border-radius: 0;
        }
        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-sm);
            background: var(--stat-glow, var(--accent-glow));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }
        .stat-body { flex: 1; min-width: 0; }
        .stat-value { font-size: 1.8rem; font-weight: 800; color: var(--stat-color, var(--accent)); line-height: 1; }
        .stat-label { font-size: 0.75rem; color: var(--muted); margin-top: 0.3rem; font-weight: 500; }

        /* ── Tables ── */
        .table-wrap { overflow-x: auto; border-radius: var(--radius-sm); }
        table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        thead { position: sticky; top: 0; z-index: 1; }
        th {
            text-align: left;
            padding: 0.75rem 1rem;
            background: var(--th-bg);
            color: var(--muted);
            font-weight: 600;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }
        td {
            padding: 0.875rem 1rem;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            transition: background 0.12s;
        }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: var(--hover-bg); }

        /* ── Badges ── */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.2rem 0.65rem;
            border-radius: 999px;
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }
        .badge-active { background: var(--success-glow); color: var(--success); border: 1px solid rgba(16,185,129,0.2); }
        .badge-overdue { background: var(--danger-glow); color: var(--danger); border: 1px solid rgba(239,68,68,0.2); }
        .badge-returned { background: var(--accent-glow); color: var(--accent); border: 1px solid rgba(99,102,241,0.2); }
        .badge-success { background: var(--success-glow); color: var(--success); border: 1px solid rgba(16,185,129,0.2); }
        .badge-danger { background: var(--danger-glow); color: var(--danger); border: 1px solid rgba(239,68,68,0.2); }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1rem;
            border-radius: var(--radius-sm);
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: var(--transition);
            font-family: inherit;
            white-space: nowrap;
            outline: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: #fff;
            box-shadow: 0 3px 10px rgba(99,102,241,0.25);
        }
        .btn-primary:hover { filter: brightness(1.08); transform: translateY(-1px); box-shadow: 0 5px 15px rgba(99,102,241,0.35); }
        .btn-danger { background: var(--danger-glow); color: var(--danger); border: 1px solid rgba(239,68,68,0.25); }
        .btn-danger:hover { background: var(--danger); color: #fff; transform: translateY(-1px); }
        .btn-secondary {
            background: var(--surface2);
            color: var(--text);
            border: 1px solid var(--border);
        }
        .btn-secondary:hover { border-color: var(--accent); color: var(--accent); background: var(--accent-glow); }
        .btn-sm { padding: 0.35rem 0.75rem; font-size: 0.8rem; border-radius: 6px; }

        /* ── Forms ── */
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; font-size: 0.78rem; font-weight: 600; color: var(--muted); margin-bottom: 0.4rem; text-transform: uppercase; letter-spacing: 0.4px; }
        input[type=text], input[type=email], input[type=password], input[type=number], input[type=file], select, textarea {
            width: 100%;
            padding: 0.6rem 0.875rem;
            background: var(--input-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text);
            font-size: 0.875rem;
            outline: none;
            transition: var(--transition);
            font-family: inherit;
        }
        input:focus, select:focus, textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .form-error { color: var(--danger); font-size: 0.78rem; margin-top: 0.3rem; font-weight: 500; }

        /* ── Alerts ── */
        .alert { padding: 0.875rem 1rem; border-radius: var(--radius-sm); margin-bottom: 1rem; font-size: 0.875rem; border: 1px solid transparent; display: flex; align-items: center; gap: 0.5rem; }
        .alert-success { background: var(--success-glow); border-color: rgba(16,185,129,0.25); color: var(--success); }
        .alert-danger { background: var(--danger-glow); border-color: rgba(239,68,68,0.25); color: var(--danger); }

        /* ── Search bar ── */
        .search-bar { display: flex; gap: 0.5rem; margin-bottom: 1.25rem; flex-wrap: wrap; }
        .search-bar input { flex: 1; min-width: 200px; }

        /* ── Pagination ── */
        .pagination {
            display: flex;
            gap: 0.35rem;
            justify-content: center;
            margin-top: 1.5rem;
            flex-wrap: wrap;
        }
        .pagination a, .pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid var(--border);
            color: var(--text);
            padding: 0 0.5rem;
            transition: var(--transition);
            background: var(--surface);
        }
        .pagination a:hover {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
            transform: translateY(-1px);
        }
        .pagination .active span {
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border-color: var(--accent);
            color: #fff;
        }
        .pagination .disabled span { opacity: 0.3; background: transparent; cursor: default; }

        /* ── Modal ── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.65);
            backdrop-filter: blur(4px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .modal-overlay.open { display: flex; }
        .modal {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2rem;
            max-width: 480px;
            width: 100%;
            box-shadow: 0 24px 60px rgba(0,0,0,0.5);
            animation: modalIn 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }
        .modal-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; }
        .modal-body { color: var(--muted); font-size: 0.9rem; margin-bottom: 1.5rem; line-height: 1.6; }
        .modal-actions { display: flex; flex-direction: column; gap: 0.5rem; }
        .modal-actions .btn { justify-content: center; padding: 0.7rem; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main { margin-left: 0; }
            .form-grid { grid-template-columns: 1fr; }
            .content { padding: 1.25rem; }
            .topbar { padding: 0 1rem; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- Sidebar --}}
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">📚</div>
            Biblio<span>Tech</span>
        </div>
        <div class="sidebar-badge">🔑 Admin Panel</div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">Overview</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zm10 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/></svg>
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
        <button id="theme-toggle" class="btn btn-secondary" style="width:100%; justify-content:center; font-size:0.825rem;">
            <span class="theme-icon-light">☀️ Light Mode</span>
            <span class="theme-icon-dark" style="display:none;">🌙 Dark Mode</span>
        </button>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="btn btn-secondary" style="width:100%; justify-content:center; font-size:0.825rem;">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/></svg>
                Log Out
            </button>
        </form>
    </div>
</aside>

{{-- Main --}}
<div class="main">
    <header class="topbar">
        <div class="topbar-left">
            <div class="topbar-page-title">@yield('page-title', 'Dashboard')</div>
        </div>
        <div class="topbar-right">
            <div class="topbar-admin-chip">
                <div class="topbar-avatar">{{ mb_strtoupper(mb_substr(auth()->guard('admin')->user()->name ?? 'A', 0, 1)) }}</div>
                {{ auth()->guard('admin')->user()->name ?? 'Admin' }}
            </div>
        </div>
    </header>

    <main class="content">
        @if(session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">⚠ {{ session('error') }}</div>
        @endif
        @yield('content')
    </main>
</div>

<script>
const toggleBtn = document.getElementById('theme-toggle');
if (toggleBtn) {
    const lightIcon = toggleBtn.querySelector('.theme-icon-light');
    const darkIcon  = toggleBtn.querySelector('.theme-icon-dark');
    function updateTogglerUI(theme) {
        lightIcon.style.display = theme === 'light' ? 'none' : 'inline';
        darkIcon.style.display  = theme === 'light' ? 'inline' : 'none';
    }
    const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
    updateTogglerUI(currentTheme);
    toggleBtn.addEventListener('click', () => {
        const next = document.documentElement.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
        document.documentElement.setAttribute('data-theme', next);
        localStorage.setItem('theme', next);
        updateTogglerUI(next);
    });
}
</script>
@stack('scripts')
</body>
</html>
