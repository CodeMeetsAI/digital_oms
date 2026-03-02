@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('automation.index') }}">Settings</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('automation.integrations.index') }}">Integrations</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $integration->name }}</li>
                    </ol>
                </nav>
                <h2 class="page-title">
                    {{ $integration->name }} Integration
                </h2>
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
                @livewire('automation.integration-manager', ['integrationSlug' => $slug])
            </div>
        </div>
    </div>
</div>
@endsection
