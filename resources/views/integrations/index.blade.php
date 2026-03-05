@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Marketplace Integrations</h2>
                <div class="text-muted mt-1">Connect and manage your external store accounts.</div>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            @foreach($platforms as $slug => $data)
            <div class="col-md-6 col-lg-3">
                <div class="card card-stacked">
                    @if(in_array($slug, $connectedPlatforms))
                        <div class="ribbon bg-green">Connected</div>
                    @endif
                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            <img src="{{ $data['logo'] }}" alt="{{ $data['name'] }}" style="height: 80px;">
                        </div>
                        <h3 class="m-0 mb-1">{{ $data['name'] }}</h3>
                        <div class="text-muted small">{{ $data['description'] }}</div>
                        <div class="mt-3">
                            <a href="{{ route('automation.integrations.platform.config', $slug) }}" class="btn btn-outline-primary w-100">
                                {{ in_array($slug, $connectedPlatforms) ? 'Configure' : 'Connect' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
