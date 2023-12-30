@extends('admintheme::layouts.master')
@section('content')
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-xl-4 row-cols-xxl-4">
    <div class="col">
        <div class="card radius-10 border-0 border-start border-primary border-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="">
                        <p class="mb-1">Total Orders</p>
                        <h4 class="mb-0 text-primary">248</h4>
                    </div>
                    <div class="ms-auto widget-icon bg-primary text-white">
                        <i class="bi bi-basket2-fill"></i>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 4.5px;">
                    <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="75"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 border-0 border-start border-success border-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="">
                        <p class="mb-1">Total Revenue</p>
                        <h4 class="mb-0 text-success">$1,245</h4>
                    </div>
                    <div class="ms-auto widget-icon bg-success text-white">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 4.5px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 75%;" aria-valuenow="75"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 border-0 border-start border-danger border-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="">
                        <p class="mb-1">Bounce Rate</p>
                        <h4 class="mb-0 text-danger">24.25%</h4>
                    </div>
                    <div class="ms-auto widget-icon bg-danger text-white">
                        <i class="bi bi-graph-down-arrow"></i>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 4.5px;">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 75%;" aria-valuenow="75"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 border-0 border-start border-warning border-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="">
                        <p class="mb-1">New Users</p>
                        <h4 class="mb-0 text-warning">214</h4>
                    </div>
                    <div class="ms-auto widget-icon bg-warning text-dark">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 4.5px;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 75%;" aria-valuenow="75"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-lg-6 col-xl-4 d-flex">
        <div class="card w-100">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center">
                    <div class="">
                        <h6 class="mb-0 fw-bold">Team Members</h6>
                    </div>
                    <div class="dropdown ms-auto">
                        <button type="button" class="btn-option dropdown-toggle dropdown-toggle-nocaret cursor-pointer"
                            data-bs-toggle="dropdown"><i class="bi bi-three-dots fs-4"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;">Another action</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="team-list">
                    <div class="d-flex align-items-center gap-3">
                        <div class="">
                            <img src="https://codervent.com/roksyn/demo/ltr/assets/images/avatars/01.png" alt="" width="50" height="50"
                                class="rounded-circle">
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">John Michael</h6>
                            <span
                                class="badge bg-success bg-success-subtle text-success border border-opacity-25 border-success">ONLINE</span>
                        </div>
                        <div class="">
                            <button class="btn btn-outline-primary rounded-5 btn-sm px-3">Add</button>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex align-items-center gap-3">
                        <div class="">
                            <img src="https://codervent.com/roksyn/demo/ltr/assets/images/avatars/02.png" alt="" width="50" height="50"
                                class="rounded-circle">
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">Samantha Ivy</h6>
                            <span class="badge bg-danger-subtle text-danger border border-opacity-25 border-danger">IN
                                MEETING</span>
                        </div>
                        <div class="">
                            <button class="btn btn-outline-primary rounded-5 btn-sm px-3">Add</button>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex align-items-center gap-3">
                        <div class="">
                            <img src="https://codervent.com/roksyn/demo/ltr/assets/images/avatars/03.png" alt="" width="50" height="50"
                                class="rounded-circle">
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">Alex Smith</h6>
                            <span
                                class="badge bg-warning-subtle text-warning border border-opacity-25 border-warning">OFFLINE</span>
                        </div>
                        <div class="">
                            <button class="btn btn-outline-primary rounded-5 btn-sm px-3">Add</button>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex align-items-center gap-3">
                        <div class="">
                            <img src="https://codervent.com/roksyn/demo/ltr/assets/images/avatars/04.png" alt="" width="50" height="50"
                                class="rounded-circle">
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">Alex Smith</h6>
                            <span
                                class="badge bg-danger-subtle text-danger border border-opacity-25 border-danger">OFFLINE</span>
                        </div>
                        <div class="">
                            <button class="btn btn-outline-primary rounded-5 btn-sm px-3">Add</button>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex align-items-center gap-3">
                        <div class="">
                            <img src="https://codervent.com/roksyn/demo/ltr/assets/images/avatars/02.png" alt="" width="50" height="50"
                                class="rounded-circle">
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">Samantha</h6>
                            <span
                                class="badge bg-success-subtle text-success border border-opacity-25 border-success">IN
                                MEETING</span>
                        </div>
                        <div class="">
                            <button class="btn btn-outline-primary rounded-5 btn-sm px-3">Add</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6 col-xl-4 d-flex">
        <div class="card w-100">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center">
                    <div class="">
                        <h6 class="mb-0 fw-bold">To do list</h6>
                    </div>
                    <div class="dropdown ms-auto">
                        <button type="button" class="btn-option dropdown-toggle dropdown-toggle-nocaret cursor-pointer"
                            data-bs-toggle="dropdown"><i class="bi bi-three-dots fs-4"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;">Another action</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="team-list">
                    <div
                        class="d-flex align-items-center gap-3 border-start border-success border-4 border-0 px-2 py-1">
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">Meeeting with John</h6>
                            <span class="">10:56 PM</span>
                        </div>
                        <div class="form-check form-switch form-check-success border-0">
                            <input class="form-check-input border-1" type="checkbox" role="switch" checked="">
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex align-items-center gap-3 border-start border-danger border-4 border-0 px-2 py-1">
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">Meeeting with John</h6>
                            <span class="">10:56 PM</span>
                        </div>
                        <div class="form-check form-switch form-check-danger border-0">
                            <input class="form-check-input border-1" type="checkbox" role="switch" checked="">
                        </div>
                    </div>
                    <hr>
                    <div
                        class="d-flex align-items-center gap-3 border-start border-primary border-4 border-0 px-2 py-1">
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">Meeeting with John</h6>
                            <span class="">10:56 PM</span>
                        </div>
                        <div class="form-check form-switch form-check-primary border-0">
                            <input class="form-check-input border-1" type="checkbox" role="switch" checked="">
                        </div>
                    </div>
                    <hr>
                    <div
                        class="d-flex align-items-center gap-3 border-start border-warning border-4 border-0 px-2 py-1">
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">Meeeting with John</h6>
                            <span class="">10:56 PM</span>
                        </div>
                        <div class="form-check form-switch form-check-warning border-0">
                            <input class="form-check-input border-1" type="checkbox" role="switch" checked="">
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex align-items-center gap-3 border-start border-info border-4 border-0 px-2 py-1">
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">Meeeting with John</h6>
                            <span class="">10:56 PM</span>
                        </div>
                        <div class="form-check form-switch form-check-info border-0">
                            <input class="form-check-input border-1" type="checkbox" role="switch" checked="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-12 col-xl-4 d-flex">
        <div class="card w-100">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center">
                    <div class="">
                        <h6 class="mb-0 fw-bold">Projects</h6>
                    </div>
                    <div class="dropdown ms-auto">
                        <button type="button" class="btn-option dropdown-toggle dropdown-toggle-nocaret cursor-pointer"
                            data-bs-toggle="dropdown"><i class="bi bi-three-dots fs-4"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;">Another action</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="team-list">
                    <div class="d-flex align-items-center gap-3">
                        <div class="widget-icon bg-transparent border rounded-3">
                            <img src="https://codervent.com/roksyn/demo/ltr/assets/images/icons/apple.png" alt="" width="30">
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-2 fw-bold">Angular 12 Dashboard</p>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="75"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex align-items-center gap-3">
                        <div class="widget-icon bg-transparent border rounded-3">
                            <img src="https://codervent.com/roksyn/demo/ltr/assets/images/icons/bootstrap.png" alt="" width="30">
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-2 fw-bold">Angular 12 Dashboard</p>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar" role="progressbar" style="width: 70%;" aria-valuenow="75"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex align-items-center gap-3">
                        <div class="widget-icon bg-transparent border rounded-3">
                            <img src="https://codervent.com/roksyn/demo/ltr/assets/images/icons/google-2.png" alt="" width="30">
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-2 fw-bold">Angular 12 Dashboard</p>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar" role="progressbar" style="width: 65%;" aria-valuenow="75"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex align-items-center gap-3">
                        <div class="widget-icon bg-transparent border rounded-3">
                            <img src="https://codervent.com/roksyn/demo/ltr/assets/images/icons/spotify.png" alt="" width="30">
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-2 fw-bold">Angular 12 Dashboard</p>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar" role="progressbar" style="width: 55%;" aria-valuenow="75"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex align-items-center gap-3">
                        <div class="widget-icon bg-transparent border rounded-3">
                            <img src="https://codervent.com/roksyn/demo/ltr/assets/images/icons/outlook.png" alt="" width="30">
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-2 fw-bold">Angular 12 Dashboard</p>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar" role="progressbar" style="width: 45%;" aria-valuenow="75"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection