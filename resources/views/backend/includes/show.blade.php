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

<!-- Lightbox2 Library -->
<x-library.lightbox/>
