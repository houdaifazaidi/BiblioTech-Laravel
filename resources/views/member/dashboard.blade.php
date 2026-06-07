@extends('layouts.app')
@section('title', 'My Dashboard')

@section('content')
<div class="page-header">
    <h1>Welcome back, {{ auth()->user()->name }}!</h1>
    <p>Here's an overview of your library activity</p>
</div>

<div class="container">
    {{-- Quick Stats --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:1rem;margin-bottom:2rem;">
        <div class="card" style="text-align:center;">
            <div style="font-size:2rem;font-weight:700;color:#6366f1;">{{ $activeLoans->count() }}</div>
            <div style="font-size:0.8rem;color:var(--muted);margin-top:0.25rem;">Books Borrowed</div>
        </div>
        <div class="card" style="text-align:center;">
            <div style="font-size:2rem;font-weight:700;color:#ef4444;">{{ $activeLoans->where('status','overdue')->count() }}</div>
            <div style="font-size:0.8rem;color:var(--muted);margin-top:0.25rem;">Overdue</div>
        </div>
        <div class="card" style="text-align:center;">
            <div style="font-size:2rem;font-weight:700;color:#f59e0b;">
                {{ number_format($activeLoans->sum('penalty_amount'), 2) }} MAD
            </div>
            <div style="font-size:0.8rem;color:var(--muted);margin-top:0.25rem;">Total Penalty</div>
        </div>
    </div>

    {{-- Active Loans --}}
    <div class="card" style="margin-bottom:1.5rem;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
            <div class="card-title" style="margin:0;">Currently Borrowed</div>
            <a href="{{ route('member.books.index') }}" class="btn btn-primary btn-sm">Browse Books</a>
        </div>

        @if($activeLoans->isEmpty())
            <div style="text-align:center;padding:2rem;color:var(--muted);">
                <div style="font-size:2.5rem;margin-bottom:0.75rem;">📚</div>
                <div>You haven't borrowed any books yet.</div>
                <a href="{{ route('member.books.index') }}" class="btn btn-primary" style="margin-top:1rem;">Browse Library</a>
            </div>
        @else
            <div class="loans-list">
                @foreach($activeLoans as $loan)
                <div class="loan-card">
                    @if($loan->book->cover_image)
                        <img src="{{ $loan->book->cover_image }}" alt="{{ $loan->book->title }}" class="loan-cover">
                    @else
                        <div class="loan-cover" style="display:flex;align-items:center;justify-content:center;font-size:1.75rem;border-radius:6px;">📚</div>
                    @endif
                    <div class="loan-details">
                        <div class="loan-title">{{ $loan->book->title }}</div>
                        <div class="loan-meta">{{ $loan->book->author }}</div>
                        <div class="loan-meta" style="margin-top:0.5rem;">
                            Borrowed: {{ $loan->borrowed_at->format('d M Y') }} •
                            Due: {{ $loan->due_date->format('d M Y') }}
                        </div>
                        @if($loan->penalty_amount > 0)
                            <div class="loan-penalty">⚠ Penalty: {{ number_format($loan->penalty_amount, 2) }} MAD ({{ $loan->days_overdue }} days overdue)</div>
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
        <div class="card-title">Recently Returned</div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Book</th><th>Returned</th><th>Status</th></tr></thead>
                <tbody>
                    @foreach($history as $loan)
                    <tr>
                        <td>
                            <div style="font-weight:500;font-size:0.875rem;">{{ $loan->book->title }}</div>
                            <div style="font-size:0.75rem;color:var(--muted);">{{ $loan->book->author }}</div>
                        </td>
                        <td style="font-size:0.85rem;color:var(--muted);">{{ $loan->returned_at?->format('d M Y') ?? '—' }}</td>
                        <td><span class="badge badge-returned">{{ ucfirst(str_replace('_', ' ', $loan->status)) }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
