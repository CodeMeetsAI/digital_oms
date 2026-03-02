@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <h2 class="page-title">Reports Dashboard</h2>
        <div class="text-muted mt-1">Select a report from the sidebar to view detailed analytics.</div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-md-3">
                @include('reports._sidebar')
            </div>
            <div class="col-md-9">
                <div class="card card-md h-100">
                    <div class="card-body text-center py-5 d-flex flex-column justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg text-muted mb-3" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="12" y1="8" x2="12" y2="12" /><line x1="12" y1="16" x2="12.01" y2="16" /></svg>
                        <h3>Welcome to Reports</h3>
                        <p class="text-muted">Choose a specific report category from the left menu to explore your data.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
