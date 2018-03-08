@extends('backend.layouts.app')

@section ('title', 'Dashboard' . " - " . config('app.name'))

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">Welcome</h4>
                <div class="small text-muted">{{ date('D, F d, Y') }}</div>
            </div>

            <div class="col-sm-7 hidden-sm-down">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                    <button type="button" class="btn btn-primary float-right">
                        <i class="icon-cloud-download"></i>
                    </button>
                </div>
            </div>
        </div>
        <!--/.row-->

        <hr>

        <div class="row">
            <div class="col">
                @auth
                Welcome to {{ config('app.name') }} Admin Dashboard.
                @endauth
            </div>
        </div>
        <!--/.row-->
    </div>
    <div class="card-footer">
        <ul>
            <li>
                <div class="text-muted">Visits</div>
                <strong>29.703 Users (40%)</strong>
                <div class="progress progress-xs mt-2">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </li>
            <li class="hidden-sm-down">
                <div class="text-muted">Unique</div>
                <strong>24.093 Users (20%)</strong>
                <div class="progress progress-xs mt-2">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </li>
            <li>
                <div class="text-muted">Pageviews</div>
                <strong>78.706 Views (60%)</strong>
                <div class="progress progress-xs mt-2">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </li>
            <li class="hidden-sm-down">
                <div class="text-muted">New Users</div>
                <strong>22.123 Users (80%)</strong>
                <div class="progress progress-xs mt-2">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </li>
            <li class="hidden-sm-down">
                <div class="text-muted">Bounce Rate</div>
                <strong>40.15%</strong>
                <div class="progress progress-xs mt-2">
                    <div class="progress-bar" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- / card -->
@endsection
