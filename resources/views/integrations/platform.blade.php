@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('automation.integrations.index') }}">Integrations</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $config['name'] }}</li>
                    </ol>
                </nav>
                <h2 class="page-title">Connect {{ $config['name'] }}</h2>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form id="integrationForm" class="card">
                    @csrf
                    <input type="hidden" name="platform" value="{{ $config['slug'] }}">
                    <div class="card-header"><h3 class="card-title">Credentials & Permissions</h3></div>
                    <div class="card-body">
                        <div class="row row-cards">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Store Nickname</label>
                                <input type="text" name="store_nickname" class="form-control" placeholder="e.g. Main Shop" value="{{ $existing->store_nickname ?? '' }}" required>
                            </div>
                            <input type="url" name="store_url" class="form-control" 
placeholder="https://toysjedda.com/" 
value="{{ $existing->store_url ?? '' }}" required>
                            <div class="col-12 mb-3">
                                <label class="form-label required">API Key / Access Token</label>
                                <input type="text" name="api_key" class="form-control" required>
                                @if($existing) <small class="text-info italic">Leave empty to keep existing key (if manual entry allowed, otherwise required)</small> @endif
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Secret Key (If required)</label>
                                <input type="password" name="secret_key" class="form-control">
                            </div>
                        </div>

                        <div class="divider">Permissions</div>
                        <div class="row g-3 mt-2">
                            @php
                                $perms = [
                                    'fetch_products' => 'Fetch Products from Platform',
                                    'auto_import_orders' => 'Auto Import Orders',
                                    'sync_stock' => 'Sync Stock from OMS to Platform',
                                    'update_product' => 'Update Products Details',
                                    'push_fulfillment' => 'Push Fulfillment Status'
                                ];
                            @endphp
                            @foreach($perms as $key => $label)
                            <div class="col-md-6">
                                <label class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="{{ $key }}" value="1" {{ ($existing && $existing->$key) ? 'checked' : '' }}>
                                    <span class="form-check-label">{{ $label }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" id="connectBtn" class="btn btn-primary">
                            <span class="spinner-border spinner-border-sm me-2 d-none" role="status"></span>
                            Connect Account
                        </button>
                    </div>
                </form>

                <div id="responseMsg" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('integrationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('connectBtn');
    const spinner = btn.querySelector('.spinner-border');
    const msgDiv = document.getElementById('responseMsg');
    
    // UI Feedback
    btn.disabled = true;
    spinner.classList.remove('d-none');
    msgDiv.innerHTML = '';

    const formData = new FormData(this);

    fetch('{{ route("automation.integrations.connect") }}', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            msgDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
            setTimeout(() => window.location.href = '{{ route("automation.integrations.index") }}', 1500);
        } else {
            msgDiv.innerHTML = `<div class="alert alert-danger">Error: ${data.message || 'Validation failed.'}</div>`;
        }
    })
    .catch(error => {
        msgDiv.innerHTML = `<div class="alert alert-danger">Critical system error occurred.</div>`;
    })
    .finally(() => {
        btn.disabled = false;
        spinner.classList.add('d-none');
    });
});
</script>
@endsection
