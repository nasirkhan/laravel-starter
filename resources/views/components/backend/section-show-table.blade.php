@props([
    "data" => "",
    "module_name",
])
<p>
    @lang("All values of :module_name (Id: :id)", ["module_name" => ucwords(Str::singular($module_name)), "id" => $data->id])
</p>
<table class="table-responsive-sm table-hover table-bordered table">
    <?php
    $all_columns = $data->getTableColumns();
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
                    {!! show_column_value($data, $column) !!}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{-- Lightbox2 Library --}}
<x-library.lightbox />
