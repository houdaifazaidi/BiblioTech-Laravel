@extends('layouts.app')
@section('title', $book->title)

@push('styles')
<style>
.book-show-wrap {
    display: flex;
    gap: 3rem;
    flex-wrap: wrap;
    align-items: flex-start;
}
.book-show-cover-col {
    flex: 0 0 auto;
    width: 260px;
}
.book-show-cover-col img {
    width: 100%;
    border-radius: var(--radius);
    box-shadow: 0 24px 50px rgba(0,0,0,0.4);
    display: block;
}
.book-show-cover-placeholder {
    width: 100%;
    aspect-ratio: 2/3;
    background: var(--surface2);
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 4rem;
    border: 1px solid var(--border);
}
.book-show-info-col {
    flex: 1;
    min-width: 280px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.book-show-meta-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: var(--surface2);
    border-radius: var(--radius);
    border: 1px solid var(--border);
}
.book-show-meta-item {}
.book-show-meta-label {
    font-size: 0.72rem;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 0.3rem;
    font-weight: 600;
}
.book-show-meta-value {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text);
}
.book-show-borrow-area {
    padding-top: 1.75rem;
    border-top: 1px solid var(--border);
    margin-top: auto;
}
@media (max-width: 700px) {
    .book-show-cover-col { width: 100%; max-width: 280px; margin: 0 auto; }
    .book-show-wrap { flex-direction: column; gap: 2rem; }
    .book-show-meta-grid { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')
<div class="container" style="padding-top:2rem;">
    <a href="{{ route('member.books.index') }}" class="btn btn-secondary btn-sm" style="margin-bottom:2rem;">← Back to Catalog</a>

    <div class="card">
        <div class="book-show-wrap">

            {{-- Cover --}}
            <div class="book-show-cover-col">
                @if($book->cover_image)
                    <img src="{{ $book->cover_image }}" alt="{{ $book->title }}">
                @else
                    <div class="book-show-cover-placeholder">📚</div>
                @endif
            </div>

            {{-- Info --}}
            <div class="book-show-info-col">
                @if($book->genre)
                    <div style="margin-bottom:1rem;">
                        <span class="badge badge-returned">{{ $book->genre }}</span>
                    </div>
                @endif

                <h1 style="font-size:clamp(1.5rem,4vw,2.25rem);font-weight:800;margin-bottom:0.4rem;line-height:1.2;letter-spacing:-0.5px;">{{ $book->title }}</h1>
                <div style="font-size:1.1rem;color:var(--muted);margin-bottom:2rem;font-weight:500;">by {{ $book->author }}</div>

                <div class="book-show-meta-grid">
                    <div class="book-show-meta-item">
                        <div class="book-show-meta-label">Availability</div>
                        <div class="book-show-meta-value" style="color:{{ $book->available_copies > 0 ? 'var(--success)' : 'var(--danger)' }};">
                            {{ $book->available_copies }} / {{ $book->total_copies }} copies
                        </div>
                    </div>
                    <div class="book-show-meta-item">
                        <div class="book-show-meta-label">Publisher</div>
                        <div class="book-show-meta-value">{{ $book->publisher ?? 'Unknown' }}</div>
                    </div>
                    <div class="book-show-meta-item">
                        <div class="book-show-meta-label">Year</div>
                        <div class="book-show-meta-value">{{ $book->published_year ?? 'N/A' }}</div>
                    </div>
                    <div class="book-show-meta-item">
                        <div class="book-show-meta-label">ISBN</div>
                        <div class="book-show-meta-value" style="font-size:0.9rem; font-family:monospace;">{{ $book->isbn ?? 'N/A' }}</div>
                    </div>
                </div>

                @if($book->description)
                    <div style="margin-bottom:2rem;">
                        <h3 style="font-size:0.875rem;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:var(--muted);margin-bottom:0.75rem;">Synopsis</h3>
                        <p style="color:var(--muted);line-height:1.75;font-size:0.95rem;">{{ nl2br(e($book->description)) }}</p>
                    </div>
                @endif

                <div class="book-show-borrow-area">
                    @auth('web')
                        @if($alreadyBorrowed)
                            <div class="alert alert-success" style="margin-bottom:0;">✓ You are currently borrowing this book.</div>
                        @elseif($book->available_copies > 0)
                            <form method="POST" action="{{ route('member.loans.store') }}">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <button type="submit" class="btn btn-primary" style="padding:0.8rem 2.25rem;font-size:1rem;">
                                    📖 Borrow Book — 14 days
                                </button>
                            </form>
                        @else
                            <button class="btn btn-secondary" style="padding:0.8rem 2.25rem;font-size:1rem;" disabled>Currently Unavailable</button>
                        @endif
                    @else
                        <div style="display:flex;align-items:center;gap:1rem;flex-wrap:wrap;">
                            <a href="{{ route('login') }}" class="btn btn-primary">Log in to borrow</a>
                            <span style="color:var(--muted);font-size:0.875rem;">Don't have an account? <a href="{{ route('register') }}" style="color:var(--accent);font-weight:600;">Sign up</a></span>
                        </div>
                    @endauth
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
