@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('integrations.index') }}">Integrations</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Connection</li>
                    </ol>
                </nav>
                <h2 class="page-title">Edit Store Connection</h2>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                @livewire('integrations.integration-form', ['integrationId' => $integration->id])
            </div>
        </div>
    </div>
</div>
@endsection
