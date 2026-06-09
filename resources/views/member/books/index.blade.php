@extends('layouts.app')
@section('title', 'Browse Books')

@section('content')
<div class="page-header">
    <h1>Library Catalog</h1>
    <p>Discover your next great read</p>
</div>

<div class="container">
    <form method="GET" action="{{ route('member.books.index') }}" class="filters">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title, author, or genre…">

        <select name="genre">
            <option value="">All Genres</option>
            @foreach($genres as $g)
                <option value="{{ $g }}" {{ request('genre') == $g ? 'selected' : '' }}>{{ $g }}</option>
            @endforeach
        </select>

        <label class="filter-label">
            <input type="checkbox" name="available" value="1" {{ request('available') ? 'checked' : '' }}>
            Available Only
        </label>

        <button type="submit" class="btn btn-primary">Filter</button>
        @if(request()->hasAny(['search', 'genre', 'available']))
            <a href="{{ route('member.books.index') }}" class="btn btn-secondary">Clear</a>
        @endif
    </form>

    @if($books->isEmpty())
        <div style="text-align:center;padding:5rem 0;color:var(--muted);">
            <div style="font-size:3.5rem;margin-bottom:1rem;">🏛️</div>
            <h2 style="color:var(--text);font-size:1.4rem;margin-bottom:0.5rem;">No books found</h2>
            <p style="margin-bottom:1.5rem;">Try adjusting your search or filters.</p>
            <a href="{{ route('member.books.index') }}" class="btn btn-secondary btn-sm">Clear Filters</a>
        </div>
    @else
        <div class="books-grid">
            @foreach($books as $book)
            <a href="{{ route('member.books.show', $book) }}" style="text-decoration:none;color:inherit;display:contents;">
                <div class="book-card">
                    <div class="book-cover-wrap">
                        @if($book->cover_image)
                            <img src="{{ $book->cover_image }}" alt="{{ $book->title }}" class="book-cover">
                        @else
                            <div class="book-cover" style="display:flex;align-items:center;justify-content:center;font-size:2.25rem;">🏛️</div>
                        @endif

                        {{-- Availability overlay badge --}}
                        @if($book->available_copies === 0)
                            <div style="position:absolute;top:8px;right:8px;background:rgba(239,68,68,0.88);color:#fff;font-size:0.6rem;font-weight:700;padding:0.2rem 0.5rem;border-radius:4px;text-transform:uppercase;letter-spacing:0.5px;backdrop-filter:blur(4px);">Out of stock</div>
                        @endif
                    </div>
                    <div class="book-info">
                        <div class="book-title">{{ $book->title }}</div>
                        <div class="book-author">{{ $book->author }}</div>
                        @if($book->genre)
                            <div class="book-genre">{{ $book->genre }}</div>
                        @endif
                        <div class="book-availability {{ $book->available_copies > 0 ? 'available' : 'unavailable' }}">
                            {{ $book->available_copies > 0 ? $book->available_copies . ' Available' : 'Out of Stock' }}
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        {{ $books->links() }}
    @endif
</div>
@endsection
