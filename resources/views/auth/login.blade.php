@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-title">Welcome back</div>
        <div class="auth-subtitle">Sign in to your BiblioTech account</div>

        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
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
            <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:1.25rem;">
                <input type="checkbox" id="remember" name="remember" style="width:auto;accent-color:#6366f1;">
                <label for="remember" style="margin:0;font-size:0.85rem;">Remember me</label>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:0.7rem;">Sign In</button>
        </form>

        <div style="text-align:center;margin-top:1.5rem;font-size:0.875rem;color:var(--muted);">
            Don't have an account?
            <a href="{{ route('register') }}" style="color:var(--accent);text-decoration:none;font-weight:500;"> Sign Up</a>
        </div>
    </div>
</div>
@endsection
