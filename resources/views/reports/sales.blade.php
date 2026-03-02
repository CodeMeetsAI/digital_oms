@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <h2 class="page-title">Sales Reports</h2>
        <div class="text-muted mt-1">Analyze your sales performance across multiple dimensions.</div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-md-3">
                @include('reports._sidebar')
            </div>
            <div class="col-md-9">
                @livewire('reports.sales-report-manager')
            </div>
        </div>
    </div>
</div>
@endsection
