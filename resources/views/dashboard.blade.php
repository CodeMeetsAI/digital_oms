@extends('layouts.tabler')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Hello {{ auth()->user()->name }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <!-- Left Column: Onboarding Steps -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col">
                                    <h3 class="card-title mb-1">Onboarding Steps</h3>
                                    <p class="text-muted">Connect your ecommerce platforms, and start managing your inventory, orders and financials.</p>
                                </div>
                                <div class="col-auto">
                                    <div class="d-flex gap-3">
                                        <div class="text-center">
                                            <div class="text-muted small uppercase font-weight-bold">STEPS</div>
                                            <div class="h3 mb-0">8 steps left</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-muted small uppercase font-weight-bold">TIME TO COMPLETE</div>
                                            <div class="h3 mb-0">1 h 20 min</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="vstack gap-3">
                                <!-- Step 1 -->
                                <div class="card card-sm border">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span class="avatar bg-green text-white rounded-circle">01</span>
                                            </div>
                                            <div class="col">
                                                <div class="font-weight-medium">Get to know about this</div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="chart-progress" style="width: 40px; height: 40px; position: relative; display: flex; align-items: center; justify-content: center;">
                                                    <span class="small fw-bold">0%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 2 -->
                                <div class="card card-sm border">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span class="avatar bg-green text-white rounded-circle">02</span>
                                            </div>
                                            <div class="col">
                                                <div class="font-weight-medium">How to add an Integration</div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="position-relative" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                     <!-- Simple SVG Circle Progress -->
                                                    <svg viewBox="0 0 36 36" style="position: absolute; width: 100%; height: 100%; transform: rotate(-90deg);">
                                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#eee" stroke-width="4" />
                                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#0ca678" stroke-width="4" stroke-dasharray="50, 100" />
                                                    </svg>
                                                    <span class="small fw-bold">50%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 3 -->
                                <div class="card card-sm border">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span class="avatar bg-green text-white rounded-circle">03</span>
                                            </div>
                                            <div class="col">
                                                <div class="font-weight-medium">How to add a Product</div>
                                            </div>
                                            <div class="col-auto">
                                                 <div class="chart-progress" style="width: 40px; height: 40px; position: relative; display: flex; align-items: center; justify-content: center;">
                                                    <span class="small fw-bold">0%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 4 -->
                                <div class="card card-sm border">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span class="avatar bg-green text-white rounded-circle">04</span>
                                            </div>
                                            <div class="col">
                                                <div class="font-weight-medium">How to add a Supplier</div>
                                            </div>
                                            <div class="col-auto">
                                                 <div class="chart-progress" style="width: 40px; height: 40px; position: relative; display: flex; align-items: center; justify-content: center;">
                                                    <span class="small fw-bold">0%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Support & Learn More -->
                <div class="col-lg-4">
                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-3">
                             <img src="{{ asset('static/logo.svg') }}" width="24" height="24" alt="Logo" class="me-2">
                             <h3 class="mb-0">Retail Support</h3>
                        </div>
                        <h4 class="mb-2">Visit Our Help Center</h4>
                        <p class="text-muted mb-4">
                            Looking for assistance? Head over to our Help Center, where you'll find answers to frequently asked questions and helpful resources. Our team is here to support you!
                        </p>
                        
                    </div>

                    <div>
                        <h4 class="mb-3">Learn more about Retail</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
