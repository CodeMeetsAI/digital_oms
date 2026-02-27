<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>{{ config('app.name') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
    <!-- CSS files -->
    <link href="{{ asset('dist/css/tabler.min.css') }}" rel="stylesheet"/>
    <style>
        @import url('https://rsms.me/inter/inter.css');
        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }
        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>

    <!-- Custom CSS for specific page.  -->
    @stack('page-styles')
</head>

<body class="d-flex flex-column bg-white">
    <div class="row g-0 flex-fill">
        <div class="col-12 col-lg-6 col-xl-6 d-none d-lg-block">
            <div class="bg-dark h-100 d-flex flex-column justify-content-between text-white p-5" style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%) !important;">
                 <div class="mb-4">
                     <!-- Branding/Logo -->
                     <h1 class="display-6" style="font-weight: 700; font-family: 'Inter Var', sans-serif;">Business Solution</h1>
                 </div>
                 <div class="mb-5">
                    <h1 class="display-4 mb-3" style="font-weight: 800;">Unleash your <br/>solution today. 🦥</h1>
                 </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xl-6 d-flex flex-column justify-content-center">
            <div class="container container-tight my-5 px-lg-5">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Libs JS -->
    <script src="{{ asset('dist/js/tabler.min.js') }}" defer></script>

    <!-- Custom JS for specific page.  -->
    @stack('page-scripts')
</body>
</html>
