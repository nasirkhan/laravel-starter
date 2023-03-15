@push('after-styles')
<!-- Select2 Bootstrap 4 Core UI -->
<link href="{{ asset('vendor/select2/select2-coreui-bootstrap4.min.css') }}" rel="stylesheet" />
@endpush

@push('after-scripts')
<!-- Select2 Bootstrap 4 Core UI -->
<script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script type="module">
    $(document).ready(function() {
        $('.select2').select2({
            theme: "bootstrap",
            placeholder: "-- Select an option --",
        });
    });
</script>
@endpush