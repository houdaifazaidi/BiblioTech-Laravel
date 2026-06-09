@extends('layouts.app')
@section('title', 'My Loans')

@push('styles')
<style>
    /* ── Section tabs ──────────────────────────────── */
    .loans-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
    }
    .loans-section-header h2 {
        font-size: 1.2rem;
        font-weight: 700;
    }
    .loans-count-chip {
        font-size: 0.75rem;
        color: var(--muted);
        background: var(--surface2);
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        border: 1px solid var(--border);
    }

    /* ── Returned books grid ───────────────────────── */
    .returned-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1.1rem;
    }

    .returned-book-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
    }
    .returned-book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 14px 36px rgba(0,0,0,0.45);
        border-color: rgba(99,102,241,0.4);
    }

    /* Cover */
    .rbc-cover {
        position: relative;
        width: 100%;
        aspect-ratio: 2 / 3;
        background: var(--surface2);
        overflow: hidden;
        flex-shrink: 0;
    }
    .rbc-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }
    .returned-book-card:hover .rbc-cover img {
        transform: scale(1.05);
    }
    .rbc-cover-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.25rem;
        color: var(--muted);
    }

    /* Badge on cover */
    .rbc-status-dot {
        position: absolute;
        top: 7px;
        right: 7px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 700;
        backdrop-filter: blur(6px);
    }
    .rbc-status-dot.dot-returned {
        background: rgba(16,185,129,0.88);
        color: #fff;
        box-shadow: 0 2px 8px rgba(16,185,129,0.55);
    }
    .rbc-status-dot.dot-force {
        background: rgba(245,158,11,0.88);
        color: #fff;
        box-shadow: 0 2px 8px rgba(245,158,11,0.55);
    }

    /* Returned-on ribbon at bottom of cover */
    .rbc-returned-on {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.78) 0%, transparent 100%);
        padding: 0.5rem 0.5rem 0.4rem;
        font-size: 0.62rem;
        color: #a7f3d0;
        font-weight: 500;
        line-height: 1.3;
    }

    /* Info section */
    .rbc-info {
        padding: 0.75rem 0.8rem 0.85rem;
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
        flex: 1;
    }
    .rbc-title {
        font-weight: 600;
        font-size: 0.8rem;
        line-height: 1.3;
        color: var(--text);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .rbc-author {
        font-size: 0.7rem;
        color: var(--muted);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .rbc-penalty {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        margin-top: 0.3rem;
        font-size: 0.67rem;
        color: var(--warning);
        font-weight: 600;
    }
    .rbc-penalty-paid {
        font-size: 0.6rem;
        background: rgba(16,185,129,0.15);
        color: var(--success);
        border: 1px solid rgba(16,185,129,0.3);
        border-radius: 999px;
        padding: 0.05rem 0.4rem;
        font-weight: 600;
    }
    .rbc-badge-wrap {
        margin-top: auto;
        padding-top: 0.45rem;
    }

    @media (max-width: 480px) {
        .returned-grid { grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); }
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1>My Loans</h1>
    <p>Track your active borrows and your reading history</p>
</div>

<div class="container">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
        <a href="{{ route('member.dashboard') }}" class="btn btn-secondary btn-sm">← Back to Dashboard</a>
        <a href="{{ route('member.books.index') }}" class="btn btn-primary btn-sm">Borrow More Books</a>
    </div>

    @php
        $activeLoans   = $loans->filter(fn($l) => in_array($l->status, ['active', 'overdue']));
        $returnedLoans = $loans->filter(fn($l) => in_array($l->status, ['returned', 'force_returned']));
    @endphp

    {{-- ── Active / Overdue Loans ───────────────────── --}}
    <div class="loans-section-header" style="margin-top: 1.5rem;">
        <h2>Currently Borrowed</h2>
        @if($activeLoans->count())
            <span class="loans-count-chip">{{ $activeLoans->count() }} active</span>
        @endif
    </div>

    @if($activeLoans->isEmpty())
        <div class="card" style="text-align:center;padding:3rem 2rem;color:var(--muted);margin-bottom:3rem;">
            <div style="font-size:3rem;margin-bottom:1rem;">📖</div>
            <h3 style="color:var(--text);font-weight:700;margin-bottom:0.5rem;">No active borrows</h3>
            <p style="margin-bottom:1.5rem;">You do not have any books checked out at the moment.</p>
            <a href="{{ route('member.books.index') }}" class="btn btn-primary btn-sm">Explore Books</a>
        </div>
    @else
        <div class="returned-grid" style="margin-bottom:3rem;">
            @foreach($activeLoans as $loan)
            @php $isOverdue = $loan->status === 'overdue'; @endphp
            <div class="returned-book-card" style="{{ $isOverdue ? 'border-color: rgba(239, 68, 68, 0.4);' : '' }}">
                <div class="rbc-cover">
                    @if($loan->book->cover_image)
                        <img src="{{ $loan->book->cover_image }}" alt="{{ $loan->book->title }}">
                    @else
                        <div class="rbc-cover-placeholder">📚</div>
                    @endif

                    <div class="rbc-status-dot {{ $isOverdue ? 'dot-force' : 'dot-returned' }}" style="{{ !$isOverdue ? 'background: rgba(99, 102, 241, 0.88); box-shadow: 0 2px 8px rgba(99, 102, 241, 0.55);' : '' }}">
                        {{ $isOverdue ? '⚠' : '📖' }}
                    </div>

                    <div class="rbc-returned-on" style="{{ $isOverdue ? 'background: linear-gradient(to top, rgba(239,68,68,0.85) 0%, transparent 100%); color: #fca5a5;' : 'background: linear-gradient(to top, rgba(99,102,241,0.85) 0%, transparent 100%); color: #c7d2fe;' }}">
                        ⏳ Due: {{ $loan->due_date->format('d M Y') }}
                    </div>
                </div>

                <div class="rbc-info">
                    <div class="rbc-title" title="{{ $loan->book->title }}">{{ $loan->book->title }}</div>
                    <div class="rbc-author">by {{ $loan->book->author }}</div>

                    <div style="font-size: 0.68rem; color: var(--muted); margin-top: 0.25rem;">
                        📅 {{ $loan->borrowed_at->format('d M Y') }}
                    </div>

                    @if($loan->penalty_amount > 0)
                        <div class="rbc-penalty">
                            ⚠ {{ number_format($loan->penalty_amount, 2) }} MAD
                            <span class="rbc-penalty-paid" style="background: rgba(239, 68, 68, 0.15); color: var(--danger); border-color: rgba(239, 68, 68, 0.3);">{{ $loan->days_overdue }}d late</span>
                        </div>
                    @endif

                    <div class="rbc-badge-wrap" style="display: flex; flex-direction: column; gap: 0.5rem; margin-top: auto;">
                        <span class="badge badge-{{ $loan->status }}" style="text-align: center; justify-content: center; width: 100%;">{{ ucfirst($loan->status) }}</span>
                        <form method="POST" action="{{ route('member.loans.return', $loan) }}" style="width: 100%;">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-success btn-sm" style="width: 100%; font-size: 0.75rem; padding: 0.35rem 0.5rem;">Return</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

    {{-- ── Returned / History ───────────────────────── --}}
    @if($returnedLoans->count())
        <div class="loans-section-header">
            <h2>Recently Returned</h2>
            <span class="loans-count-chip">{{ $returnedLoans->count() }} book{{ $returnedLoans->count() !== 1 ? 's' : '' }}</span>
        </div>

        <div class="returned-grid" style="margin-bottom:2rem;">
            @foreach($returnedLoans as $loan)
            @php $isForce = $loan->status === 'force_returned'; @endphp
            <div class="returned-book-card">
                <div class="rbc-cover">
                    @if($loan->book->cover_image)
                        <img src="{{ $loan->book->cover_image }}" alt="{{ $loan->book->title }}">
                    @else
                        <div class="rbc-cover-placeholder">📚</div>
                    @endif

                    <div class="rbc-status-dot {{ $isForce ? 'dot-force' : 'dot-returned' }}">
                        {{ $isForce ? '⚡' : '✓' }}
                    </div>

                    <div class="rbc-returned-on">
                        ✅ {{ $loan->returned_at?->format('d M Y') ?? '—' }}
                    </div>
                </div>

                <div class="rbc-info">
                    <div class="rbc-title" title="{{ $loan->book->title }}">{{ $loan->book->title }}</div>
                    <div class="rbc-author">{{ $loan->book->author }}</div>

                    @if($loan->penalty_amount > 0)
                        <div class="rbc-penalty">
                            ⚠ {{ number_format($loan->penalty_amount, 2) }} MAD
                            @if($loan->penalty_paid)
                                <span class="rbc-penalty-paid">Paid</span>
                            @endif
                        </div>
                    @endif

                    <div class="rbc-badge-wrap">
                        <span class="badge badge-returned">{{ ucfirst(str_replace('_', ' ', $loan->status)) }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination only for returned section --}}
        <div class="pagination">
            {{ $loans->links() }}
        </div>
    @endif
</div>
@endsection
