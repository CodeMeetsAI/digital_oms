@extends('layouts.auth')

@section('content')
<div class="mb-5">
    <h2 class="h2 mb-1" style="font-weight: 700; font-size: 1.75rem;">Forgot Password.</h2>
    <p class="text-muted">Enter your email address and your password will be reset and emailed to you.</p>
</div>

<form action="{{ route('password.email') }}" method="post" autocomplete="off" novalidate>
    @csrf

    <div class="mb-3">
        <label for="email" class="form-label required">Email Address</label>
        <div class="input-group input-group-flat">
            <span class="input-group-text bg-white border-end-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                   <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z"></path>
                   <path d="M3 7l9 6l9 -6"></path>
                </svg>
            </span>
            <input type="email" name="email" id="email" class="form-control border-start-0 ps-1 @error('email') is-invalid @enderror" placeholder="Enter email" value="{{ old('email') }}" required style="border-left: none;">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
    <div class="form-footer mb-3">
        <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill" style="background-color: #4F46E5; border-color: #4F46E5;">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" /><path d="M3 7l9 6l9 -6" /></svg>
            Send me new password
        </button>
    </div>
</form>

<div class="text-center text-muted">
    Forget it, <a href="{{ Route::has('tenant.login') ? route('tenant.login') : route('login') }}" class="text-primary fw-bold" style="color: #4F46E5 !important;">send me back</a> to the sign in screen.
</div>
@endsection
