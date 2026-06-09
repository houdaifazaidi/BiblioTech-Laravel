@extends('layouts.app')
@section('title', 'About BiblioTech')
@section('description', 'Learn about BiblioTech — your digital library management platform. Understand how borrowing, returns, and the penalty system work.')

@push('styles')
<style>
/* ─── Hero ─── */
.about-hero {
    background: var(--header-bg);
    padding: 5rem 2rem 4rem;
    text-align: center;
    position: relative;
    overflow: hidden;
    border-bottom: 1px solid var(--border);
}
.about-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at 60% 0%, rgba(99,102,241,0.22) 0%, transparent 60%);
    pointer-events: none;
}
.about-hero-inner { max-width: 720px; margin: 0 auto; position: relative; z-index: 1; }
.about-hero-badge {
    display: inline-block;
    background: var(--accent-glow);
    border: 1px solid rgba(99,102,241,0.3);
    color: var(--accent);
    font-size: 0.8rem;
    font-weight: 600;
    padding: 0.35rem 1rem;
    border-radius: 999px;
    margin-bottom: 1.5rem;
    letter-spacing: 0.5px;
}
.about-hero-title {
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 800;
    margin-bottom: 1rem;
    line-height: 1.15;
    letter-spacing: -1px;
}
.about-hero-subtitle {
    color: var(--muted);
    font-size: 1.1rem;
    line-height: 1.7;
    margin-bottom: 2rem;
    max-width: 580px;
    margin-left: auto;
    margin-right: auto;
}
.about-hero-cta { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
.btn-outline-hero {
    border: 1px solid var(--border);
    color: var(--text);
    background: var(--btn-secondary-bg, rgba(255,255,255,0.06));
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.875rem;
    text-decoration: none;
    transition: all 0.2s;
    padding: 0.6rem 1.2rem;
    display: inline-flex;
    align-items: center;
}
.btn-outline-hero:hover { background: var(--surface2); border-color: var(--accent); color: var(--accent); }

/* ─── Stats bar ─── */
.about-stats-bar {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding: 1.5rem 2rem;
}
.about-stats-inner {
    max-width: 800px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1.5rem;
    flex-wrap: wrap;
}
.about-stat { text-align: center; }
.about-stat-value { display: block; font-size: 1.5rem; font-weight: 800; color: var(--accent); }
.about-stat-label { display: block; font-size: 0.75rem; color: var(--muted); margin-top: 0.1rem; }
.about-stat-divider { width: 1px; height: 40px; background: var(--border); }

/* ─── Sections ─── */
.about-section { margin-bottom: 4rem; }
.about-section-header { text-align: center; margin-bottom: 2.5rem; }
.about-section-header h2 { font-size: 1.75rem; font-weight: 800; margin-bottom: 0.5rem; letter-spacing: -0.4px; }
.about-section-header p { color: var(--muted); font-size: 0.95rem; }

/* ─── Steps ─── */
.about-steps {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    flex-wrap: wrap;
    justify-content: center;
}
.about-step {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 2rem 1.5rem;
    flex: 1;
    min-width: 220px;
    max-width: 280px;
    text-align: center;
    position: relative;
    transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
    box-shadow: var(--shadow-sm);
}
.about-step:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 40px rgba(99,102,241,0.15);
    border-color: rgba(99,102,241,0.35);
}
.about-step-num {
    position: absolute;
    top: -12px;
    left: 1.25rem;
    background: linear-gradient(135deg, var(--accent), var(--accent2));
    color: #fff;
    font-size: 0.65rem;
    font-weight: 700;
    padding: 0.2rem 0.6rem;
    border-radius: 999px;
    letter-spacing: 0.5px;
}
.about-step-icon { font-size: 2.5rem; margin-bottom: 1rem; }
.about-step h3 { font-size: 1rem; font-weight: 700; margin-bottom: 0.5rem; }
.about-step p { font-size: 0.875rem; color: var(--muted); line-height: 1.6; }
.about-step-arrow { font-size: 1.5rem; color: var(--muted); align-self: center; padding: 0 0.25rem; }

/* ─── Penalty grid ─── */
.about-penalty-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
    gap: 1.25rem;
    margin-bottom: 2rem;
}
.about-penalty-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 1.75rem;
    border-top: 3px solid;
    box-shadow: var(--shadow-sm);
    transition: transform 0.2s;
}
.about-penalty-card:hover { transform: translateY(-3px); }
.about-penalty-card--info  { border-top-color: var(--accent); }
.about-penalty-card--warning { border-top-color: var(--warning); }
.about-penalty-card--danger  { border-top-color: var(--danger); }
.about-penalty-card--success { border-top-color: var(--success); }
.about-penalty-icon { font-size: 2rem; margin-bottom: 1rem; }
.about-penalty-card h3 { font-size: 1rem; font-weight: 700; margin-bottom: 0.5rem; }
.about-penalty-card p { font-size: 0.875rem; color: var(--muted); line-height: 1.6; }
.about-penalty-card strong { color: var(--text); }

/* ─── Timeline ─── */
.about-timeline-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 2rem;
    box-shadow: var(--shadow-sm);
}
.about-timeline-card h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; }
.about-timeline { display: flex; gap: 0.5rem; margin-bottom: 2rem; flex-wrap: wrap; }
.about-tl-segment { flex: 1; min-width: 110px; text-align: center; }
.about-tl-label { font-size: 0.7rem; font-weight: 600; color: var(--muted); margin-bottom: 0.4rem; text-transform: uppercase; letter-spacing: 0.5px; }
.about-tl-bar { height: 10px; border-radius: 5px; margin-bottom: 0.4rem; }
.about-tl-green .about-tl-bar { background: var(--success); box-shadow: 0 0 8px rgba(16,185,129,0.3); }
.about-tl-yellow .about-tl-bar { background: var(--warning); box-shadow: 0 0 8px rgba(245,158,11,0.3); }
.about-tl-red .about-tl-bar { background: var(--danger); box-shadow: 0 0 8px rgba(239,68,68,0.3); }
.about-tl-desc { font-size: 0.75rem; color: var(--muted); }
.about-penalty-example {
    border-top: 1px solid var(--border);
    padding-top: 1.25rem;
    display: flex;
    flex-direction: column;
    gap: 0.65rem;
}
.about-pe-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.875rem;
    color: var(--muted);
    padding: 0.4rem 0;
}
.about-pe-row + .about-pe-row { border-top: 1px solid var(--border); }
.about-pe-row strong { color: var(--danger); }

/* ─── Features grid ─── */
.about-features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.25rem;
}
.about-feature {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 1.75rem;
    transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
    box-shadow: var(--shadow-sm);
}
.about-feature:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 30px rgba(99,102,241,0.12);
    border-color: rgba(99,102,241,0.25);
}
.about-feature-icon {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    background: var(--accent-glow);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    margin-bottom: 1rem;
    border: 1px solid rgba(99,102,241,0.15);
}
.about-feature h3 { font-size: 1rem; font-weight: 700; margin-bottom: 0.4rem; }
.about-feature p { font-size: 0.875rem; color: var(--muted); line-height: 1.6; }

/* ─── FAQ ─── */
.about-faq { display: flex; flex-direction: column; gap: 0.5rem; }
.about-faq-item {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 10px;
    overflow: hidden;
    transition: border-color 0.2s;
}
.about-faq-item[open] { border-color: rgba(99,102,241,0.3); }
.about-faq-item summary {
    padding: 1.1rem 1.5rem;
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    list-style: none;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: background 0.15s;
    user-select: none;
}
.about-faq-item summary::-webkit-details-marker { display: none; }
.about-faq-item summary:hover { background: var(--accent-glow); }
.about-faq-item summary::after {
    content: '+';
    color: var(--accent);
    font-size: 1.3rem;
    font-weight: 300;
    transition: transform 0.2s;
    flex-shrink: 0;
}
.about-faq-item[open] summary::after { transform: rotate(45deg); }
.about-faq-item p { padding: 0 1.5rem 1.25rem; color: var(--muted); font-size: 0.9rem; line-height: 1.7; }

/* ─── CTA section ─── */
.about-cta-section {
    background: linear-gradient(135deg, var(--accent-glow) 0%, rgba(139,92,246,0.08) 100%);
    border: 1px solid rgba(99,102,241,0.2);
    border-radius: 20px;
    padding: 3.5rem 2rem;
    text-align: center;
    margin-bottom: 4rem;
    position: relative;
    overflow: hidden;
}
.about-cta-section::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 80% 80%, rgba(139,92,246,0.12) 0%, transparent 50%);
    pointer-events: none;
}
.about-cta-section h2 { font-size: 2rem; font-weight: 800; margin-bottom: 0.75rem; letter-spacing: -0.5px; position: relative; }
.about-cta-section p { color: var(--muted); margin-bottom: 2rem; font-size: 1rem; max-width: 500px; margin-left: auto; margin-right: auto; position: relative; }
.about-cta-buttons { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; position: relative; }

@media (max-width: 600px) {
    .about-step-arrow { display: none; }
    .about-hero { padding: 3rem 1.5rem; }
    .about-stats-inner { gap: 1rem; }
    .about-stat-divider { display: none; }
}
</style>
@endpush

@section('content')

{{-- Hero --}}
<div class="about-hero">
    <div class="about-hero-inner">
        <div class="about-hero-badge">🏛️ About BiblioTech</div>
        <h1 class="about-hero-title">Your Smart Digital Library</h1>
        <p class="about-hero-subtitle">BiblioTech is a modern library management system built to make borrowing, returning, and discovering books simple, transparent, and enjoyable.</p>
        <div class="about-hero-cta">
            <a href="{{ route('member.books.index') }}" class="btn btn-primary" style="padding:0.7rem 1.75rem;font-size:1rem;">Browse the Catalog</a>
            @guest('web')
                <a href="{{ route('register') }}" class="btn-outline-hero" style="padding:0.7rem 1.75rem;font-size:1rem;">Create Free Account</a>
            @endguest
        </div>
    </div>
</div>

{{-- Stats bar --}}
<div class="about-stats-bar">
    <div class="about-stats-inner">
        <div class="about-stat">
            <span class="about-stat-value">14</span>
            <span class="about-stat-label">Days loan period</span>
        </div>
        <div class="about-stat-divider"></div>
        <div class="about-stat">
            <span class="about-stat-value">5 MAD</span>
            <span class="about-stat-label">Per day (after grace)</span>
        </div>
        <div class="about-stat-divider"></div>
        <div class="about-stat">
            <span class="about-stat-value">200 MAD</span>
            <span class="about-stat-label">Max penalty cap</span>
        </div>
        <div class="about-stat-divider"></div>
        <div class="about-stat">
            <span class="about-stat-value">2</span>
            <span class="about-stat-label">Grace days before fee</span>
        </div>
    </div>
</div>

<div class="container">

    {{-- How it works section --}}
    <section class="about-section">
        <div class="about-section-header">
            <h2>How It Works</h2>
            <p>Three simple steps to get started with your library experience</p>
        </div>
        <div class="about-steps">
            <div class="about-step">
                <div class="about-step-num">01</div>
                <div class="about-step-icon">👤</div>
                <h3>Create an Account</h3>
                <p>Sign up for free with your name and email. Your account gives you access to the full catalog and loan history.</p>
            </div>
            <div class="about-step-arrow">→</div>
            <div class="about-step">
                <div class="about-step-num">02</div>
                <div class="about-step-icon">📖</div>
                <h3>Browse &amp; Borrow</h3>
                <p>Browse hundreds of books across all genres. Click any available book and borrow it with a single click.</p>
            </div>
            <div class="about-step-arrow">→</div>
            <div class="about-step">
                <div class="about-step-num">03</div>
                <div class="about-step-icon">↩️</div>
                <h3>Return on Time</h3>
                <p>Return before your 14-day deadline and enjoy your next book. Track everything from your personal dashboard.</p>
            </div>
        </div>
    </section>

    {{-- Penalty system section --}}
    <section class="about-section">
        <div class="about-section-header">
            <h2>📋 The Penalty System</h2>
            <p>Late returns incur a small daily fee — here's everything you need to know</p>
        </div>
        <div class="about-penalty-grid">
            <div class="about-penalty-card about-penalty-card--info">
                <div class="about-penalty-icon">⏱️</div>
                <h3>Loan Duration</h3>
                <p>Every book borrowed gets a <strong>14-day loan period</strong> starting from the day of borrowing. Your due date is clearly shown in your dashboard.</p>
            </div>
            <div class="about-penalty-card about-penalty-card--warning">
                <div class="about-penalty-icon">🕐</div>
                <h3>Grace Period</h3>
                <p>We give you a <strong>2-day grace period</strong> after your due date, completely free of charge. Penalties only start on day 3.</p>
            </div>
            <div class="about-penalty-card about-penalty-card--danger">
                <div class="about-penalty-icon">💸</div>
                <h3>Daily Fine Rate</h3>
                <p>After the grace period, a fee of <strong>5 MAD per day</strong> accumulates on overdue books. This is calculated automatically every midnight.</p>
            </div>
            <div class="about-penalty-card about-penalty-card--success">
                <div class="about-penalty-icon">🛡️</div>
                <h3>Maximum Cap</h3>
                <p>Fines are capped at a <strong>maximum of 200 MAD</strong> per loan, regardless of how long the book is overdue. You'll never owe more than that.</p>
            </div>
        </div>

        {{-- Visual timeline --}}
        <div class="about-timeline-card">
            <h3>Penalty Timeline Example</h3>
            <p style="color:var(--muted);margin-bottom:2rem;font-size:0.9rem;">Book borrowed on Day 1, due date is Day 14</p>
            <div class="about-timeline">
                <div class="about-tl-segment about-tl-green">
                    <div class="about-tl-label">Days 1 – 14</div>
                    <div class="about-tl-bar"></div>
                    <div class="about-tl-desc">Loan Period — No fee</div>
                </div>
                <div class="about-tl-segment about-tl-yellow">
                    <div class="about-tl-label">Days 15 – 16</div>
                    <div class="about-tl-bar"></div>
                    <div class="about-tl-desc">Grace Period — Still free</div>
                </div>
                <div class="about-tl-segment about-tl-red">
                    <div class="about-tl-label">Day 17+</div>
                    <div class="about-tl-bar"></div>
                    <div class="about-tl-desc">5 MAD / day (max 200 MAD)</div>
                </div>
            </div>
            <div class="about-penalty-example">
                <div class="about-pe-row">
                    <span>7 days overdue (after grace)</span>
                    <span><strong>35 MAD</strong></span>
                </div>
                <div class="about-pe-row">
                    <span>20 days overdue (after grace)</span>
                    <span><strong>100 MAD</strong></span>
                </div>
                <div class="about-pe-row">
                    <span>50 days overdue (after grace)</span>
                    <span><strong style="color:var(--success);">200 MAD (capped)</strong></span>
                </div>
            </div>
        </div>
    </section>

    {{-- Features section --}}
    <section class="about-section">
        <div class="about-section-header">
            <h2>Platform Features</h2>
            <p>Everything you need to manage your reading life</p>
        </div>
        <div class="about-features-grid">
            <div class="about-feature">
                <div class="about-feature-icon">🔍</div>
                <h3>Smart Search</h3>
                <p>Full-text search across titles, authors, and genres. Filter by availability and category instantly.</p>
            </div>
            <div class="about-feature">
                <div class="about-feature-icon">📊</div>
                <h3>Personal Dashboard</h3>
                <p>See your active loans, upcoming due dates, overdue books, and your complete borrowing history in one place.</p>
            </div>
            <div class="about-feature">
                <div class="about-feature-icon">🔔</div>
                <h3>Overdue Alerts</h3>
                <p>Overdue books are clearly flagged in your dashboard with the exact number of late days and current penalty amount.</p>
            </div>
            <div class="about-feature">
                <div class="about-feature-icon">🏛️</div>
                <h3>Large Catalog</h3>
                <p>Explore a growing catalog spanning Fiction, Science, History, Philosophy, Technology, Mystery, and more.</p>
            </div>
            <div class="about-feature">
                <div class="about-feature-icon">🌙</div>
                <h3>Dark &amp; Light Mode</h3>
                <p>Your preferred theme is saved automatically and applied instantly on every page for a comfortable reading experience.</p>
            </div>
            <div class="about-feature">
                <div class="about-feature-icon">🔒</div>
                <h3>Secure &amp; Private</h3>
                <p>Your data stays private. Passwords are hashed securely and sessions are protected with CSRF tokens.</p>
            </div>
        </div>
    </section>

    {{-- FAQ section --}}
    <section class="about-section">
        <div class="about-section-header">
            <h2>Frequently Asked Questions</h2>
        </div>
        <div class="about-faq">
            <details class="about-faq-item">
                <summary>How many books can I borrow at once?</summary>
                <p>There is no hard limit on the number of books you can borrow simultaneously, as long as copies are available in the catalog. However, we encourage responsible borrowing so other members can enjoy the collection too.</p>
            </details>
            <details class="about-faq-item">
                <summary>Can I extend my loan period?</summary>
                <p>Loan extensions are not currently available through the platform. If you need more time, please return the book and borrow it again if copies are still available.</p>
            </details>
            <details class="about-faq-item">
                <summary>What happens if a book is unavailable?</summary>
                <p>If a book shows "Out of Stock", all copies are currently out on loan. Check back later — as soon as a copy is returned, it becomes available for borrowing again.</p>
            </details>
            <details class="about-faq-item">
                <summary>How are penalties calculated exactly?</summary>
                <p>Penalties are computed automatically every midnight. Starting from the 3rd day after your due date, 5 MAD is added per day. The total penalty per loan will never exceed 200 MAD.</p>
            </details>
            <details class="about-faq-item">
                <summary>Is registration free?</summary>
                <p>Yes, creating an account is completely free. You only need your name and email address to get started and start borrowing books immediately.</p>
            </details>
            <details class="about-faq-item">
                <summary>What happens if my account is deactivated?</summary>
                <p>If your account is deactivated by an administrator, you will not be able to log in. Any outstanding loans or penalties will remain on record. Please contact library staff to resolve the issue.</p>
            </details>
        </div>
    </section>

    {{-- CTA section --}}
    @guest('web')
    <section class="about-cta-section">
        <h2>Ready to start reading?</h2>
        <p>Join BiblioTech today and explore hundreds of books across every genre.</p>
        <div class="about-cta-buttons">
            <a href="{{ route('register') }}" class="btn btn-primary" style="padding:0.75rem 2rem;font-size:1rem;">Create Free Account</a>
            <a href="{{ route('member.books.index') }}" class="btn btn-secondary" style="padding:0.75rem 2rem;font-size:1rem;">Browse Without Signing Up</a>
        </div>
    </section>
    @endguest

</div>
@endsection
