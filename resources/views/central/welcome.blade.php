<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <title>{{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css" rel="stylesheet"/>
  </head>
  <body class="d-flex flex-column">
    <div class="page page-center">
      <div class="container container-tight py-4">
        <div class="text-center mb-4">
           <h1>Welcome to {{ config('app.name') }}</h1>
        </div>
        <div class="card card-md">
          <div class="card-body text-center">
            <p class="mb-4">Manage your retail business with ease.</p>
            <a href="{{ route('register') }}" class="btn btn-primary w-100">Get Started</a>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
