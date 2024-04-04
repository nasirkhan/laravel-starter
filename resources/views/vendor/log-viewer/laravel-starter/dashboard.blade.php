@extends ('backend.layouts.app')

<?php
$module_icon = 'fa-solid fa-list-check';
?>

@section('title')
    {{ __('Log Viewer Dashboard') }}
@endsection

@section('breadcrumbs')
    <x-backend.breadcrumbs>
        <x-backend.breadcrumb-item type="active" icon='{{ $module_icon }}'>
            @lang('Log Viewer')
        </x-backend.breadcrumb-item>
    </x-backend.breadcrumbs>
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <x-backend.section-header>
                @lang('Log Dashboard')

                <x-slot name="toolbar">
                    <x-backend.buttons.return-back />
                    <a class="btn btn-primary ms-1" type="button" href="{{ route('log-viewer::logs.list') }}">
                        <i class="fas fa-list-ol"></i> @lang('Daily Log')
                    </a>
                </x-slot>
            </x-backend.section-header>

            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <canvas class="mb-3" id="stats-doughnut-chart" height="300"></canvas>
                </div>

                <div class="col-md-6 col-lg-9">
                    <div class="row">
                        @foreach ($percents as $level => $item)
                            <div class="col-sm-6 col-md-12 col-lg-4 mb-3">
                                <div class="box level-{{ $level }} {{ $item['count'] === 0 ? 'empty' : '' }}">
                                    <div class="box-icon">
                                        {!! log_styler()->icon($level) !!}
                                    </div>

                                    <div class="box-content">
                                        <span class="box-text">{{ $item['name'] }}</span>
                                        <span class="box-number">
                                            {{ $item['count'] }} @lang('entries') - {!! $item['percent'] !!} %
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

@push('after-styles')
    @include('log-viewer::laravel-starter.style')
@endpush

@push('after-scripts')
    <script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"
        integrity="sha512-SIMGYRUjwY8+gKg7nn9EItdD8LCADSDfJNutF9TPrvEo86sQmFMh6MyralfIyhADlajSxqc7G0gs7+MwWF/ogQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="module">
        function ready(fn) {
            if (document.readyState !== 'loading') {
                fn();
            } else {
                document.addEventListener('DOMContentLoaded', fn);
            }
        }

        ready(function() {
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
