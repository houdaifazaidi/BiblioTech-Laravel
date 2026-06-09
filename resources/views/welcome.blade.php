@extends('layouts.app')
@section('title', 'Welcome to BiblioTech')

@push('styles')
<style>
/* ─── Hero Landing ─── */
.home-hero {
    position: relative;
    background: var(--header-bg);
    padding: 6.5rem 2rem 5.5rem;
    text-align: center;
    overflow: hidden;
    border-bottom: 1px solid var(--border);
}
.home-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at 50% -20%, rgba(99, 102, 241, 0.28) 0%, transparent 60%);
    pointer-events: none;
}
/* decorative orbs */
.home-hero::after {
    content: '';
    position: absolute;
    bottom: -80px;
    right: 10%;
    width: 300px;
    height: 300px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(139,92,246,0.12) 0%, transparent 70%);
    pointer-events: none;
}
.hero-orb-left {
    position: absolute;
    top: 10%;
    left: -60px;
    width: 250px;
    height: 250px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(99,102,241,0.08) 0%, transparent 70%);
    pointer-events: none;
}
.home-hero-inner {
    max-width: 820px;
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
    padding: 0.4rem 1.1rem;
    border-radius: 999px;
    margin-bottom: 1.75rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    animation: badgeFadeIn 0.5s ease 0.1s both;
}
@keyframes badgeFadeIn { from { opacity:0; transform:translateY(-8px); } to { opacity:1; transform:none; } }

.home-hero-title {
    font-size: clamp(2.5rem, 7vw, 4.25rem);
    font-weight: 800;
    line-height: 1.12;
    letter-spacing: -2px;
    margin-bottom: 1.25rem;
    animation: heroTitleIn 0.6s ease 0.2s both;
}
@keyframes heroTitleIn { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:none; } }

.home-hero-title span {
    background: linear-gradient(135deg, var(--accent), var(--accent2), #a78bfa);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.home-hero-subtitle {
    color: var(--muted);
    font-size: 1.15rem;
    line-height: 1.75;
    margin-bottom: 2.75rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    animation: heroSubIn 0.6s ease 0.35s both;
}
@keyframes heroSubIn { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:none; } }

.home-hero-ctas {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
    animation: ctaIn 0.6s ease 0.5s both;
}
@keyframes ctaIn { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:none; } }

/* ─── Stats Bar ─── */
.home-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    background: var(--surface);
    border-bottom: 1px solid var(--border);
}
.home-stat-item {
    padding: 1.75rem 1rem;
    text-align: center;
    position: relative;
}
.home-stat-item + .home-stat-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 20%;
    bottom: 20%;
    width: 1px;
    background: var(--border);
}
.home-stat-val {
    display: block;
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--accent);
    margin-bottom: 0.25rem;
    letter-spacing: -0.5px;
}
.home-stat-lbl {
    display: block;
    font-size: 0.78rem;
    color: var(--muted);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* ─── Section header ─── */
.section-title { text-align: center; margin-bottom: 3rem; }
.section-title h2 {
    font-size: 1.85rem;
    font-weight: 800;
    letter-spacing: -0.5px;
    margin-bottom: 0.5rem;
}
.section-title p { color: var(--muted); font-size: 0.95rem; }

/* ─── Features Grid ─── */
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
    position: relative;
    overflow: hidden;
}
.feature-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--accent), var(--accent2));
    opacity: 0;
    transition: opacity 0.25s;
}
.feature-card:hover {
    transform: translateY(-6px);
    border-color: rgba(99, 102, 241, 0.3);
    box-shadow: var(--shadow-lg);
}
.feature-card:hover::before { opacity: 1; }

.feature-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    background: linear-gradient(135deg, var(--accent-glow), rgba(139,92,246,0.08));
    border: 1px solid rgba(99,102,241,0.15);
    color: var(--accent);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.55rem;
    transition: var(--transition);
}
.feature-card:hover .feature-icon {
    background: linear-gradient(135deg, rgba(99,102,241,0.2), rgba(139,92,246,0.15));
    transform: scale(1.05);
}
.feature-card h3 { font-size: 1.05rem; font-weight: 700; }
.feature-card p { font-size: 0.9rem; color: var(--muted); line-height: 1.65; }

/* ─── Call to action banner ─── */
.cta-banner {
    background: linear-gradient(135deg, var(--accent-glow) 0%, rgba(139, 92, 246, 0.06) 100%);
    border: 1px solid rgba(99, 102, 241, 0.22);
    border-radius: 20px;
    padding: 4rem 2rem;
    text-align: center;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}
.cta-banner::before {
    content: '';
    position: absolute;
    top: -50%;
    left: 50%;
    transform: translateX(-50%);
    width: 400px;
    height: 400px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(99,102,241,0.12) 0%, transparent 60%);
}
.cta-banner::after {
    content: '';
    position: absolute;
    bottom: -30%;
    right: 5%;
    width: 300px;
    height: 300px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(139,92,246,0.1) 0%, transparent 60%);
}
.cta-banner h2 {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 0.75rem;
    letter-spacing: -0.5px;
    position: relative;
    z-index: 1;
}
.cta-banner p {
    color: var(--muted);
    font-size: 1.05rem;
    margin-bottom: 2rem;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
    position: relative;
    z-index: 1;
}
.cta-banner .btn { position: relative; z-index: 1; }

@media (max-width: 900px) {
    .features-grid { grid-template-columns: repeat(2, 1fr); }
    .home-stats { grid-template-columns: repeat(2, 1fr); }
    .home-stat-item:nth-child(3)::before { display: none; }
}
@media (max-width: 600px) {
    .features-grid { grid-template-columns: 1fr; }
    .home-stats { grid-template-columns: repeat(2, 1fr); }
    .cta-banner { padding: 2.5rem 1.5rem; }
    .home-hero { padding: 4rem 1.5rem 3.5rem; }
}
</style>
@endpush

@section('content')

{{-- Hero Section --}}
<section class="home-hero">
    <div class="hero-orb-left"></div>
    <div class="home-hero-inner">
        <span class="home-hero-badge">🏛️ Your Digital Library Hub</span>
        <h1 class="home-hero-title">Welcome to <span>BiblioTech</span></h1>
        <p class="home-hero-subtitle">Simplify your reading life. Instantly search hundreds of book titles, track your active borrows, and manage your entire reading history with absolute ease.</p>
        <div class="home-hero-ctas">
            <a href="{{ route('member.books.index') }}" class="btn btn-primary" style="padding:0.8rem 2rem; font-size:1rem;">Browse Books Catalog</a>
            @guest
                <a href="{{ route('register') }}" class="btn btn-secondary" style="padding:0.8rem 2rem; font-size:1rem;">Create Free Account</a>
            @else
                <a href="{{ route('member.dashboard') }}" class="btn btn-secondary" style="padding:0.8rem 2rem; font-size:1rem;">Go to Dashboard</a>
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
        <p>Intuitive controls, rich visuals, and smart utilities at your fingertips</p>
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
        <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 0.8rem 2rem; font-size: 1rem;">Register Now — It's Free</a>
    </div>
    @endguest
</div>
@endsection
