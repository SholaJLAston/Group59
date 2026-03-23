@extends('layouts.auth')

@section('title', 'Verify Email')

@section('content')
    <section class="auth-page">
        <div class="auth-header">
            <h1>Verify Email</h1>
            <p>Confirm your email address to unlock your account.</p>
        </div>

        <div class="auth-card">
            <p class="auth-meta" style="margin-top: 0; text-align: left;">
                Thanks for signing up. Please verify your email via the link we just sent. If you did not receive it, use the button below.
            </p>

            @if (session('status') === 'verification-link-sent')
                <div class="auth-status success">A new verification link has been sent to your email address.</div>
            @endif

            <div class="auth-actions-inline">
                <form method="POST" action="{{ route('verification.send') }}" style="width: 100%;">
                    @csrf
                    <button type="submit" class="auth-btn">Resend Verification Email</button>
                </form>

                <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                    @csrf
                    <button type="submit" class="auth-btn secondary">Log Out</button>
                </form>
            </div>
        </div>
    </section>
@endsection
