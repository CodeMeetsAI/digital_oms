@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <h2 class="page-title">Edit Template</h2>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                @livewire('template.template-edit', ['template' => $template])
            </div>
        </div>
    </div>
</div>
@endsection
