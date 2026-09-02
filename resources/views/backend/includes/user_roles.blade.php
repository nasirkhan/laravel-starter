@if ($data->getRoleNames()->count() > 0)
    <ul class="space-y-1">
        @foreach ($data->getRoleNames() as $role)
            <li>
                <i class="fas fa-check-square"></i>
                {{ ucwords($role) }}
            </li>
        @endforeach
    </ul>
@endif
