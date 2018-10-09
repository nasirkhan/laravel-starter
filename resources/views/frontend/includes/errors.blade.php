@if ($errors->any())
<div class="alert alert-danger" role="alert">
    <p>
        <i class="fa fa-exclamation-triangle"></i> Please fix the following errors and submit again!
    </p>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
