@extends('layouts.admin')
@section('title', 'Add Book')
@section('page-title', 'Add New Book')

@section('content')
<div style="max-width:800px;">
    <a href="{{ route('admin.books.index') }}" class="btn btn-secondary btn-sm" style="margin-bottom:1.5rem;">← Back to Books</a>

    <div class="card">
        <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label for="title">Title *</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="author">Author *</label>
                    <input type="text" id="author" name="author" value="{{ old('author') }}" required>
                    @error('author') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="isbn">ISBN</label>
                    <input type="text" id="isbn" name="isbn" value="{{ old('isbn') }}" placeholder="e.g. 9780743273565">
                    @error('isbn') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="publisher">Publisher</label>
                    <input type="text" id="publisher" name="publisher" value="{{ old('publisher') }}">
                </div>
                <div class="form-group">
                    <label for="published_year">Published Year</label>
                    <input type="number" id="published_year" name="published_year" value="{{ old('published_year') }}" min="1000" max="{{ date('Y') + 1 }}">
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
                    <div style="font-size:0.75rem;color:var(--muted);margin-top:0.3rem;">Uploaded to Cloudinary. Max 5MB.</div>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" style="resize:vertical;">{{ old('description') }}</textarea>
            </div>

            <div style="display:flex;gap:0.75rem;">
                <button type="submit" class="btn btn-primary">Create Book</button>
                <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
