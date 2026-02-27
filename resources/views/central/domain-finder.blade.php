@extends('layouts.auth')

@section('content')
<div class="mb-5">
    <h2 class="h2 mb-1" style="font-weight: 700; font-size: 1.75rem;">Find Your Store.</h2>
    <p class="text-muted">Enter your store domain to proceed to your account.</p>
</div>

<form action="{{ route('domain.redirect') }}" method="POST" autocomplete="off">
    @csrf

    <div class="mb-3">
        <label class="form-label required">Domain Name</label>
        <div class="input-group input-group-flat">
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
            <input type="text" name="domain" class="form-control border-start-0 ps-1 @error('domain') is-invalid @enderror" placeholder="your-store" required style="border-left: none;">
            <span class="input-group-text">
                .{{ $centralDomain }}
            </span>
            @error('domain')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="form-footer mb-3">
        <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill" style="background-color: #4F46E5; border-color: #4F46E5;">
            Proceed
        </button>
    </div>
</form>

<div class="text-center text-muted">
    Don't have an account? <a href="{{ route('register') }}" class="text-primary fw-bold" style="color: #4F46E5 !important;">Create your store</a>
</div>
@endsection