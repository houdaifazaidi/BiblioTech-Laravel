<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="BiblioTech — Your Digital Library">
    <title>@yield('title', 'Library') — BiblioTech</title>
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
            --nav-bg: rgba(9, 13, 22, 0.8);
            --header-bg: linear-gradient(135deg, #101030 0%, #090d16 100%);
            --input-bg: rgba(255, 255, 255, 0.04);
            --btn-secondary-bg: rgba(255, 255, 255, 0.06);
        }

        [data-theme="light"] {
            --bg: #f8fafc;
            --surface: #ffffff;
            --surface2: #f1f5f9;
            --border: #e2e8f0;
            --text: #0f172a;
            --muted: #64748b;
            --nav-bg: rgba(255, 255, 255, 0.9);
            --header-bg: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%);
            --accent-glow: rgba(99, 102, 241, 0.10);
            --success-glow: rgba(16, 185, 129, 0.10);
            --danger-glow: rgba(239, 68, 68, 0.10);
            --warning-glow: rgba(245, 158, 11, 0.10);
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 6px 16px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 12px 32px rgba(0, 0, 0, 0.12);
            --input-bg: #f1f5f9;
            --btn-secondary-bg: rgba(0, 0, 0, 0.04);
        }

        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; display: flex; flex-direction: column; -webkit-font-smoothing: antialiased; }

        /* ── Navbar ── */
        .navbar {
            background: var(--nav-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 200;
            padding: 0 2rem;
        }
        .nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            height: 68px;
            gap: 0.25rem;
        }
        .nav-brand {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--accent);
            text-decoration: none;
            letter-spacing: -0.75px;
            margin-right: auto;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            transition: var(--transition);
        }
        .nav-brand-icon {
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.35);
        }
        .nav-brand span { color: var(--text); }
        .nav-brand:hover { opacity: 0.85; }

        .nav-link {
            color: var(--muted);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            padding: 0.5rem 0.85rem;
            border-radius: 8px;
            transition: var(--transition);
            position: relative;
            white-space: nowrap;
        }
        .nav-link:hover { background: var(--accent-glow); color: var(--accent); }
        .nav-link.active {
            color: var(--accent);
            background: var(--accent-glow);
            font-weight: 600;
        }
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 2px;
            background: var(--accent);
            border-radius: 2px;
        }

        .nav-btn {
            padding: 0.5rem 1.1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition);
            border: none;
            outline: none;
            white-space: nowrap;
        }
        .nav-btn-outline {
            border: 1px solid var(--border);
            color: var(--text);
            background: transparent;
        }
        .nav-btn-outline:hover { border-color: var(--accent); color: var(--accent); background: var(--accent-glow); }
        .nav-btn-solid {
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: #fff;
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.35);
        }
        .nav-btn-solid:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(99, 102, 241, 0.45); }

        /* ── Page Header / Hero ── */
        .page-header {
            background: var(--header-bg);
            padding: 4.5rem 2rem 4rem;
            text-align: center;
            border-bottom: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }
        .page-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at center top, var(--accent-glow) 0%, transparent 65%);
            pointer-events: none;
        }
        .page-header h1 {
            font-size: clamp(1.75rem, 4vw, 2.5rem);
            font-weight: 800;
            margin-bottom: 0.75rem;
            letter-spacing: -0.75px;
            position: relative;
            z-index: 1;
        }
        .page-header p {
            color: var(--muted);
            font-size: 1.05rem;
            max-width: 600px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        /* ── Main container ── */
        .container { max-width: 1200px; margin: 0 auto; padding: 2.5rem 2rem; }
        main { flex: 1; }

        /* ── Cards ── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 2rem;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
        }
        .card-title {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            letter-spacing: -0.25px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* ── Auth Pages ── */
        .auth-wrapper {
            min-height: calc(100vh - 68px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }
        .auth-wrapper::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 50% 0%, rgba(99, 102, 241, 0.12) 0%, transparent 60%);
            pointer-events: none;
        }
        .auth-wrapper::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.06) 0%, transparent 70%);
            bottom: -150px;
            right: -100px;
            pointer-events: none;
        }
        .auth-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2.75rem 2.5rem;
            width: 100%;
            max-width: 460px;
            box-shadow: var(--shadow-lg);
            position: relative;
            z-index: 1;
            animation: authCardIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        @keyframes authCardIn {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .auth-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent), var(--accent2));
            border-radius: 20px 20px 0 0;
        }
        .auth-logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.75rem;
        }
        .auth-logo-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.35);
        }
        .auth-logo-text {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--accent);
            letter-spacing: -0.5px;
        }
        .auth-logo-text span { color: var(--text); }
        .auth-title {
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 0.35rem;
        }
        .auth-subtitle {
            font-size: 0.9rem;
            color: var(--muted);
            margin-bottom: 2rem;
        }

        /* ── Book Grid ── */
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
            gap: 1.75rem;
        }
        .book-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            height: 100%;
            box-shadow: var(--shadow-sm);
            cursor: pointer;
        }
        .book-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(99, 102, 241, 0.4);
        }
        .book-cover-wrap {
            position: relative;
            width: 100%;
            aspect-ratio: 2/3;
            overflow: hidden;
            background: var(--surface2);
        }
        .book-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.4s ease;
        }
        .book-card:hover .book-cover { transform: scale(1.06); }
        .book-info { padding: 1.1rem; display: flex; flex-direction: column; flex-grow: 1; gap: 0.3rem; }
        .book-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text);
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .book-author { font-size: 0.78rem; color: var(--muted); font-weight: 500; }
        .book-genre {
            display: inline-block;
            align-self: flex-start;
            font-size: 0.67rem;
            font-weight: 700;
            padding: 0.22rem 0.55rem;
            border-radius: 999px;
            background: var(--accent-glow);
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid rgba(99, 102, 241, 0.2);
        }
        .book-availability {
            font-size: 0.78rem;
            font-weight: 600;
            margin-top: auto;
            padding-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }
        .book-availability::before {
            content: '';
            display: inline-block;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .available { color: var(--success); }
        .available::before { background: var(--success); box-shadow: 0 0 0 3px var(--success-glow); }
        .unavailable { color: var(--danger); }
        .unavailable::before { background: var(--danger); }

        /* ── Filters ── */
        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-bottom: 2rem;
            align-items: center;
            background: var(--surface);
            padding: 1.25rem 1.5rem;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }
        .filters input[type=text], .filters select {
            padding: 0.6rem 1rem;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text);
            font-size: 0.875rem;
            outline: none;
            font-family: inherit;
            transition: var(--transition);
        }
        .filters input[type=text]:focus, .filters select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }
        .filters input[type=text] { flex: 1; min-width: 220px; }
        .filter-label {
            font-size: 0.85rem;
            color: var(--muted);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }
        .filter-label input[type=checkbox] {
            width: 16px;
            height: 16px;
            accent-color: var(--accent);
            cursor: pointer;
            flex-shrink: 0;
        }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: var(--transition);
            outline: none;
            font-family: inherit;
            white-space: nowrap;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: #fff;
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.25);
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4); filter: brightness(1.05); }
        .btn-danger { background: var(--danger-glow); color: var(--danger); border: 1px solid rgba(239, 68, 68, 0.2); }
        .btn-danger:hover { background: var(--danger); color: #fff; transform: translateY(-1px); }
        .btn-success { background: var(--success-glow); color: var(--success); border: 1px solid rgba(16, 185, 129, 0.2); }
        .btn-success:hover { background: var(--success); color: #fff; transform: translateY(-1px); }
        .btn-secondary {
            background: var(--btn-secondary-bg);
            color: var(--text);
            border: 1px solid var(--border);
        }
        .btn-secondary:hover { background: var(--surface2); border-color: var(--accent); color: var(--accent); }
        .btn-sm { padding: 0.4rem 0.85rem; font-size: 0.8rem; border-radius: 7px; }
        .btn:disabled { opacity: 0.4; cursor: not-allowed; transform: none !important; box-shadow: none !important; filter: none !important; }

        /* ── Badges ── */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.22rem 0.65rem;
            border-radius: 999px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.75px;
        }
        .badge-active { background: var(--success-glow); color: var(--success); border: 1px solid rgba(16, 185, 129, 0.2); }
        .badge-overdue { background: var(--danger-glow); color: var(--danger); border: 1px solid rgba(239, 68, 68, 0.2); }
        .badge-returned { background: var(--accent-glow); color: var(--accent); border: 1px solid rgba(99, 102, 241, 0.2); }
        .badge-force_returned { background: var(--warning-glow); color: var(--warning); border: 1px solid rgba(245, 158, 11, 0.2); }

        /* ── Loans list ── */
        .loans-list { display: flex; flex-direction: column; gap: 1rem; }
        .loan-card {
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.5rem;
            display: flex;
            gap: 1.5rem;
            align-items: center;
            transition: var(--transition);
        }
        .loan-card:hover { border-color: rgba(99, 102, 241, 0.3); box-shadow: var(--shadow-sm); }
        .loan-cover {
            width: 65px;
            height: 97px;
            object-fit: cover;
            border-radius: 8px;
            flex-shrink: 0;
            background: var(--surface);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        .loan-details { flex: 1; }
        .loan-title { font-weight: 700; font-size: 1rem; color: var(--text); line-height: 1.35; }
        .loan-meta { font-size: 0.825rem; color: var(--muted); margin-top: 0.3rem; font-weight: 500; }
        .loan-penalty {
            margin-top: 0.5rem;
            font-size: 0.825rem;
            color: var(--danger);
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: var(--danger-glow);
            padding: 0.3rem 0.75rem;
            border-radius: 8px;
            border: 1px solid rgba(239, 68, 68, 0.15);
        }
        .loan-actions { display: flex; flex-direction: column; gap: 0.6rem; align-items: flex-end; flex-shrink: 0; }

        /* ── Alerts ── */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            font-weight: 500;
            border: 1px solid transparent;
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
        }
        .alert-success { background: var(--success-glow); border-color: rgba(16, 185, 129, 0.25); color: var(--success); }
        .alert-danger { background: var(--danger-glow); border-color: rgba(239, 68, 68, 0.25); color: var(--danger); }

        /* ── Forms ── */
        .form-group { margin-bottom: 1.5rem; }
        label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        input[type=text], input[type=email], input[type=password], input[type=number], textarea, select {
            width: 100%;
            padding: 0.7rem 1rem;
            background: var(--input-bg);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text);
            font-size: 0.9rem;
            outline: none;
            transition: var(--transition);
            font-family: inherit;
        }
        input:focus, textarea:focus, select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-glow);
            background: var(--surface);
        }
        .form-error { color: var(--danger); font-size: 0.82rem; margin-top: 0.4rem; font-weight: 500; }

        /* ── Pagination ── */
        .pagination {
            display: flex;
            gap: 0.35rem;
            justify-content: center;
            margin-top: 2.5rem;
            flex-wrap: wrap;
        }
        .pagination a, .pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            height: 38px;
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
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
            transform: translateY(-1px);
        }
        .pagination .active {
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border-color: var(--accent);
            color: #fff;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }
        .pagination .disabled { opacity: 0.35; background: transparent; cursor: default; }

        /* ── Footer ── */
        .site-footer {
            background: var(--surface);
            border-top: 1px solid var(--border);
            padding: 2rem;
            margin-top: auto;
        }
        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .footer-brand {
            font-size: 1rem;
            font-weight: 800;
            color: var(--accent);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .footer-brand span { color: var(--text); }
        .footer-tagline { font-size: 0.8rem; color: var(--muted); margin-top: 0.2rem; }
        .footer-links { display: flex; gap: 1.5rem; }
        .footer-links a {
            font-size: 0.82rem;
            color: var(--muted);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.15s;
        }
        .footer-links a:hover { color: var(--accent); }
        .footer-copy { font-size: 0.78rem; color: var(--muted); }

        /* ── Scroll to top ── */
        #scroll-top {
            position: fixed;
            bottom: 1.75rem;
            right: 1.75rem;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: #fff;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(99, 102, 241, 0.4);
            transition: var(--transition);
            z-index: 300;
            opacity: 0;
            transform: translateY(10px);
            pointer-events: none;
        }
        #scroll-top.visible { opacity: 1; transform: translateY(0); pointer-events: auto; }
        #scroll-top:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(99, 102, 241, 0.5); }
        #scroll-top svg { width: 18px; height: 18px; }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .navbar { padding: 0 1rem; }
            .container { padding: 1.5rem 1rem; }
            .loan-card { flex-direction: column; align-items: flex-start; gap: 1rem; }
            .loan-actions { flex-direction: row; align-items: center; justify-content: space-between; width: 100%; }
            .auth-card { padding: 2rem 1.5rem; }
            .footer-inner { flex-direction: column; align-items: flex-start; }
        }
        @media (max-width: 600px) {
            .books-grid { grid-template-columns: repeat(2, 1fr); gap: 1rem; }
            .filters { flex-direction: column; align-items: stretch; }
            .filters input[type=text] { min-width: unset; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- Navbar --}}
<nav class="navbar">
    <div class="nav-inner">
        <a href="{{ route('member.books.index') }}" class="nav-brand">
            <div class="nav-brand-icon">🏛️</div>
            Biblio<span>Tech</span>
        </a>
        <a href="{{ route('member.books.index') }}" class="nav-link {{ request()->routeIs('member.books.*') ? 'active' : '' }}">Browse</a>
        <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a>

        <button id="theme-toggle" class="nav-btn nav-btn-outline" style="padding: 0.4rem 0.6rem; font-size: 1rem; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; margin-left: 0.5rem;" title="Toggle theme">
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

{{-- Flash messages --}}
<main>
    @if(session('success'))
        <div class="container" style="padding-bottom:0;">
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        </div>
    @endif
    @if(session('error'))
        <div class="container" style="padding-bottom:0;">
            <div class="alert alert-danger">⚠ {{ session('error') }}</div>
        </div>
    @endif
    @yield('content')
</main>

{{-- Footer --}}
<footer class="site-footer">
    <div class="footer-inner">
        <div>
            <a href="{{ route('member.books.index') }}" class="footer-brand">
                🏛️ Biblio<span>Tech</span>
            </a>
            <div class="footer-tagline">Your smart digital library</div>
        </div>
        <nav class="footer-links">
            <a href="{{ route('member.books.index') }}">Browse Books</a>
            <a href="{{ route('about') }}">About</a>
            @auth('web')
                <a href="{{ route('member.dashboard') }}">My Dashboard</a>
            @endauth
        </nav>
        <div class="footer-copy">&copy; {{ date('Y') }} BiblioTech</div>
    </div>
</footer>

{{-- Scroll to top --}}
<button id="scroll-top" aria-label="Scroll to top">
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/></svg>
</button>

<script>
// Theme toggle
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

// Scroll to top
const scrollBtn = document.getElementById('scroll-top');
window.addEventListener('scroll', () => {
    scrollBtn.classList.toggle('visible', window.scrollY > 300);
}, { passive: true });
scrollBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
</script>
@stack('scripts')
</body>
</html>
