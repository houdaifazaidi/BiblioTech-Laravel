@extends('layouts.admin')
@section('title', 'Books')
@section('page-title', 'Books')

@section('content')
<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
    <div style="font-size:0.875rem; color:var(--muted);">
        <strong style="color:var(--text);">{{ $books->total() }}</strong> books total
    </div>
    <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        Add Book
    </a>
</div>

<div class="card">
    <form method="GET" action="{{ route('admin.books.index') }}" class="search-bar">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title, author, genre…">
        <button type="submit" class="btn btn-primary">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-width="2" d="M21 21l-4.35-4.35"/></svg>
            Search
        </button>
        @if(request('search'))
            <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Clear</a>
        @endif
    </form>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Cover</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Genre</th>
                    <th>ISBN</th>
                    <th style="text-align:center;">Copies</th>
                    <th style="text-align:center;">Available</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                <tr>
                    <td>
                        @if($book->cover_image)
                            <img src="{{ $book->cover_image }}" alt="{{ $book->title }}"
                                 style="width:38px;height:54px;object-fit:cover;border-radius:5px;display:block;box-shadow:0 2px 8px rgba(0,0,0,0.2);">
                        @else
                            <div style="width:38px;height:54px;background:var(--surface2);border-radius:5px;display:flex;align-items:center;justify-content:center;font-size:1rem;border:1px solid var(--border);">📚</div>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight:600;max-width:200px;line-height:1.35;">{{ Str::limit($book->title, 40) }}</div>
                    </td>
                    <td style="color:var(--muted);">{{ $book->author }}</td>
                    <td>
                        @if($book->genre)
                            <span class="badge badge-returned">{{ $book->genre }}</span>
                        @else
                            <span style="color:var(--muted);">—</span>
                        @endif
                    </td>
                    <td style="font-size:0.78rem;color:var(--muted);font-family:monospace;">{{ $book->isbn ?? '—' }}</td>
                    <td style="text-align:center;font-weight:600;">{{ $book->total_copies }}</td>
                    <td style="text-align:center;">
                        @if($book->available_copies > 0)
                            <span class="badge badge-active">{{ $book->available_copies }}</span>
                        @else
                            <span class="badge badge-overdue">0</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:0.4rem;">
                            <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.books.destroy', $book) }}"
                                  onsubmit="return confirm('Delete \'{{ addslashes($book->title) }}\'? This will also remove the Cloudinary image.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;color:var(--muted);padding:3rem;">
                        <div style="font-size:2rem;margin-bottom:0.5rem;">📚</div>
                        No books found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $books->links() }}
</div>
@endsection
