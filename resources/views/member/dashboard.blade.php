@extends('layouts.app')
@section('title', 'My Dashboard')

@push('styles')
<style>
.dashboard-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}
.dash-stat-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 1.5rem 1.25rem;
    text-align: center;
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}
.dash-stat-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: var(--stat-color, var(--accent));
    opacity: 0.7;
}
.dash-stat-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }
.dash-stat-icon { font-size: 1.75rem; margin-bottom: 0.5rem; line-height: 1; }
.dash-stat-value { font-size: 2rem; font-weight: 800; color: var(--stat-color, var(--accent)); line-height: 1; margin-bottom: 0.35rem; }
.dash-stat-label { font-size: 0.75rem; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1>Welcome back, {{ auth()->user()->name }}! 👋</h1>
    <p>Here's an overview of your library activity</p>
</div>

<div class="container">
    {{-- Quick Stats --}}
    <div class="dashboard-stats">
        <div class="dash-stat-card" style="--stat-color: #6366f1;">
            <div class="dash-stat-icon">🏛️</div>
            <div class="dash-stat-value">{{ $activeLoans->count() }}</div>
            <div class="dash-stat-label">Books Borrowed</div>
        </div>
        <div class="dash-stat-card" style="--stat-color: #ef4444;">
            <div class="dash-stat-icon">⚠️</div>
            <div class="dash-stat-value">{{ $activeLoans->where('status','overdue')->count() }}</div>
            <div class="dash-stat-label">Overdue</div>
        </div>
        <div class="dash-stat-card" style="--stat-color: #f59e0b;">
            <div class="dash-stat-icon">💰</div>
            <div class="dash-stat-value" style="font-size:1.35rem;">{{ number_format($activeLoans->sum('penalty_amount'), 2) }}</div>
            <div class="dash-stat-label">Penalty (MAD)</div>
        </div>
    </div>

    {{-- Active Loans --}}
    <div class="card" style="margin-bottom:1.5rem;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;">
            <div class="card-title" style="margin:0;">
                📖 Currently Borrowed
            </div>
            <a href="{{ route('member.books.index') }}" class="btn btn-primary btn-sm">Browse Books</a>
        </div>

        @if($activeLoans->isEmpty())
            <div style="text-align:center;padding:3rem 2rem;color:var(--muted);">
                <div style="font-size:3rem;margin-bottom:0.75rem;">🏛️</div>
                <div style="font-size:1rem;font-weight:600;color:var(--text);margin-bottom:0.4rem;">No books borrowed yet</div>
                <div style="font-size:0.875rem;margin-bottom:1.5rem;">Start exploring the catalog to borrow your first book.</div>
                <a href="{{ route('member.books.index') }}" class="btn btn-primary btn-sm">Browse Library</a>
            </div>
        @else
            <div class="loans-list">
                @foreach($activeLoans as $loan)
                <div class="loan-card">
                    @if($loan->book->cover_image)
                        <img src="{{ $loan->book->cover_image }}" alt="{{ $loan->book->title }}" class="loan-cover">
                    @else
                        <div class="loan-cover" style="display:flex;align-items:center;justify-content:center;font-size:1.75rem;">🏛️</div>
                    @endif
                    <div class="loan-details">
                        <div class="loan-title">{{ $loan->book->title }}</div>
                        <div class="loan-meta">by {{ $loan->book->author }}</div>
                        <div class="loan-meta" style="margin-top:0.4rem;display:flex;flex-wrap:wrap;gap:0.35rem 1rem;">
                            <span>📅 Borrowed: <strong style="color:var(--text)">{{ $loan->borrowed_at->format('d M Y') }}</strong></span>
                            <span>⏳ Due: <strong style="color:{{ $loan->status === 'overdue' ? 'var(--danger)' : 'var(--text)' }}">{{ $loan->due_date->format('d M Y') }}</strong></span>
                        </div>
                        @if($loan->penalty_amount > 0)
                            <div class="loan-penalty">⚠ Penalty: {{ number_format($loan->penalty_amount, 2) }} MAD — {{ $loan->days_overdue }} days overdue</div>
                        @endif
                    </div>
                    <div class="loan-actions">
                        <span class="badge badge-{{ $loan->status }}">{{ ucfirst($loan->status) }}</span>
                        <form method="POST" action="{{ route('member.loans.return', $loan) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-success btn-sm">Return</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Recent History --}}
    @if($history->isNotEmpty())
    <div class="card">
        <div class="card-title">📋 Recently Returned</div>
        <div class="loans-list">
            @foreach($history as $loan)
            <div class="loan-card">
                @if($loan->book->cover_image)
                    <img src="{{ $loan->book->cover_image }}" alt="{{ $loan->book->title }}" class="loan-cover">
                @else
                    <div class="loan-cover" style="display:flex;align-items:center;justify-content:center;font-size:1.75rem;">🏛️</div>
                @endif
                <div class="loan-details">
                    <div class="loan-title">{{ $loan->book->title }}</div>
                    <div class="loan-meta">by {{ $loan->book->author }}</div>
                    <div class="loan-meta" style="margin-top:0.4rem;display:flex;flex-wrap:wrap;gap:0.35rem 1rem;font-size:0.8rem;">
                        <span>📅 Borrowed: <strong style="color:var(--text)">{{ $loan->borrowed_at->format('d M Y') }}</strong></span>
                        <span>✅ Returned: <strong style="color:var(--success)">{{ $loan->returned_at?->format('d M Y') ?? '—' }}</strong></span>
                    </div>
                </div>
                <div class="loan-actions">
                    <span class="badge badge-returned">{{ ucfirst(str_replace('_', ' ', $loan->status)) }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
