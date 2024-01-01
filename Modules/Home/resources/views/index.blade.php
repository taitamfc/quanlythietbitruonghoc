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
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection