<p>
    @lang("All values of :module_name (Id: :id)", ["module_name" => ucwords($module_name_singular), "id" => $$module_name_singular->id])
</p>
<table class="table-responsive-sm table-hover table-bordered table">
    <?php
    $all_columns = $$module_name_singular->getTableColumns();
    ?>

    <thead>
        <tr>
            <th scope="col">
                <strong>
                    @lang("Name")
                </strong>
            </th>
            <th scope="col">
                <strong>
                    @lang("Value")
                </strong>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($all_columns as $column)
            <tr>
                <td>
                    <strong>
                        {{ __(label_case($column->name)) }}
                    </strong>
                </td>
                <td>
                    {!! show_column_value($$module_name_singular, $column) !!}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{-- Lightbox2 Library --}}
<x-library.lightbox />
