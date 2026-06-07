@extends('layouts.admin')
@section('title', 'Books')
@section('page-title', 'Books')

@section('content')
<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
    <div style="font-size:0.9rem; color:var(--muted);">{{ $books->total() }} books total</div>
    <a href="{{ route('admin.books.create') }}" class="btn btn-primary">+ Add Book</a>
</div>

<div class="card">
    <form method="GET" action="{{ route('admin.books.index') }}" class="search-bar">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title, author, genre…">
        <button type="submit" class="btn btn-primary">Search</button>
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
                    <th>Copies</th>
                    <th>Available</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                <tr>
                    <td>
                        @if($book->cover_image)
                            <img src="{{ $book->cover_image }}" alt="{{ $book->title }}" style="width:40px;height:55px;object-fit:cover;border-radius:4px;">
                        @else
                            <div style="width:40px;height:55px;background:var(--border);border-radius:4px;display:flex;align-items:center;justify-content:center;font-size:1rem;">📚</div>
                        @endif
                    </td>
                    <td style="font-weight:500;max-width:200px;">{{ Str::limit($book->title, 40) }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->genre ?? '—' }}</td>
                    <td style="font-size:0.8rem;color:var(--muted);">{{ $book->isbn ?? '—' }}</td>
                    <td>{{ $book->total_copies }}</td>
                    <td>
                        @if($book->available_copies > 0)
                            <span class="badge badge-active">{{ $book->available_copies }}</span>
                        @else
                            <span class="badge badge-overdue">0</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:0.4rem;">
                            <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.books.destroy', $book) }}" onsubmit="return confirm('Delete \'{{ addslashes($book->title) }}\'? This will also remove the Cloudinary image.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" style="text-align:center;color:var(--muted);padding:2rem;">No books found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $books->links() }}</div>
</div>
@endsection
