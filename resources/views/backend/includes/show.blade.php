<p>
    @lang("All values of :module_name (Id: :id)", ["module_name" => ucwords($module_name_singular), "id" => $$module_name_singular->id])
</p>
<div class="overflow-x-auto">
<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse">
    <?php
    $all_columns = $$module_name_singular->getTableColumns();
    ?>

    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-4 py-3">
                @lang("Name")
            </th>
            <th scope="col" class="px-4 py-3">
                @lang("Value")
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($all_columns as $column)
            <tr>
                <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 font-medium text-gray-900 dark:text-white">
                    {{ __(label_case($column->name)) }}
                </td>
                <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                    {!! show_column_value($$module_name_singular, $column) !!}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>

{{-- Lightbox2 Library --}}
<x-library.lightbox />
