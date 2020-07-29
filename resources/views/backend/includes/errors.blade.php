@if ($errors->any())
<div class="alert alert-danger" role="alert">
    <p>
        <i class="fas fa-exclamation-triangle"></i> @lang('Please fix the following errors & try again!')
    </p>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
