@extends('backend.layouts.app')

@section('title') @lang("File Manager") @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs/>
@endsection

@section('content')
<iframe src="/filemanager" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
@endsection
