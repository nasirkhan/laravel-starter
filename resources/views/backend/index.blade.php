@extends('backend.layouts.app')

@section ('title', 'Dashboard' . " - " . config('app.name'))

@section('breadcrumbs')
<li class="breadcrumb-item active"><i class="icon-speedometer"></i> Dashboard</li>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-8">
                <h4 class="card-title mb-0">Welcome to {{ config('app.name') }} Admin Dashboard.</h4>
                <div class="small text-muted">{{ date('D, F d, Y') }}</div>
            </div>

            <div class="col-sm-4 hidden-sm-down">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                    <button type="button" class="btn btn-primary float-right">
                        <i class="icon-cloud-download"></i>
                    </button>
                </div>
            </div>
        </div>


        <hr>

    </div>

</div>
<!-- / card -->

<div class="card-group mb-4">
    <div class="card text-white bg-info">
        <div class="card-body">
            <div class="h1 text-muted text-right mb-4">
                <i class="icon-people"></i>
            </div>
            <div class="text-value">87.500</div>
            <small class="text-muted text-uppercase font-weight-bold">Visitors</small>
            <div class="progress progress-xs mt-3 mb-0">
                <div class="progress-bar bg-warning" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
    <div class="card text-white bg-warning">
        <div class="card-body">
            <div class="h1 text-muted text-right mb-4">
                <i class="icon-user-follow"></i>
            </div>
            <div class="text-value">385</div>
            <small class="text-muted text-uppercase font-weight-bold">New Clients</small>
            <div class="progress progress-xs mt-3 mb-0">
                <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
    <div class="card text-white bg-success">
        <div class="card-body">
            <div class="h1 text-muted text-right mb-4">
                <i class="icon-basket-loaded"></i>
            </div>
            <div class="text-value">1238</div>
            <small class="text-muted text-uppercase font-weight-bold">Products sold</small>
            <div class="progress progress-xs mt-3 mb-0">
                <div class="progress-bar bg-warning" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
    <div class="card text-white bg-primary">
        <div class="card-body">
            <div class="h1 text-muted text-right mb-4">
                <i class="icon-pie-chart"></i>
            </div>
            <div class="text-value">28%</div>
            <small class="text-muted text-uppercase font-weight-bold">Returning Visitors</small>
            <div class="progress progress-xs mt-3 mb-0">
                <div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
    <div class="card text-white bg-danger">
        <div class="card-body">
            <div class="h1 text-muted text-right mb-4">
                <i class="icon-speedometer"></i>
            </div>
            <div class="text-value">5:34:11</div>
            <small class="text-muted text-uppercase font-weight-bold">Avg. Time</small>
            <div class="progress progress-xs mt-3 mb-0">
                <div class="progress-bar bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-6 col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="text-value">89.9%</div>
                <div>Lorem ipsum...</div>
                <div class="progress progress-xs my-2">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-muted">Lorem ipsum dolor sit amet enim.</small>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="text-value">12.124</div>
                <div>Lorem ipsum...</div>
                <div class="progress progress-xs my-2">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-muted">Lorem ipsum dolor sit amet enim.</small>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="text-value">$98.111,00</div>
                <div>Lorem ipsum...</div>
                <div class="progress progress-xs my-2">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-muted">Lorem ipsum dolor sit amet enim.</small>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="text-value">2 TB</div>
                <div>Lorem ipsum...</div>
                <div class="progress progress-xs my-2">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-muted">Lorem ipsum dolor sit amet enim.</small>
            </div>
        </div>
    </div>

</div>
@endsection
