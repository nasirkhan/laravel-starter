@extends ('backend.layouts.app')

<?php
$module_icon = "fas fa-list";
?>
@section('title')
Log Viewer Dashboard | {{ app_name() }}
@stop

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{!!route('backend.dashboard')!!}"><i class="icon-speedometer"></i> Dashboard</a></li>
<li class="breadcrumb-item active"><i class="{{$module_icon}}"></i> Log Viewer</li>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    <i class="{{$module_icon}}"></i> Log Viewer
                    <small class="text-muted">Dashboard </small>
                </h4>
                <div class="small text-muted">
                    Log Viewer Module
                </div>
            </div>

            <div class="col-4">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                    <button onclick="window.history.back();"class="btn btn-warning ml-1" data-toggle="tooltip" title="Return Back"><i class="fas fa-reply"></i> Back</button>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->

        <div class="row mt-4">
            <div class="col-md-6 col-lg-3">
                <canvas id="stats-doughnut-chart" height="300" class="mb-3"></canvas>

                <hr>
                <a class="btn btn-primary btn-lg btn-block" href="{{ route('log-viewer::logs.list') }}" type="button">
                    <i class="fas fa-list-ol"></i> Logs by Date
                </a>
            </div>

            <div class="col-md-6 col-lg-9">
                <div class="row">
                    @foreach($percents as $level => $item)
                        <div class="col-sm-6 col-md-12 col-lg-4 mb-3">
                            <div class="box level-{{ $level }} {{ $item['count'] === 0 ? 'empty' : '' }}">
                                <div class="box-icon">
                                    {!! log_styler()->icon($level) !!}
                                </div>

                                <div class="box-content">
                                    <span class="box-text">{{ $item['name'] }}</span>
                                    <span class="box-number">
                                        {{ $item['count'] }} entries - {!! $item['percent'] !!} %
                                    </span>
                                    <div class="progress" style="height: 3px;">
                                        <div class="progress-bar" style="width: {{ $item['percent'] }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@push('after-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<script>
    $(function() {
        new Chart(document.getElementById("stats-doughnut-chart"), {
            type: 'doughnut',
            data: {!! $chartData !!},
            options: {
                legend: {
                    position: 'bottom'
                }
            }
        });
    });
</script>
@endpush

@push('after-styles')
@include('log-viewer::laravel-starter.partials.style')
@endpush
