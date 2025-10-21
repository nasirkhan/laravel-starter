@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend.breadcrumbs>
    <x-backend.breadcrumb-item route='{{ route("backend.menus.index") }}' icon='fa-solid fa-list'>
        {{ __('Menus') }}
    </x-backend.breadcrumb-item>
    <x-backend.breadcrumb-item route='{{ route("backend.menus.show", $$module_name_singular->menu_id) }}' icon='fa-solid fa-list'>
        {{ $$module_name_singular->menu->name }}
    </x-backend.breadcrumb-item>
    <x-backend.breadcrumb-item type="active">{{ $$module_name_singular->name }}</x-backend.breadcrumb-item>
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
                    {{ $$module_name_singular->name }}
                </div>
            </div>
            <!--/.col-->
            <div class="col-4">
                <div class="btn-toolbar float-end" role="toolbar" aria-label="Toolbar with button groups">
                    <a href="{{ route('backend.menus.show', $$module_name_singular->menu_id) }}" class="btn btn-secondary btn-sm ms-1" data-toggle="tooltip" title="Back to Menu"><i class="fas fa-arrow-left"></i> Back to Menu</a>
                    <a href="{{ route('backend.menuitems.edit', $$module_name_singular) }}" class="btn btn-primary btn-sm ms-1" data-toggle="tooltip" title="Edit {{ __($module_title) }}"><i class="fas fa-wrench"></i> Edit</a>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->

        <div class="row mt-4">
            <div class="col-12 col-sm-4 mb-3">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-info-circle"></i> Basic Information
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-5">Menu:</dt>
                            <dd class="col-sm-7">
                                <a href="{{ route('backend.menus.show', $$module_name_singular->menu) }}" class="text-decoration-none">
                                    {{ $$module_name_singular->menu->name }}
                                </a>
                            </dd>
                            
                            <dt class="col-sm-5">Name:</dt>
                            <dd class="col-sm-7">{{ $$module_name_singular->name }}</dd>
                            
                            <dt class="col-sm-5">Type:</dt>
                            <dd class="col-sm-7">
                                @php
                                    $type_labels = [
                                        'link' => 'Link',
                                        'dropdown' => 'Dropdown',
                                        'divider' => 'Divider',
                                        'heading' => 'Heading',
                                        'external' => 'External Link'
                                    ];
                                    $type_colors = [
                                        'link' => 'primary',
                                        'dropdown' => 'info',
                                        'divider' => 'secondary',
                                        'heading' => 'warning',
                                        'external' => 'success'
                                    ];
                                @endphp
                                <span class="badge bg-{{ $type_colors[$$module_name_singular->type] ?? 'secondary' }}">
                                    {{ $type_labels[$$module_name_singular->type] ?? $$module_name_singular->type }}
                                </span>
                            </dd>
                            
                            @if($$module_name_singular->parent)
                            <dt class="col-sm-5">Parent:</dt>
                            <dd class="col-sm-7">
                                <a href="{{ route('backend.menuitems.show', $$module_name_singular->parent) }}" class="text-decoration-none">
                                    {{ $$module_name_singular->parent->name }}
                                </a>
                            </dd>
                            @endif
                            
                            <dt class="col-sm-5">Sort Order:</dt>
                            <dd class="col-sm-7">
                                <span class="badge bg-light text-dark">{{ $$module_name_singular->sort_order ?? 0 }}</span>
                            </dd>
                            
                            @if($$module_name_singular->slug)
                            <dt class="col-sm-5">Slug:</dt>
                            <dd class="col-sm-7"><code>{{ $$module_name_singular->slug }}</code></dd>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-4 mb-3">
                <div class="card border-info">
                    <div class="card-header bg-info text-white">
                        <i class="fas fa-link"></i> Navigation & Display
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            @if($$module_name_singular->url)
                            <dt class="col-sm-4">URL:</dt>
                            <dd class="col-sm-8">
                                <a href="{{ $$module_name_singular->url }}" target="_blank" class="text-decoration-none">
                                    {{ $$module_name_singular->url }} <i class="fas fa-external-link-alt"></i>
                                </a>
                            </dd>
                            @endif

                            @if($$module_name_singular->route_name)
                            <dt class="col-sm-4">Route:</dt>
                            <dd class="col-sm-8">
                                <code>{{ $$module_name_singular->route_name }}</code>
                                @if($$module_name_singular->route_parameters)
                                    <br><small class="text-muted">Parameters: {{ $$module_name_singular->route_parameters }}</small>
                                @endif
                            </dd>
                            @endif

                            @if($$module_name_singular->icon)
                            <dt class="col-sm-4">Icon:</dt>
                            <dd class="col-sm-8">
                                <i class="{{ $$module_name_singular->icon }}"></i> 
                                <code>{{ $$module_name_singular->icon }}</code>
                            </dd>
                            @endif

                            @if($$module_name_singular->badge_text)
                            <dt class="col-sm-4">Badge:</dt>
                            <dd class="col-sm-8">
                                <span class="badge bg-{{ $$module_name_singular->badge_color ?? 'primary' }}">
                                    {{ $$module_name_singular->badge_text }}
                                </span>
                            </dd>
                            @endif

                            @if($$module_name_singular->opens_new_tab)
                            <dt class="col-sm-4">Opens:</dt>
                            <dd class="col-sm-8">
                                <span class="badge bg-info">New Tab</span>
                            </dd>
                            @endif

                            @if($$module_name_singular->css_classes)
                            <dt class="col-sm-4">CSS Classes:</dt>
                            <dd class="col-sm-8">
                                <code>{{ $$module_name_singular->css_classes }}</code>
                            </dd>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-4 mb-3">
                <div class="card border-success">
                    <div class="card-header bg-success text-white">
                        <i class="fas fa-shield-alt"></i> Status & Security
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-5">Status:</dt>
                            <dd class="col-sm-7">
                                @if($$module_name_singular->status == 1)
                                    <span class="badge bg-success">Published</span>
                                @elseif($$module_name_singular->status == 0)
                                    <span class="badge bg-danger">Disabled</span>
                                @else
                                    <span class="badge bg-warning">Draft</span>
                                @endif
                            </dd>

                            <dt class="col-sm-5">Active:</dt>
                            <dd class="col-sm-7">
                                @if($$module_name_singular->is_active)
                                    <span class="badge bg-success"><i class="fas fa-check"></i> Yes</span>
                                @else
                                    <span class="badge bg-danger"><i class="fas fa-times"></i> No</span>
                                @endif
                            </dd>

                            <dt class="col-sm-5">Visible:</dt>
                            <dd class="col-sm-7">
                                @if($$module_name_singular->is_visible)
                                    <span class="badge bg-success"><i class="fas fa-eye"></i> Yes</span>
                                @else
                                    <span class="badge bg-danger"><i class="fas fa-eye-slash"></i> No</span>
                                @endif
                            </dd>

                            @if($$module_name_singular->locale)
                            <dt class="col-sm-5">Language:</dt>
                            <dd class="col-sm-7">
                                <span class="badge bg-primary">{{ strtoupper($$module_name_singular->locale) }}</span>
                            </dd>
                            @endif

                            @if($$module_name_singular->permissions && is_array($$module_name_singular->permissions) && count($$module_name_singular->permissions) > 0)
                            <dt class="col-sm-5">Permissions:</dt>
                            <dd class="col-sm-7">
                                @foreach($$module_name_singular->permissions as $permission)
                                    <span class="badge bg-warning">{{ $permission }}</span>
                                @endforeach
                            </dd>
                            @endif

                            @if($$module_name_singular->roles && is_array($$module_name_singular->roles) && count($$module_name_singular->roles) > 0)
                            <dt class="col-sm-5">Roles:</dt>
                            <dd class="col-sm-7">
                                @foreach($$module_name_singular->roles as $role)
                                    <span class="badge bg-info">{{ $role }}</span>
                                @endforeach
                            </dd>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        @if($$module_name_singular->description || $$module_name_singular->meta_title)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-align-left"></i> Descriptions & SEO
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            @if($$module_name_singular->description)
                            <dt class="col-sm-2">Description:</dt>
                            <dd class="col-sm-10">{{ $$module_name_singular->description }}</dd>
                            @endif

                            @if($$module_name_singular->meta_title)
                            <dt class="col-sm-2">Meta Title:</dt>
                            <dd class="col-sm-10">{{ $$module_name_singular->meta_title }}</dd>
                            @endif


                        </dl>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($$module_name_singular->children && $$module_name_singular->children->count() > 0)
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-sitemap"></i> Child Items ({{ $$module_name_singular->children->count() }})
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Order</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($$module_name_singular->children->sortBy('sort_order') as $child)
                                    <tr>
                                        <td>
                                            @if($child->icon)
                                                <i class="{{ $child->icon }}"></i>
                                            @endif
                                            {{ $child->name }}
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $type_colors[$child->type] ?? 'secondary' }}">
                                                {{ $type_labels[$child->type] ?? $child->type }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $child->sort_order ?? 0 }}</span>
                                        </td>
                                        <td>
                                            @if($child->status == 1 && $child->is_active && $child->is_visible)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('backend.menuitems.show', $child) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('backend.menuitems.edit', $child) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($$module_name_singular->custom_data || $$module_name_singular->html_attributes || $$module_name_singular->note)
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-code"></i> Additional Data & Notes
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            @if($$module_name_singular->custom_data)
                            <dt class="col-sm-2">Custom Data:</dt>
                            <dd class="col-sm-10">
                                <pre><code>{{ $$module_name_singular->custom_data }}</code></pre>
                            </dd>
                            @endif

                            @if($$module_name_singular->html_attributes)
                            <dt class="col-sm-2">HTML Attributes:</dt>
                            <dd class="col-sm-10">
                                <pre><code>{{ $$module_name_singular->html_attributes }}</code></pre>
                            </dd>
                            @endif

                            @if($$module_name_singular->note)
                            <dt class="col-sm-2">Admin Notes:</dt>
                            <dd class="col-sm-10">{{ $$module_name_singular->note }}</dd>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    
    <div class="card-footer">
        <div class="row">
            <div class="col-6">
                <small class="text-muted">
                    <strong>Created:</strong> {{ $$module_name_singular->created_at }} ({{ $$module_name_singular->created_at->diffForHumans() }}),
                    <strong>Updated:</strong> {{ $$module_name_singular->updated_at }} ({{ $$module_name_singular->updated_at->diffForHumans() }})
                    @if($$module_name_singular->deleted_at)
                        <br><strong>Deleted:</strong> {{ $$module_name_singular->deleted_at }} ({{ $$module_name_singular->deleted_at->diffForHumans() }})
                    @endif
                </small>
            </div>
            <div class="col-6">
                <div class="float-end">
                    @if($$module_name_singular->getFullUrl())
                        <a href="{{ $$module_name_singular->getFullUrl() }}" class="btn btn-success btn-sm" target="_blank">
                            <i class="fas fa-external-link-alt"></i> Visit Link
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection