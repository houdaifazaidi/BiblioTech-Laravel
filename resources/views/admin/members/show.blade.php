@extends('layouts.admin')
@section('title', $member->name)
@section('page-title', 'Member Profile')

@section('content')
<a href="{{ route('admin.members.index') }}" class="btn btn-secondary btn-sm" style="margin-bottom:1.5rem;">← Back to Members</a>

<div style="display:grid;grid-template-columns:1fr 2fr;gap:1.5rem;align-items:start;">
    {{-- Member Info Card --}}
    <div class="card">
        <div style="text-align:center;margin-bottom:1.25rem;">
            <div style="width:72px;height:72px;border-radius:50%;background:rgba(99,102,241,0.15);border:2px solid rgba(99,102,241,0.3);display:flex;align-items:center;justify-content:center;margin:0 auto 0.75rem;font-size:1.75rem;">
                {{ mb_strtoupper(mb_substr($member->name, 0, 1)) }}
            </div>
            <div style="font-size:1.1rem;font-weight:600;">{{ $member->name }}</div>
            <div style="font-size:0.85rem;color:var(--muted);">{{ $member->email }}</div>
        </div>
        <div style="display:flex;flex-direction:column;gap:0.6rem;font-size:0.875rem;">
            <div style="display:flex;justify-content:space-between;">
                <span style="color:var(--muted)">Status</span>
                <span class="badge badge-{{ $member->is_active ? 'active' : 'overdue' }}">{{ $member->is_active ? 'Active' : 'Inactive' }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;">
                <span style="color:var(--muted)">Phone</span>
                <span>{{ $member->phone ?? '—' }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;">
                <span style="color:var(--muted)">Joined</span>
                <span>{{ $member->created_at->format('d M Y') }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;">
                <span style="color:var(--muted)">Active Loans</span>
                <span style="font-weight:600;">{{ $activeLoans->count() }}</span>
            </div>
        </div>
        @if($member->address)
            <div style="margin-top:1rem;padding-top:1rem;border-top:1px solid var(--border);font-size:0.8rem;color:var(--muted);">
                <div style="font-weight:500;color:var(--text);margin-bottom:0.25rem;">Address</div>
                {{ $member->address }}
            </div>
        @endif
        <div style="margin-top:1.5rem;">
            <form method="POST" action="{{ route('admin.members.destroy', $member) }}" id="del-form">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-danger" style="width:100%;justify-content:center;"
                    onclick="handleDelete({{ $member->id }}, {{ $activeLoans->count() }}, '{{ addslashes($member->name) }}')">
                    Delete Member
                </button>
            </form>
        </div>
    </div>

    {{-- Active Loans --}}
    <div class="card">
        <div class="card-title">Active Loans ({{ $activeLoans->count() }})</div>
        @if($activeLoans->isEmpty())
            <p style="color:var(--muted);font-size:0.875rem;">No active loans for this member.</p>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Book</th>
                            <th>Borrowed</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Penalty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activeLoans as $loan)
                        <tr>
                            <td>
                                <div style="font-weight:500;font-size:0.875rem;">{{ Str::limit($loan->book->title, 35) }}</div>
                                <div style="font-size:0.75rem;color:var(--muted);">{{ $loan->book->author }}</div>
                            </td>
                            <td style="font-size:0.85rem;">{{ $loan->borrowed_at->format('d M Y') }}</td>
                            <td style="font-size:0.85rem;">
                                {{ $loan->due_date->format('d M Y') }}
                                @if($loan->days_overdue > 0)
                                    <div style="font-size:0.75rem;color:var(--danger);">{{ $loan->days_overdue }}d overdue</div>
                                @endif
                            </td>
                            <td><span class="badge badge-{{ $loan->status }}">{{ ucfirst($loan->status) }}</span></td>
                            <td>{{ $loan->penalty_amount > 0 ? number_format($loan->penalty_amount, 2).' MAD' : '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <div class="modal-title" id="modal-title">Delete Member</div>
        <div class="modal-body" id="modal-body"></div>
        <div class="modal-actions">
            <button class="btn btn-secondary" onclick="closeModal()">Cancel — Do nothing</button>
            <button class="btn btn-danger" onclick="submitDelete('remove_books')">
                Delete user and abandon his books
            </button>
            <button class="btn" style="background:rgba(245,158,11,0.12);color:#f59e0b;border:1px solid rgba(245,158,11,0.3);"
                onclick="submitDelete('return_books')">
                Delete user and mark books as returned
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function handleDelete(memberId, activeLoans, memberName) {
    if (activeLoans === 0) {
        if (confirm(`Delete "${memberName}"? This cannot be undone.`)) {
            document.getElementById('del-form').submit();
        }
        return;
    }
    document.getElementById('modal-title').textContent = `Delete "${memberName}"`;
    document.getElementById('modal-body').textContent =
        `This member has ${activeLoans} active loan(s). Choose how to handle them:`;
    document.getElementById('deleteModal').classList.add('open');
}
function closeModal() { document.getElementById('deleteModal').classList.remove('open'); }
function submitDelete(action) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("admin.members.force-delete", $member) }}';
    form.innerHTML = `@csrf<input type="hidden" name="action" value="${action}">`;
    document.body.appendChild(form);
    form.submit();
}
document.getElementById('deleteModal').addEventListener('click', e => { if (e.target === e.currentTarget) closeModal(); });
</script>
@endpush
@endsection
