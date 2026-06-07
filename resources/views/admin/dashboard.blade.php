@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value" style="color:#6366f1">{{ $stats['total_books'] }}</div>
        <div class="stat-label">Total Books</div>
    </div>
    <div class="stat-card">
        <div class="stat-value" style="color:#8b5cf6">{{ $stats['total_members'] }}</div>
        <div class="stat-label">Total Members</div>
    </div>
    <div class="stat-card">
        <div class="stat-value" style="color:#10b981">{{ $stats['active_loans'] }}</div>
        <div class="stat-label">Active Loans</div>
    </div>
    <div class="stat-card">
        <div class="stat-value" style="color:#ef4444">{{ $stats['overdue_loans'] }}</div>
        <div class="stat-label">Overdue Loans</div>
    </div>
    <div class="stat-card">
        <div class="stat-value" style="color:#f59e0b">{{ $stats['returned_today'] }}</div>
        <div class="stat-label">Returned Today</div>
    </div>
    <div class="stat-card">
        <div class="stat-value" style="color:#06b6d4">{{ $stats['available_books'] }}</div>
        <div class="stat-label">Books Available</div>
    </div>
</div>

<div class="card">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;">
        <div class="card-title" style="margin:0">Recent Active Loans</div>
        <a href="{{ route('admin.books.index') }}" class="btn btn-primary btn-sm">+ Add Book</a>
    </div>
    @if($recentLoans->isEmpty())
        <p style="color:var(--muted); font-size:0.875rem;">No active loans at the moment.</p>
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
                        <td>{{ $loan->member->name ?? '—' }}</td>
                        <td>{{ $loan->book->title ?? '—' }}</td>
                        <td>{{ $loan->borrowed_at->format('d M Y') }}</td>
                        <td>{{ $loan->due_date->format('d M Y') }}</td>
                        <td><span class="badge badge-{{ $loan->status }}">{{ ucfirst($loan->status) }}</span></td>
                        <td>{{ $loan->penalty_amount > 0 ? number_format($loan->penalty_amount, 2).' MAD' : '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
