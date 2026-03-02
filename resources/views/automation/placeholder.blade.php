@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    {{ $title ?? 'Settings Section' }}
                </h2>
                <div class="text-muted mt-1">Configure your system preferences for {{ strtolower($title ?? 'this module') }}.</div>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-md-3">
                @include('automation._sidebar')
            </div>
            <div class="col-md-9">
                <div class="card card-md">
                    <div class="card-body text-center py-5">
                        <img src="https://img.icons8.com/color/96/000000/under-construction.png" alt="Under Construction" class="mb-3">
                        <h2 class="mb-3">Feature Coming Soon</h2>
                        <p class="text-muted mx-auto" style="max-width: 400px;">
                            We are currently working hard to bring you the {{ strtolower($title ?? 'settings') }} module. Stay tuned for updates!
                        </p>
                        <div class="mt-4">
                            <a href="{{ route('automation.index') }}" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="15 6 9 12 15 18" /></svg>
                                Back to Settings
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
