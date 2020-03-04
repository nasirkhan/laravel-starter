<p>
    Displaing all the values of <strong>{{ ucwords($module_name_singular) }} (Id: {{$$module_name_singular->id}})</strong>.
</p>
<table class="table table-responsive-sm table-hover table-bordered">
    <?php
      $all_columns = $$module_name_singular->getTableColumns();
    ?>
    <thead>
        <tr>
            <th scope="col">
                <strong>
                    Name
                </strong>
            </th>
            <th scope="col">
                <strong>
                    Value
                </strong>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($all_columns as $column)
        <tr>
            <td>
                <strong>
                    {{ label_case($column->Field) }}
                </strong>
            </td>
            <td>
                {!! show_column_value($$module_name_singular, $column) !!}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


@push('after-styles')
<!-- Lightbox2 CSS -->
<link href="{{ asset('vendor/lightbox2/css/lightbox.min.css') }}" rel="stylesheet">
@endpush

@push('after-scripts')
<!-- Lightbox2 JS -->
<script src="{{ asset('vendor/lightbox2/js/lightbox.min.js') }}"></script>
@endpush
