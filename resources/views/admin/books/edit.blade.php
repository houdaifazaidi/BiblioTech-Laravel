@extends('layouts.admin')
@section('title', 'Edit Book')
@section('page-title', 'Edit Book')

@section('content')
<div style="max-width:820px;">
    <a href="{{ route('admin.books.index') }}" class="btn btn-secondary btn-sm" style="margin-bottom:1.5rem;">← Back to Books</a>

    <div class="card">
        <div class="card-title" style="padding-bottom:1rem;border-bottom:1px solid var(--border);margin-bottom:1.5rem;">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit Book Details
        </div>
        <form method="POST" action="{{ route('admin.books.update', $book) }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label for="title">Title *</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $book->title) }}" required>
                    @error('title') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="author">Author *</label>
                    <input type="text" id="author" name="author" value="{{ old('author', $book->author) }}" required>
                    @error('author') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="isbn">ISBN</label>
                    <input type="text" id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}">
                    @error('isbn') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="publisher">Publisher</label>
                    <input type="text" id="publisher" name="publisher" value="{{ old('publisher', $book->publisher) }}">
                </div>
                <div class="form-group">
                    <label for="published_year">Published Year</label>
                    <input type="number" id="published_year" name="published_year" value="{{ old('published_year', $book->published_year) }}" min="1000" max="{{ date('Y') + 1 }}">
                </div>
                <div class="form-group">
                    <label for="genre">Genre</label>
                    <input type="text" id="genre" name="genre" value="{{ old('genre', $book->genre) }}">
                </div>
                <div class="form-group">
                    <label for="total_copies">Total Copies *</label>
                    <input type="number" id="total_copies" name="total_copies" value="{{ old('total_copies', $book->total_copies) }}" min="1" required>
                    <div style="font-size:0.72rem;color:var(--muted);margin-top:0.35rem;">Currently available: <strong style="color:var(--success);">{{ $book->available_copies }}</strong></div>
                    @error('total_copies') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="cover_image">Replace Cover Image</label>
                    @if($book->cover_image)
                        <div style="margin-bottom:0.75rem;display:flex;align-items:center;gap:0.85rem;padding:0.75rem;background:var(--surface2);border-radius:8px;border:1px solid var(--border);">
                            <img src="{{ $book->cover_image }}" alt="Current cover"
                                 style="height:72px;border-radius:6px;box-shadow:0 2px 8px rgba(0,0,0,0.2);flex-shrink:0;">
                            <div style="font-size:0.75rem;color:var(--muted);">Current cover — upload a new file below to replace it.</div>
                        </div>
                    @endif
                    <input type="file" id="cover_image" name="cover_image" accept="image/*">
                    @error('cover_image') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group" style="margin-top:0.5rem;">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5" style="resize:vertical;" placeholder="Write a short synopsis…">{{ old('description', $book->description) }}</textarea>
            </div>

            <div style="display:flex;gap:0.75rem;padding-top:1rem;border-top:1px solid var(--border);">
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Update Book
                </button>
                <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
