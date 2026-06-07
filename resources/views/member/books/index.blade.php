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
        
        <label class="filter-label" style="display:flex;align-items:center;gap:0.4rem;cursor:pointer;">
            <input type="checkbox" name="available" value="1" {{ request('available') ? 'checked' : '' }} style="width:auto;">
            Available Only
        </label>
        
        <button type="submit" class="btn btn-primary">Filter</button>
        @if(request()->hasAny(['search', 'genre', 'available']))
            <a href="{{ route('member.books.index') }}" class="btn btn-secondary">Clear</a>
        @endif
    </form>

    @if($books->isEmpty())
        <div style="text-align:center;padding:4rem 0;color:var(--muted);">
            <div style="font-size:3rem;margin-bottom:1rem;">📚</div>
            <h2>No books found</h2>
            <p>Try adjusting your search or filters.</p>
        </div>
    @else
        <div class="books-grid">
            @foreach($books as $book)
            <a href="{{ route('member.books.show', $book) }}" style="text-decoration:none;color:inherit;display:block;">
                <div class="book-card">
                    @if($book->cover_image)
                        <img src="{{ $book->cover_image }}" alt="{{ $book->title }}" class="book-cover">
                    @else
                        <div class="book-cover" style="display:flex;align-items:center;justify-content:center;font-size:2rem;">📚</div>
                    @endif
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
        <div class="pagination">
            {{ $books->links() }}
        </div>
    @endif
</div>
@endsection
