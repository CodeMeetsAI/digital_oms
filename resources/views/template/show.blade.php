@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">{{ $template->name }}</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('template.edit', $template->id) }}" class="btn btn-primary d-none d-sm-inline-block">Edit Template</a>
                    <button class="btn btn-secondary d-none d-sm-inline-block" onclick="window.print();">Print</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div class="template-content p-4 border rounded bg-light">
                    {!! $template->content !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
