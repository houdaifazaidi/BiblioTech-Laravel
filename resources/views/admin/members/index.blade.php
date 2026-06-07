@extends('layouts.admin')
@section('title', 'Members')
@section('page-title', 'Members')

@section('content')
<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
    <div style="font-size:0.9rem; color:var(--muted);">{{ $members->total() }} members registered</div>
</div>

<div class="card">
    <form method="GET" action="{{ route('admin.members.index') }}" class="search-bar">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email…">
        <button type="submit" class="btn btn-primary">Search</button>
        @if(request('search'))
            <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">Clear</a>
        @endif
    </form>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Active Loans</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $member)
                <tr>
                    <td style="font-weight:500;">{{ $member->name }}</td>
                    <td style="color:var(--muted);font-size:0.85rem;">{{ $member->email }}</td>
                    <td>
                        @if($member->is_active)
                            <span class="badge badge-active">Active</span>
                        @else
                            <span class="badge badge-overdue">Inactive</span>
                        @endif
                    </td>
                    <td>
                        @if($member->active_loans_count > 0)
                            <span class="badge badge-overdue">{{ $member->active_loans_count }} book{{ $member->active_loans_count > 1 ? 's' : '' }}</span>
                        @else
                            <span style="color:var(--muted);font-size:0.85rem;">—</span>
                        @endif
                    </td>
                    <td style="font-size:0.85rem;color:var(--muted);">{{ $member->created_at->format('d M Y') }}</td>
                    <td>
                        <div style="display:flex;gap:0.4rem;">
                            <a href="{{ route('admin.members.show', $member) }}" class="btn btn-secondary btn-sm">View</a>
                            <form method="POST" action="{{ route('admin.members.destroy', $member) }}" id="del-form-{{ $member->id }}">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="handleDelete({{ $member->id }}, {{ $member->active_loans_count }}, '{{ addslashes($member->name) }}')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;color:var(--muted);padding:2rem;">No members found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $members->links() }}</div>
</div>

{{-- Delete Modal --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <div class="modal-title" id="modal-title">Delete Member</div>
        <div class="modal-body" id="modal-body">This member has active loans. Choose how to proceed:</div>
        <div class="modal-actions">
            <button class="btn btn-secondary" onclick="closeModal()">Cancel — Do nothing</button>
            <button class="btn btn-danger" id="btn-remove-books" onclick="submitDelete('remove_books')">
                Delete user and remove their books from loans
            </button>
            <button class="btn" style="background:rgba(245,158,11,0.12);color:#f59e0b;border:1px solid rgba(245,158,11,0.3);"
                id="btn-return-books" onclick="submitDelete('return_books')">
                Delete user and mark books as returned
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentMemberId = null;
let currentHasLoans = false;

function handleDelete(memberId, activeLoans, memberName) {
    currentMemberId = memberId;
    currentHasLoans = activeLoans > 0;

    if (!currentHasLoans) {
        if (confirm(`Delete "${memberName}"? This cannot be undone.`)) {
            document.getElementById('del-form-' + memberId).submit();
        }
        return;
    }

    document.getElementById('modal-title').textContent = `Delete "${memberName}"`;
    document.getElementById('modal-body').textContent =
        `This member has ${activeLoans} active loan(s). Choose how to handle them:`;
    document.getElementById('deleteModal').classList.add('open');
}

function closeModal() {
    document.getElementById('deleteModal').classList.remove('open');
    currentMemberId = null;
}

function submitDelete(action) {
    if (!currentMemberId) return;
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/members/${currentMemberId}/force-delete`;
    form.innerHTML = `
        @csrf
        <input type="hidden" name="action" value="${action}">
    `;
    document.body.appendChild(form);
    form.submit();
}

document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
@endpush
@endsection
