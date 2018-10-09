@extends('backend.layouts.app')

@section ('title', 'GeneralException' . " - " . config('app.name'))

@section('content')
<div class="card text-white bg-danger">
    <div class="card-body">
        <div class="row">
            <div class="col">
                <div class="text-center">
                    <h2>{{ label_case($exception->getMessage()) }}</h2>
                    <p>&nbsp;</p>
                    <p>
                        <button onclick="window.history.back();"class="btn btn-warning ml-1" data-toggle="tooltip" title="Return Back"><i class="fas fa-reply"></i> Return Back</button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / card -->
@endsection
