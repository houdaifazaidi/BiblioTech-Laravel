@extends('layouts.app')
@section('title', 'My Loans')

@section('content')
<div class="page-header">
    <h1>My Loans History</h1>
    <p>A complete record of your library activity</p>
</div>

<div class="container">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
        <a href="{{ route('member.dashboard') }}" class="btn btn-secondary btn-sm">← Back to Dashboard</a>
        <a href="{{ route('member.books.index') }}" class="btn btn-primary btn-sm">Borrow More Books</a>
    </div>

    <div class="card">
        @if($loans->isEmpty())
            <div style="text-align:center;padding:4rem 0;color:var(--muted);">
                <div style="font-size:3rem;margin-bottom:1rem;">📋</div>
                <h2>No loan history found</h2>
                <p>You haven't borrowed any books yet.</p>
            </div>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Book</th>
                            <th>Borrowed On</th>
                            <th>Due Date</th>
                            <th>Returned On</th>
                            <th>Status</th>
                            <th>Penalty</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loans as $loan)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:0.75rem;">
                                    @if($loan->book->cover_image)
                                        <img src="{{ $loan->book->cover_image }}" alt="" style="width:36px;height:54px;object-fit:cover;border-radius:4px;">
                                    @else
                                        <div style="width:36px;height:54px;background:var(--surface2);border-radius:4px;display:flex;align-items:center;justify-content:center;font-size:1rem;">📚</div>
                                    @endif
                                    <div>
                                        <div style="font-weight:600;font-size:0.875rem;">{{ Str::limit($loan->book->title, 35) }}</div>
                                        <div style="font-size:0.75rem;color:var(--muted);">{{ $loan->book->author }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $loan->borrowed_at->format('d M Y') }}</td>
                            <td>
                                {{ $loan->due_date->format('d M Y') }}
                                @if($loan->days_overdue > 0 && in_array($loan->status, ['active', 'overdue']))
                                    <div style="font-size:0.7rem;color:var(--danger);font-weight:600;">{{ $loan->days_overdue }}d late</div>
                                @endif
                            </td>
                            <td style="color:var(--muted);">{{ $loan->returned_at?->format('d M Y') ?? '—' }}</td>
                            <td>
                                @if(in_array($loan->status, ['active', 'overdue']))
                                    <span class="badge badge-{{ $loan->status }}">{{ ucfirst($loan->status) }}</span>
                                @else
                                    <span class="badge badge-returned">{{ ucfirst(str_replace('_', ' ', $loan->status)) }}</span>
                                @endif
                            </td>
                            <td>
                                @if($loan->penalty_amount > 0)
                                    <span style="color:var(--danger);font-weight:600;">{{ number_format($loan->penalty_amount, 2) }} MAD</span>
                                @else
                                    <span style="color:var(--muted);">—</span>
                                @endif
                            </td>
                            <td>
                                @if(in_array($loan->status, ['active', 'overdue']))
                                    <form method="POST" action="{{ route('member.loans.return', $loan) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm">Return</button>
                                    </form>
                                @else
                                    <span style="color:var(--muted);font-size:0.8rem;">Returned</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pagination">
                {{ $loans->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
