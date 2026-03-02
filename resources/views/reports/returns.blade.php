@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <h2 class="page-title">Returns Reports</h2>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-md-3">
                @include('reports._sidebar')
            </div>
            <div class="col-md-9">
                @livewire('reports.return-report-manager')
            </div>
        </div>
    </div>
</div>
@endsection
