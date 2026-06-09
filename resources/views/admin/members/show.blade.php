@extends('layouts.admin')
@section('title', $member->name)
@section('page-title', 'Member Profile')

@section('content')
<a href="{{ route('admin.members.index') }}" class="btn btn-secondary btn-sm" style="margin-bottom:1.5rem;">← Back to Members</a>

<div style="display:grid;grid-template-columns:280px 1fr;gap:1.5rem;align-items:start;">

    {{-- Member Info Card --}}
    <div class="card" style="padding:0;overflow:hidden;">
        {{-- Card header --}}
        <div style="background:linear-gradient(135deg,rgba(99,102,241,0.15),rgba(139,92,246,0.08));padding:2rem;text-align:center;border-bottom:1px solid var(--border);">
            <div style="width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,var(--accent),var(--accent2));display:flex;align-items:center;justify-content:center;margin:0 auto 0.85rem;font-size:1.75rem;font-weight:800;color:#fff;box-shadow:0 6px 20px rgba(99,102,241,0.35);">
                {{ mb_strtoupper(mb_substr($member->name, 0, 1)) }}
            </div>
            <div style="font-size:1.1rem;font-weight:700;margin-bottom:0.2rem;">{{ $member->name }}</div>
            <div style="font-size:0.825rem;color:var(--muted);">{{ $member->email }}</div>
            <div style="margin-top:0.75rem;">
                <span class="badge badge-{{ $member->is_active ? 'active' : 'overdue' }}">{{ $member->is_active ? 'Active' : 'Inactive' }}</span>
            </div>
        </div>

        {{-- Info rows --}}
        <div style="padding:1.25rem;">
            <div style="display:flex;flex-direction:column;gap:0.5rem;font-size:0.875rem;">
                <div style="display:flex;justify-content:space-between;align-items:center;padding:0.5rem 0;border-bottom:1px solid var(--border);">
                    <span style="color:var(--muted);font-weight:500;">Phone</span>
                    <span style="font-weight:500;">{{ $member->phone ?? '—' }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:0.5rem 0;border-bottom:1px solid var(--border);">
                    <span style="color:var(--muted);font-weight:500;">Joined</span>
                    <span style="font-weight:500;">{{ $member->created_at->format('d M Y') }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:0.5rem 0;">
                    <span style="color:var(--muted);font-weight:500;">Active Loans</span>
                    <span style="font-weight:700;color:{{ $activeLoans->count() > 0 ? 'var(--warning)' : 'var(--success)' }};">{{ $activeLoans->count() }}</span>
                </div>
            </div>

            @if($member->address)
                <div style="margin-top:1rem;padding:0.875rem;background:var(--surface2);border-radius:8px;border:1px solid var(--border);">
                    <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:var(--muted);margin-bottom:0.35rem;">Address</div>
                    <div style="font-size:0.85rem;color:var(--text);">{{ $member->address }}</div>
                </div>
            @endif

            <div style="margin-top:1.25rem;">
                <form method="POST" action="{{ route('admin.members.destroy', $member) }}" id="del-form">
                    @csrf @method('DELETE')
                    <button type="button" class="btn btn-danger" style="width:100%;justify-content:center;"
                        onclick="handleDelete({{ $member->id }}, {{ $activeLoans->count() }}, '{{ addslashes($member->name) }}')">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Delete Member
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Active Loans --}}
    <div class="card">
        <div class="card-title">
            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
            Active Loans <span style="font-size:0.78rem;background:var(--surface2);color:var(--muted);padding:0.15rem 0.6rem;border-radius:999px;font-weight:500;margin-left:0.35rem;">{{ $activeLoans->count() }}</span>
        </div>

        @if($activeLoans->isEmpty())
            <div style="text-align:center;padding:2.5rem 1rem;color:var(--muted);">
                <div style="font-size:2rem;margin-bottom:0.5rem;">🏛️</div>
                <div style="font-weight:600;color:var(--text);margin-bottom:0.2rem;">No active loans</div>
                <div style="font-size:0.85rem;">This member has no books checked out.</div>
            </div>
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
                                <div style="font-weight:600;font-size:0.875rem;max-width:200px;">{{ Str::limit($loan->book->title, 35) }}</div>
                                <div style="font-size:0.75rem;color:var(--muted);margin-top:2px;">{{ $loan->book->author }}</div>
                            </td>
                            <td style="font-size:0.85rem;color:var(--muted);">{{ $loan->borrowed_at->format('d M Y') }}</td>
                            <td style="font-size:0.85rem;">
                                {{ $loan->due_date->format('d M Y') }}
                                @if($loan->days_overdue > 0)
                                    <div style="font-size:0.72rem;color:var(--danger);margin-top:2px;font-weight:600;">{{ $loan->days_overdue }}d overdue</div>
                                @endif
                            </td>
                            <td><span class="badge badge-{{ $loan->status }}">{{ ucfirst($loan->status) }}</span></td>
                            <td style="font-weight:600;color:{{ $loan->penalty_amount > 0 ? 'var(--danger)' : 'var(--muted)' }};">
                                {{ $loan->penalty_amount > 0 ? number_format($loan->penalty_amount, 2).' MAD' : '—' }}
                            </td>
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
            <button class="btn btn-danger" onclick="submitDelete('remove_books')">Delete user and abandon his books</button>
            <button class="btn" style="background:var(--warning-glow);color:var(--warning);border:1px solid rgba(245,158,11,0.3);" onclick="submitDelete('return_books')">Delete user and mark books as returned</button>
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
    document.getElementById('modal-body').textContent = `This member has ${activeLoans} active loan(s). Choose how to handle them:`;
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
