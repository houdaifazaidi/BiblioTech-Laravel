@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card" style="--stat-color:#6366f1; --stat-glow: rgba(99,102,241,0.12);">
        <div class="stat-icon">🏛️</div>
        <div class="stat-body">
            <div class="stat-value">{{ $stats['total_books'] }}</div>
            <div class="stat-label">Total Books</div>
        </div>
    </div>
    <div class="stat-card" style="--stat-color:#8b5cf6; --stat-glow: rgba(139,92,246,0.12);">
        <div class="stat-icon">👥</div>
        <div class="stat-body">
            <div class="stat-value">{{ $stats['total_members'] }}</div>
            <div class="stat-label">Total Members</div>
        </div>
    </div>
    <div class="stat-card" style="--stat-color:#10b981; --stat-glow: rgba(16,185,129,0.12);">
        <div class="stat-icon">📖</div>
        <div class="stat-body">
            <div class="stat-value">{{ $stats['active_loans'] }}</div>
            <div class="stat-label">Active Loans</div>
        </div>
    </div>
    <div class="stat-card" style="--stat-color:#ef4444; --stat-glow: rgba(239,68,68,0.12);">
        <div class="stat-icon">⚠️</div>
        <div class="stat-body">
            <div class="stat-value">{{ $stats['overdue_loans'] }}</div>
            <div class="stat-label">Overdue Loans</div>
        </div>
    </div>
    <div class="stat-card" style="--stat-color:#f59e0b; --stat-glow: rgba(245,158,11,0.12);">
        <div class="stat-icon">✅</div>
        <div class="stat-body">
            <div class="stat-value">{{ $stats['returned_today'] }}</div>
            <div class="stat-label">Returned Today</div>
        </div>
    </div>
    <div class="stat-card" style="--stat-color:#06b6d4; --stat-glow: rgba(6,182,212,0.12);">
        <div class="stat-icon">🟢</div>
        <div class="stat-body">
            <div class="stat-value">{{ $stats['available_books'] }}</div>
            <div class="stat-label">Books Available</div>
        </div>
    </div>
</div>

<div class="card">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem;">
        <div class="card-title" style="margin:0;">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Recent Active Loans
        </div>
        <a href="{{ route('admin.books.create') }}" class="btn btn-primary btn-sm">+ Add Book</a>
    </div>

    @if($recentLoans->isEmpty())
        <div style="text-align:center; padding:2.5rem 1rem; color:var(--muted);">
            <div style="font-size:2.5rem; margin-bottom:0.75rem;">📋</div>
            <div style="font-weight:600; color:var(--text); margin-bottom:0.25rem;">No active loans</div>
            <div style="font-size:0.875rem;">All books are currently available.</div>
        </div>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Book</th>
                        <th>Borrowed</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Penalty</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentLoans as $loan)
                    <tr>
                        <td style="font-weight:500;">{{ $loan->member->name ?? '—' }}</td>
                        <td style="color:var(--text); max-width:200px;">{{ Str::limit($loan->book->title ?? '—', 35) }}</td>
                        <td style="color:var(--muted); font-size:0.82rem;">{{ $loan->borrowed_at->format('d M Y') }}</td>
                        <td style="font-size:0.82rem;">
                            {{ $loan->due_date->format('d M Y') }}
                            @if($loan->status === 'overdue')
                                <div style="font-size:0.72rem; color:var(--danger); margin-top:2px;">{{ $loan->days_overdue }}d overdue</div>
                            @endif
                        </td>
                        <td><span class="badge badge-{{ $loan->status }}">{{ ucfirst($loan->status) }}</span></td>
                        <td style="font-weight:600; color:{{ $loan->penalty_amount > 0 ? 'var(--danger)' : 'var(--muted)' }};">
                            {{ number_format($loan->penalty_amount ?? 0, 2) }} MAD
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
