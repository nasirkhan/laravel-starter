@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend.breadcrumbs>
    <x-backend.breadcrumb-item type="active" icon='{{ $module_icon }}'>{{ __($module_title) }}</x-backend.breadcrumb-item>
</x-backend.breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    <i class="{{ $module_icon }}"></i> {{ __($module_title) }} <small class="text-muted">{{ __($module_action) }}</small>
                </h4>
                <div class="small text-muted">
                    {{ __($module_name) }} Management Dashboard
                </div>
            </div>
            <!--/.col-->
            <div class="col-4">
                <div class="btn-toolbar float-end" role="toolbar" aria-label="Toolbar with button groups">
                    <a href="{{ route('backend.menuitems.create') }}" class="btn btn-success btn-sm ms-1" data-toggle="tooltip" title="{{ __($module_action) }} {{ __($module_title) }}"><i class="fas fa-plus-circle"></i> New Menu Item</a>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>Menu</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Parent</th>
                                <th>URL/Route</th>
                                <th>Order</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-7">
                <div class="float-left">
                    Total {{ $$module_name_singular->count() }} {{ __($module_title) }}
                </div>
            </div>
            <div class="col-5">
                <div class="float-end">
                    <a href="{{ route('backend.menus.index') }}" class="btn btn-warning btn-sm ms-1" data-toggle="tooltip" title="Manage Menus"><i class="fas fa-list"></i> Manage Menus</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push ('after-styles')
<!-- DataTables Core and Extensions -->
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatable/datatables.min.css') }}">

@endpush

@push ('after-scripts')
<!-- DataTables Core and Extensions -->
<script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>

<script type="text/javascript">
        
    $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: true,
        responsive: true,
        ajax: {
            url: '{{ route('backend.menuitems.index_data') }}',
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'menu_name', name: 'menu.name', searchable: true},
            {
                data: 'name_with_hierarchy', 
                name: 'name', 
                render: function(data, type, row) {
                    let indent = '';
                    for (let i = 0; i < row.level; i++) {
                        indent += '&nbsp;&nbsp;&nbsp;&nbsp;';
                    }
                    let icon = row.icon ? '<i class="' + row.icon + '"></i> ' : '';
                    return indent + icon + data;
                },
                searchable: true
            },
            {
                data: 'type', 
                name: 'type',
                render: function(data) {
                    const typeLabels = {
                        'link': '<span class="badge bg-primary">Link</span>',
                        'dropdown': '<span class="badge bg-info">Dropdown</span>',
                        'divider': '<span class="badge bg-secondary">Divider</span>',
                        'heading': '<span class="badge bg-warning">Heading</span>',
                        'external': '<span class="badge bg-success">External</span>'
                    };
                    return typeLabels[data] || data;
                }
            },
            {
                data: 'parent_name', 
                name: 'parent.name',
                searchable: true,
                render: function(data) {
                    return data || '<span class="text-muted">Root Level</span>';
                }
            },
            {
                data: 'url_display', 
                name: 'url',
                render: function(data, type, row) {
                    if (row.route_name) {
                        return '<code>' + row.route_name + '</code>';
                    } else if (row.url) {
                        return '<a href="' + row.url + '" target="_blank" class="text-decoration-none">' + row.url + ' <i class="fas fa-external-link-alt"></i></a>';
                    }
                    return '<span class="text-muted">N/A</span>';
                },
                searchable: false
            },
            {
                data: 'sort_order', 
                name: 'sort_order',
                render: function(data) {
                    return '<span class="badge bg-light text-dark">' + (data || 0) + '</span>';
                }
            },
            {
                data: 'status_badge', 
                name: 'status',
                render: function(data, type, row) {
                    let badges = '';
                    
                    // Status badge
                    if (row.status == 1) {
                        badges += '<span class="badge bg-success">Published</span> ';
                    } else if (row.status == 0) {
                        badges += '<span class="badge bg-danger">Disabled</span> ';
                    } else {
                        badges += '<span class="badge bg-warning">Draft</span> ';
                    }
                    
                    // Active badge
                    if (row.is_active) {
                        badges += '<span class="badge bg-info">Active</span> ';
                    }
                    
                    // Visible badge
                    if (row.is_visible) {
                        badges += '<span class="badge bg-primary">Visible</span>';
                    }
                    
                    return badges;
                },
                searchable: false
            },
            {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-end'}
        ],
        order: [[1, 'asc'], [6, 'asc']] // Order by menu name, then sort order
    });
        
</script>

@endpush