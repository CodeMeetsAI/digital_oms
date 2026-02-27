@extends('layouts.auth')

@section('content')
<div class="mb-5">
    <h2 class="h2 mb-1" style="font-weight: 700; font-size: 1.75rem;">Register Your Company.</h2>
    <p class="text-muted">Let's create your company and get started.</p>
</div>

<form action="{{ route('register') }}" method="POST" autocomplete="off">
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
            <input type="text" name="name" class="form-control border-start-0 ps-1 @error('name') is-invalid @enderror" placeholder="Enter name" value="{{ old('name') }}" required style="border-left: none;">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label required">Email address</label>
        <div class="input-group input-group-flat">
            <span class="input-group-text bg-white border-end-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                   <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z"></path>
                   <path d="M3 7l9 6l9 -6"></path>
                </svg>
            </span>
            <input type="email" name="email" class="form-control border-start-0 ps-1 @error('email') is-invalid @enderror" placeholder="Enter email" value="{{ old('email') }}" required style="border-left: none;">
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
    
    <div class="mb-3">
        <label class="form-label required">Phone</label>
        <div class="input-group">
            <span class="input-group-text">+92</span>
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter phone" value="{{ old('phone') }}" required>
            @error('phone') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label required">Company Name</label>
        <div class="input-group">
            <span class="input-group-text bg-white border-end-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-building-store" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                   <path d="M3 21l18 0"></path>
                   <path d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4"></path>
                   <path d="M5 21l0 -10.15"></path>
                   <path d="M19 21l0 -10.15"></path>
                   <path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4"></path>
                </svg>
            </span>
            <input type="text" name="company_name" class="form-control border-start-0 ps-1 @error('company_name') is-invalid @enderror" placeholder="company-name" value="{{ old('company_name') }}" required style="border-left: none;">
            <span class="input-group-text">
                .{{ $centralDomain }}
            </span>
            @error('company_name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <small class="form-hint">Your app URL will be companyname.{{ $centralDomain }}</small>
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
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label required">Confirm Password</label>
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
            <input type="password" name="password_confirmation" class="form-control border-start-0 ps-1" placeholder="Confirm Password" required style="border-left: none;">
        </div>
    </div>

    <div class="form-footer mb-3">
        <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill" style="background-color: #4F46E5; border-color: #4F46E5;">Create Account</button>
    </div>
</form>

<div class="text-center text-muted">
    Already have account? <a href="{{ route('home') }}" tabindex="-1" class="text-primary fw-bold" style="color: #4F46E5 !important;">Sign in</a>
</div>
@endsection
