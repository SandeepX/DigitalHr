@extends('layouts.master')

@section('title','Admin dashboard')

@section('nav-head','Welcome to Attendance Dashboard : ' .ucfirst($dashboardDetail?->company_name))

@section('main-content')

    <section class="content">

        <div class="row">

            <div class="col-lg-4 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Total Employees</h6>
                            <div class="dropdown mb-2">
                                <button class="btn p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item d-flex align-items-center" href="{{route('admin.users.index')}}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5 ">
                                <h3 class="mb-2">{{number_format($dashboardDetail?->total_employee)}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Total Projects</h6>
                            <div class="dropdown mb-2">
                                <button class="btn p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item d-flex align-items-center" href="{{route('admin.projects.index')}}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5 ">
                                <h3 class="mb-2">{{number_format($dashboardDetail?->total_projects)}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Paid Leaves</h6>
                            <div class="dropdown mb-2">
                                <button class="btn p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item d-flex align-items-center" href="{{route('admin.leaves.index')}}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h3 class="mb-2">{{number_format($dashboardDetail?->total_paid_leaves) ?? 0}}</h3>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Total Holidays</h6>
                            <div class="dropdown mb-2">
                                <button class="btn p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item d-flex align-items-center" href="{{route('admin.holidays.index')}}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h3 class="mb-2">{{number_format($dashboardDetail?->total_holidays) ?? 0}}</h3>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">On Leave Today</h6>
                            <div class="dropdown mb-2">
                                <button class="btn p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item d-flex align-items-center" href="{{route('admin.leave-request.index')}}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h3 class="mb-2">{{number_format($dashboardDetail?->total_on_leave) ?? 0}}</h3>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-4 col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Pending Leave Requests</h6>
                            <div class="dropdown mb-2">
                                <button class="btn p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item d-flex align-items-center" href="{{route('admin.leave-request.index')}}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h3 class="mb-2">{{ number_format($dashboardDetail?->total_pending_leave_requests) ?? 0}}</h3>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Pending Early Exit Requests</h6>
                            <div class="dropdown mb-2">
                                <button class="btn p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item d-flex align-items-center" href="{{route('admin.leave-request.index')}}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h3 class="mb-2">{{ number_format($dashboardDetail?->total_urgent_leave_request) ?? 0}}</h3>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-4 col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Total Check In Today</h6>
                            <div class="dropdown mb-2">
                                <button class="btn p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item d-flex align-items-center" href="{{route('admin.attendances.index')}}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h3 class="mb-2">{{number_format($dashboardDetail?->total_checked_in_employee) ?? 0 }}</h3>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Total Check Out Today</h6>
                            <div class="dropdown mb-2">
                                <button class="btn p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item d-flex align-items-center" href="{{route('admin.attendances.index')}}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h3 class="mb-2">{{number_format($dashboardDetail?->total_checked_out_employee) ?? 0 }}</h3>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>
@endsection









