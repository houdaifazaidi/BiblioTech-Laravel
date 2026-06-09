@extends('layouts.admin')
@section('title', 'Add Book')
@section('page-title', 'Add New Book')

@section('content')
<div style="max-width:820px;">
    <a href="{{ route('admin.books.index') }}" class="btn btn-secondary btn-sm" style="margin-bottom:1.5rem;">← Back to Books</a>

    <div class="card">
        <div class="card-title" style="padding-bottom:1rem;border-bottom:1px solid var(--border);margin-bottom:1.5rem;">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Book Details
        </div>
        <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label for="title">Title *</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="Book title">
                    @error('title') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="author">Author *</label>
                    <input type="text" id="author" name="author" value="{{ old('author') }}" required placeholder="Author name">
                    @error('author') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="isbn">ISBN</label>
                    <input type="text" id="isbn" name="isbn" value="{{ old('isbn') }}" placeholder="e.g. 9780743273565">
                    @error('isbn') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="publisher">Publisher</label>
                    <input type="text" id="publisher" name="publisher" value="{{ old('publisher') }}" placeholder="Publisher name">
                </div>
                <div class="form-group">
                    <label for="published_year">Published Year</label>
                    <input type="number" id="published_year" name="published_year" value="{{ old('published_year') }}" min="1000" max="{{ date('Y') + 1 }}" placeholder="{{ date('Y') }}">
                </div>
                <div class="form-group">
                    <label for="genre">Genre</label>
                    <input type="text" id="genre" name="genre" value="{{ old('genre') }}" placeholder="e.g. Fiction, Science…">
                </div>
                <div class="form-group">
                    <label for="total_copies">Total Copies *</label>
                    <input type="number" id="total_copies" name="total_copies" value="{{ old('total_copies', 1) }}" min="1" required>
                    @error('total_copies') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="cover_image">Cover Image</label>
                    <input type="file" id="cover_image" name="cover_image" accept="image/*">
                    @error('cover_image') <div class="form-error">{{ $message }}</div> @enderror
                    <div style="font-size:0.72rem;color:var(--muted);margin-top:0.35rem;">Uploaded to Cloudinary. Max 5MB.</div>
                </div>
            </div>

            <div class="form-group" style="margin-top:0.5rem;">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5" style="resize:vertical;" placeholder="Write a short synopsis…">{{ old('description') }}</textarea>
            </div>

            <div style="display:flex;gap:0.75rem;padding-top:1rem;border-top:1px solid var(--border);">
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Create Book
                </button>
                <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
