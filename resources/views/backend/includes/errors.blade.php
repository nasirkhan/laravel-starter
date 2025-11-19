@if ($errors->any())
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <p>
            <i class="fas fa-exclamation-triangle"></i>
            @lang("Please fix the following errors & try again!")
        </p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button class="btn-close" data-coreui-dismiss="alert" type="button" aria-label="Close"></button>
    </div>
    {{--
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
    --}}
@endif
