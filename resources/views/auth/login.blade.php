@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-logo">
            <div class="auth-logo-icon">🏛️</div>
            <div class="auth-logo-text">Biblio<span>Tech</span></div>
        </div>
        <div class="auth-title">Welcome back</div>
        <div class="auth-subtitle">Sign in to your BiblioTech account</div>

        @if($errors->any())
            <div class="alert alert-danger">⚠ {{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" style="margin-top:1.5rem;">
            @csrf
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="you@example.com">
                @error('email') <div class="form-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
            </div>
            <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:1.5rem;">
                <input type="checkbox" id="remember" name="remember" style="width:16px;height:16px;accent-color:var(--accent);cursor:pointer;flex-shrink:0;">
                <label for="remember" style="margin:0;font-size:0.875rem;text-transform:none;letter-spacing:0;font-weight:400;cursor:pointer;">Remember me</label>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:0.75rem;font-size:0.95rem;">Sign In</button>
        </form>

        <div style="text-align:center;margin-top:1.5rem;font-size:0.875rem;color:var(--muted);">
            Don't have an account?
            <a href="{{ route('register') }}" style="color:var(--accent);text-decoration:none;font-weight:600;"> Sign Up</a>
        </div>
    </div>
</div>
@endsection
