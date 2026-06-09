@extends('layouts.app')
@section('title', 'Register')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-logo">
            <div class="auth-logo-icon">🏛️</div>
            <div class="auth-logo-text">Biblio<span>Tech</span></div>
        </div>
        <div class="auth-title">Create account</div>
        <div class="auth-subtitle">Join BiblioTech and start borrowing books</div>

        @if($errors->any())
            <div class="alert alert-danger" style="margin-top:1.25rem;">
                ⚠
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}" style="margin-top:1.5rem;">
            @csrf
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Your full name">
                @error('name') <div class="form-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="you@example.com">
                @error('email') <div class="form-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="phone">Phone <span style="font-weight:400;text-transform:none;letter-spacing:0;">(optional)</span></label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+212 6XX XXX XXX">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Min. 8 characters">
                @error('password') <div class="form-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Repeat password">
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:0.75rem;font-size:0.95rem;">Create Account</button>
        </form>

        <div style="text-align:center;margin-top:1.5rem;font-size:0.875rem;color:var(--muted);">
            Already have an account?
            <a href="{{ route('login') }}" style="color:var(--accent);text-decoration:none;font-weight:600;"> Sign In</a>
        </div>
    </div>
</div>
@endsection
