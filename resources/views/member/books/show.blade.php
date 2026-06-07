@extends('layouts.app')
@section('title', $book->title)

@section('content')
<div class="container" style="padding-top:2rem;">
    <a href="{{ route('member.books.index') }}" class="btn btn-secondary btn-sm" style="margin-bottom:2rem;">← Back to Catalog</a>

    <div class="card" style="display:flex;gap:3rem;flex-wrap:wrap;">
        <div style="flex:1;min-width:280px;max-width:350px;">
            @if($book->cover_image)
                <img src="{{ $book->cover_image }}" alt="{{ $book->title }}" style="width:100%;border-radius:var(--radius);box-shadow:0 20px 40px rgba(0,0,0,0.4);">
            @else
                <div style="width:100%;aspect-ratio:2/3;background:var(--surface2);border-radius:var(--radius);display:flex;align-items:center;justify-content:center;font-size:4rem;">📚</div>
            @endif
        </div>
        
        <div style="flex:2;min-width:300px;display:flex;flex-direction:column;justify-content:center;">
            @if($book->genre)
                <div style="margin-bottom:1rem;"><span class="badge badge-active">{{ $book->genre }}</span></div>
            @endif
            
            <h1 style="font-size:2.5rem;font-weight:700;margin-bottom:0.5rem;line-height:1.2;">{{ $book->title }}</h1>
            <div style="font-size:1.25rem;color:var(--muted);margin-bottom:2rem;">by {{ $book->author }}</div>
            
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:2rem;padding:1.5rem;background:rgba(255,255,255,0.03);border-radius:var(--radius);">
                <div>
                    <div style="font-size:0.75rem;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:0.25rem;">Availability</div>
                    <div style="font-size:1.1rem;font-weight:600;color:{{ $book->available_copies > 0 ? 'var(--success)' : 'var(--danger)' }};">
                        {{ $book->available_copies }} of {{ $book->total_copies }} copies available
                    </div>
                </div>
                <div>
                    <div style="font-size:0.75rem;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:0.25rem;">Publisher</div>
                    <div style="font-size:1.1rem;font-weight:500;">{{ $book->publisher ?? 'Unknown' }} ({{ $book->published_year ?? 'N/A' }})</div>
                </div>
                <div>
                    <div style="font-size:0.75rem;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:0.25rem;">ISBN</div>
                    <div style="font-size:1.1rem;font-weight:500;">{{ $book->isbn ?? 'N/A' }}</div>
                </div>
            </div>
            
            @if($book->description)
                <div style="margin-bottom:2rem;">
                    <h3 style="font-size:1rem;margin-bottom:0.75rem;">Synopsis</h3>
                    <p style="color:var(--muted);line-height:1.6;">{{ nl2br(e($book->description)) }}</p>
                </div>
            @endif

            <div style="margin-top:auto;padding-top:2rem;border-top:1px solid var(--border);">
                @auth('web')
                    @if($alreadyBorrowed)
                        <div class="alert alert-success" style="margin-bottom:0;">You are currently borrowing this book.</div>
                    @elseif($book->available_copies > 0)
                        <form method="POST" action="{{ route('member.loans.store') }}">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            <button type="submit" class="btn btn-primary" style="padding:0.75rem 2rem;font-size:1rem;">Borrow Book (14 days)</button>
                        </form>
                    @else
                        <button class="btn btn-secondary" style="padding:0.75rem 2rem;font-size:1rem;" disabled>Currently Unavailable</button>
                    @endif
                @else
                    <div style="display:flex;align-items:center;gap:1rem;">
                        <a href="{{ route('login') }}" class="btn btn-primary">Log in to borrow</a>
                        <span style="color:var(--muted);font-size:0.875rem;">Don't have an account? <a href="{{ route('register') }}" style="color:var(--accent);">Sign up</a></span>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
