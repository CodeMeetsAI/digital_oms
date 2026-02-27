<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

    <!-- CSS files -->
    <link href="{{ asset('dist/css/tabler.min.css') }}" rel="stylesheet" />
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }

        /* Left align sidebar nav links */
        .navbar-vertical .nav-link {
            justify-content: flex-start !important;
            text-align: left;
        }

        /* Ensure icon and text stay left-aligned */
        .navbar-vertical .nav-link-title {
            text-align: left;
        }

        /* Optional: tighten icon spacing */
        .navbar-vertical .nav-link-icon {
            margin-right: 0.75rem;
        }

        .custom-offcanvas {
            width: 150px;
            /* adjust as needed */
            max-width: 50%;
            /* optional for very small screens */
        }
    </style>

    <!-- Custom CSS for specific page.  -->
    @stack('page-styles')
    @livewireStyles
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
</head>

<body>

    <div class="page">
        @include('layouts.body.navbar')

        <div class="page-wrapper">
            @include('layouts.body.header')

            <div>
                @yield('content')
            </div>

            @include('layouts.body.footer')
        </div>
    </div>

    <!-- Core -->
    <script src="{{ asset('dist/js/tabler.min.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script>
        // Create an instance of Notyf
        const notyf = new Notyf({
            duration: 3000,
            position: {
                x: 'right',
                y: 'top',
            },
            types: [
                {
                    type: 'success',
                    background: '#00965e',
                    icon: {
                        className: 'ti ti-check',
                        tagName: 'i',
                        color: 'white'
                    }
                },
                {
                    type: 'error',
                    background: '#d63939',
                    icon: {
                        className: 'ti ti-x',
                        tagName: 'i',
                        color: 'white'
                    }
                }
            ]
        });

        // Handle Laravel Session Messages
        document.addEventListener('DOMContentLoaded', function() {
            @if (session()->has('success'))
                notyf.success("{{ session('success') }}");
            @endif

            @if (session()->has('error'))
                notyf.error("{{ session('error') }}");
            @endif

            @if (session()->has('status'))
                notyf.success("{{ session('status') }}");
            @endif
        });
    </script>
    {{--- Page Scripts ---}}
    @stack('page-scripts')

    @livewireScripts
</body>

</html>