@extends('layouts.app')
@section('title', 'Welcome to BiblioTech')

@push('styles')
<style>
    /* ─── Hero Landing ─── */
    .home-hero {
        position: relative;
        background: linear-gradient(135deg, #101030 0%, #090d16 100%);
        padding: 6rem 2rem 5rem;
        text-align: center;
        overflow: hidden;
        border-bottom: 1px solid var(--border);
    }
    .home-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at center, rgba(99, 102, 241, 0.2) 0%, transparent 60%);
        pointer-events: none;
    }
    .home-hero-inner {
        max-width: 800px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
    }
    .home-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--accent-glow);
        border: 1px solid rgba(99, 102, 241, 0.3);
        color: var(--accent);
        font-size: 0.8rem;
        font-weight: 700;
        padding: 0.35rem 1rem;
        border-radius: 999px;
        margin-bottom: 1.5rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .home-hero-title {
        font-size: clamp(2.25rem, 6vw, 4rem);
        font-weight: 800;
        line-height: 1.15;
        letter-spacing: -1.5px;
        margin-bottom: 1.25rem;
    }
    .home-hero-title span {
        background: linear-gradient(to right, var(--accent), var(--accent2));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .home-hero-subtitle {
        color: var(--muted);
        font-size: 1.15rem;
        line-height: 1.7;
        margin-bottom: 2.5rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    .home-hero-ctas {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    /* ─── Stats Bar ─── */
    .home-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1px;
        background: var(--border);
        margin-top: -1px;
        border-bottom: 1px solid var(--border);
    }
    .home-stat-item {
        background: var(--surface);
        padding: 2rem;
        text-align: center;
    }
    .home-stat-val {
        display: block;
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--accent);
        margin-bottom: 0.25rem;
    }
    .home-stat-lbl {
        display: block;
        font-size: 0.8rem;
        color: var(--muted);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ─── Highlight Features ─── */
    .section-title {
        text-align: center;
        margin-bottom: 3rem;
    }
    .section-title h2 {
        font-size: 1.75rem;
        font-weight: 800;
        letter-spacing: -0.5px;
        margin-bottom: 0.5rem;
    }
    .section-title p {
        color: var(--muted);
        font-size: 0.95rem;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 4rem;
    }
    .feature-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 2.25rem 2rem;
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .feature-card:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.3);
        box-shadow: var(--shadow-md);
    }
    .feature-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: var(--accent-glow);
        color: var(--accent);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .feature-card h3 {
        font-size: 1.1rem;
        font-weight: 700;
    }
    .feature-card p {
        font-size: 0.9rem;
        color: var(--muted);
        line-height: 1.6;
    }

    /* ─── Call to action banner ─── */
    .cta-banner {
        background: linear-gradient(135deg, var(--accent-glow) 0%, rgba(139, 92, 246, 0.05) 100%);
        border: 1px solid rgba(99, 102, 241, 0.25);
        border-radius: var(--radius);
        padding: 3.5rem;
        text-align: center;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    .cta-banner::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 80% 80%, rgba(139, 92, 246, 0.15) 0%, transparent 50%);
    }
    .cta-banner h2 {
        font-size: 1.85rem;
        font-weight: 800;
        margin-bottom: 0.75rem;
        letter-spacing: -0.5px;
    }
    .cta-banner p {
        color: var(--muted);
        font-size: 1.05rem;
        margin-bottom: 2rem;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }

    @media (max-width: 900px) {
        .features-grid { grid-template-columns: repeat(2, 1fr); }
        .home-stats { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 600px) {
        .features-grid { grid-template-columns: 1fr; }
        .home-stats { grid-template-columns: 1fr; }
        .cta-banner { padding: 2.25rem 1.5rem; }
    }
</style>
@endpush

@section('content')
{{-- Hero Section --}}
<section class="home-hero">
    <div class="home-hero-inner">
        <span class="home-hero-badge">📚 Discover Your Library Hub</span>
        <h1 class="home-hero-title">Welcome to <span>BiblioTech</span></h1>
        <p class="home-hero-subtitle">Simplify your reading life. Instantly search hundreds of book titles, track your active borrows, and manage returned history with absolute ease.</p>
        <div class="home-hero-ctas">
            <a href="{{ route('member.books.index') }}" class="btn btn-primary btn-lg" style="padding:0.75rem 1.75rem; font-size: 0.95rem;">Browse Books Catalog</a>
            @guest
                <a href="{{ route('register') }}" class="btn btn-secondary btn-lg" style="padding:0.75rem 1.75rem; font-size: 0.95rem;">Create Account</a>
            @else
                <a href="{{ route('member.dashboard') }}" class="btn btn-secondary btn-lg" style="padding:0.75rem 1.75rem; font-size: 0.95rem;">Go to Dashboard</a>
            @endguest
        </div>
    </div>
</section>

{{-- Stats Bar --}}
<section class="home-stats">
    <div class="home-stat-item">
        <span class="home-stat-val">14 Days</span>
        <span class="home-stat-lbl">Loan Duration</span>
    </div>
    <div class="home-stat-item">
        <span class="home-stat-val">2 Days</span>
        <span class="home-stat-lbl">Grace Period</span>
    </div>
    <div class="home-stat-item">
        <span class="home-stat-val">5 MAD</span>
        <span class="home-stat-lbl">Daily Late Fee</span>
    </div>
    <div class="home-stat-item">
        <span class="home-stat-val">200 MAD</span>
        <span class="home-stat-lbl">Max Penalty Cap</span>
    </div>
</section>

{{-- Features Section --}}
<div class="container">
    <div class="section-title">
        <h2>Built for Passionate Readers</h2>
        <p class="mt-2">Intuitive controls, rich visuals, and smart utility at your fingertips</p>
    </div>

    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">🔍</div>
            <h3>Intelligent Search</h3>
            <p>Explore titles, authors, and genres in real-time. Use quick filters to find books that are immediately available.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">📊</div>
            <h3>Simple Tracking</h3>
            <p>Your dashboard aggregates borrowed items, remaining days, overdue status alerts, and exact penalty accumulations.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🛡️</div>
            <h3>Fair Fines Policy</h3>
            <p>Transparent return conditions with a cap of 200 MAD per book. Check exact details dynamically in your panel.</p>
        </div>
    </div>

    {{-- Call To Action Section --}}
    @guest
    <div class="cta-banner">
        <h2>Start your borrowing journey today</h2>
        <p>Set up a free member profile in less than 30 seconds to begin borrowing catalog books immediately.</p>
        <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 0.75rem 1.75rem;">Register Now</a>
    </div>
    @endguest
</div>
@endsection
