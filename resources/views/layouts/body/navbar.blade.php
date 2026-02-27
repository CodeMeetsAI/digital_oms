<!-- Desktop Sidebar -->
<aside class="navbar navbar-vertical navbar-expand-lg navbar-dark bg-dark d-none d-lg-block">
    <div class="container-fluid h-100 d-flex flex-column">
        <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center">
            <!-- <img src="/logo.svg" height="32" alt="Logo"> -->
        </a>
        <div class="collapse navbar-collapse show flex-grow-1 overflow-auto">
            <ul class="navbar-nav pt-lg-3">
                @include('layouts.body.menu-items')
            </ul>
        </div>
        <!-- Sidebar Footer -->
        <div class="mt-auto border-top-dark py-3">
            @include('layouts.body.settings-item')
        </div>
    </div>
</aside>

<!-- Mobile Offcanvas Menu -->
<div class="offcanvas offcanvas-start bg-dark navbar-dark d-lg-none"
    id="sidebar-menu"
    tabindex="-1"
    style="width: 230px;">

    <div class="offcanvas-header d-flex justify-content-between align-items-center">
        <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center">
            <img src="/logo.svg" height="32" alt="Logo">
        </a>

        <a href="#" class="text-white" data-bs-dismiss="offcanvas" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x"
                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z"></path>
                <path d="M18 6l-12 12"></path>
                <path d="M6 6l12 12"></path>
            </svg>
        </a>
    </div>

    <div class="offcanvas-body d-flex flex-column">
        <div class="flex-grow-1 overflow-auto">
            <ul class="navbar-nav">
                @include('layouts.body.menu-items')
            </ul>
        </div>
        <div class="mt-auto border-top-dark py-3">
            @include('layouts.body.settings-item')
        </div>
    </div>
</div>