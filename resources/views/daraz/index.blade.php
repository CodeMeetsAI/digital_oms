<h2>Daraz Integration</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<form method="POST" action="/daraz">
    @csrf

    <input type="text" name="store_nickname" placeholder="Store Name"><br><br>
    <input type="text" name="contact_number" placeholder="Contact Number"><br><br>
    <input type="email" name="email" placeholder="Email"><br><br>
    <input type="text" name="api_url" placeholder="API URL"><br><br>
    <input type="text" name="api_key" placeholder="API Key"><br><br>
    <input type="text" name="api_secret" placeholder="API Secret"><br><br>

    <button type="submit">Save</button>
</form>

<hr>

<h3>Saved Data</h3>

@foreach($data as $item)
    <p>{{ $item->store_nickname }} - {{ $item->email }}</p>
@endforeach