@if ($data->getRoleNames()->count() > 0)
    <ul class="fa-ul">
        @foreach ($data->getRoleNames() as $role)
            <li>
                <span class="fa-li"><i class="fas fa-check-square"></i></span>
                {{ ucwords($role) }}
            </li>
        @endforeach
    </ul>
@endif
