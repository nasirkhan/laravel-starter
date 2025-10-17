@php
    $indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level);
@endphp

<tr>
    <td>{{ $item->sort_order }}</td>
    <td>
        {!! $indent !!}
        @if($item->icon)
            <i class="{{ $item->icon }}"></i>
        @endif
        {{ $item->name }}
        @if($item->children->count() > 0)
            <span class="badge bg-info ms-1">{{ $item->children->count() }} child{{ $item->children->count() > 1 ? 'ren' : '' }}</span>
        @endif
    </td>
    <td>
        <span class="badge bg-secondary">{{ ucfirst($item->type) }}</span>
    </td>
    <td>
        @if($item->url)
            <span class="text-muted">URL:</span> {{ Str::limit($item->url, 30) }}
        @elseif($item->route_name)
            <span class="text-muted">Route:</span> {{ $item->route_name }}
        @else
            <span class="text-muted">-</span>
        @endif
        @if($item->opens_new_tab)
            <i class="fas fa-external-link-alt text-muted ms-1" title="Opens in new tab"></i>
        @endif
    </td>
    <td>
        @if($item->is_active)
            <span class="badge bg-success">{{ __('menu::text.active') }}</span>
        @else
            <span class="badge bg-warning">{{ __('menu::text.inactive') }}</span>
        @endif
        
        @if($item->is_visible)
            <span class="badge bg-primary">{{ __('menu::text.visible') }}</span>
        @else
            <span class="badge bg-secondary">{{ __('menu::text.hidden') }}</span>
        @endif
    </td>
    <td class="text-center">
        <div class="btn-group btn-group-sm" role="group">
            <a href="{{ route('backend.menuitems.show', $item->id) }}" class="btn btn-outline-primary btn-sm" title="View">
                <i class="fas fa-eye"></i>
            </a>
            <a href="{{ route('backend.menuitems.edit', $item->id) }}" class="btn btn-outline-warning btn-sm" title="Edit">
                <i class="fas fa-edit"></i>
            </a>
            @if($item->children->count() == 0)
                <form method="POST" action="{{ route('backend.menuitems.destroy', $item->id) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this menu item?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            @endif
        </div>
    </td>
</tr>

@if($item->children->count() > 0)
    @foreach($item->children->sortBy('sort_order') as $child)
        @include('menu::backend.menus.partials.menu-item-row', ['item' => $child, 'level' => $level + 1])
    @endforeach
@endif