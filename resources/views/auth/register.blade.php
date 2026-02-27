@extends('layouts.auth')

@section('content')
<div class="mb-5">
    <h2 class="h2 mb-1" style="font-weight: 700; font-size: 1.75rem;">Create Your Account.</h2>
    <p class="text-muted">Let's create your account and get started.</p>
</div>

<form action="{{ route('tenant.register') }}" method="POST" autocomplete="off">
    @csrf

    <div class="mb-3">
        <label class="form-label required">Name</label>
        <div class="input-group input-group-flat">
            <span class="input-group-text bg-white border-end-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                   <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                   <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                </svg>
            </span>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control border-start-0 ps-1 @error('name') is-invalid @enderror" placeholder="Your name" required style="border-left: none;">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label required">Email Address</label>
        <div class="input-group input-group-flat">
            <span class="input-group-text bg-white border-end-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                   <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z"></path>
                   <path d="M3 7l9 6l9 -6"></path>
                </svg>
            </span>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control border-start-0 ps-1 @error('email') is-invalid @enderror" placeholder="your@email.com" required style="border-left: none;">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label required">Username</label>
        <div class="input-group input-group-flat">
            <span class="input-group-text bg-white border-end-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-at" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                   <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                   <path d="M16 12v1.5a2.5 2.5 0 0 0 5 0v-1.5a9 9 0 1 0 -5.5 8.28"></path>
                </svg>
            </span>
            <input type="text" name="username" value="{{ old('username') }}" class="form-control border-start-0 ps-1 @error('username') is-invalid @enderror" placeholder="Your username" required style="border-left: none;">
            @error('username')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label required">Password</label>
        <div class="input-group input-group-flat">
            <span class="input-group-text bg-white border-end-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-lock" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                   <path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z"></path>
                   <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0"></path>
                   <path d="M8 11v-4a4 4 0 1 1 8 0v4"></path>
                </svg>
            </span>
            <input type="password" name="password" class="form-control border-start-0 ps-1 @error('password') is-invalid @enderror" placeholder="Password" required style="border-left: none;">
            <span class="input-group-text bg-white">
                <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg>
                </a>
            </span>
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label required">Password Confirmation</label>
        <div class="input-group input-group-flat">
            <span class="input-group-text bg-white border-end-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-lock-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                   <path d="M11.5 21h-4.5a2 2 0 0 1 -2 -2v-6a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v.5"></path>
                   <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0"></path>
                   <path d="M8 11v-4a4 4 0 1 1 8 0v4"></path>
                   <path d="M15 19l2 2l4 -4"></path>
                </svg>
            </span>
            <input type="password" name="password_confirmation" class="form-control border-start-0 ps-1 @error('password_confirmation') is-invalid @enderror" placeholder="Password confirmation" required style="border-left: none;">
            <span class="input-group-text bg-white">
                <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg>
                </a>
            </span>
            @error('password_confirmation')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3">
        <label class="form-check">
            <input type="checkbox" name="terms-of-service" id="terms-of-service" class="form-check-input @error('terms-of-service') is-invalid @enderror">
            <span class="form-check-label">
                Agree the <a href="./terms-of-service.html" tabindex="-1">terms and policy</a>.
            </span>
        </label>
    </div>

    <div class="form-footer mb-3">
        <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill" style="background-color: #4F46E5; border-color: #4F46E5;">
            Create new account
        </button>
    </div>
</form>

<div class="text-center mt-3 text-muted">
    Already have account? <a href="{{ route('tenant.login') }}" tabindex="-1" class="text-primary fw-bold" style="color: #4F46E5 !important;">Sign in</a>
</div>
@endsection
