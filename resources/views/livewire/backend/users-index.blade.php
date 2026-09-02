<div>
    <x-cube::lw-table :rows="$users" search-placeholder="{{ __('Search by name or email…') }}">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <x-cube::lw-table-th column="name" :sort-col="$sortCol" :sort-dir="$sortDir">
                    {{ __('labels.backend.users.fields.name') }}
                </x-cube::lw-table-th>
                <x-cube::lw-table-th column="email" :sort-col="$sortCol" :sort-dir="$sortDir">
                    {{ __('labels.backend.users.fields.email') }}
                </x-cube::lw-table-th>
                <x-cube::lw-table-th>
                    {{ __('labels.backend.users.fields.status') }}
                </x-cube::lw-table-th>
                <x-cube::lw-table-th>
                    {{ __('labels.backend.users.fields.roles') }}
                </x-cube::lw-table-th>
                <x-cube::lw-table-th>
                    {{ __('labels.backend.users.fields.social') }}
                </x-cube::lw-table-th>
                <x-cube::lw-table-th class="text-right">
                    {{ __('labels.backend.action') }}
                </x-cube::lw-table-th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                        <a
                            href="{{ route('backend.users.show', $user->id) }}"
                            class="hover:text-blue-600 dark:hover:text-blue-400"
                        >{{ $user->name }}</a>
                    </td>
                    <td class="px-4 py-3">{{ $user->email }}</td>
                    <td class="px-4 py-3">
                        {!! $user->status_label !!}
                        {!! $user->confirmed_label !!}
                    </td>
                    <td class="px-4 py-3">
                        @if ($user->getRoleNames()->count() > 0)
                            <ul class="space-y-1">
                                @foreach ($user->getRoleNames() as $role)
                                    <li class="flex items-center gap-1.5 text-xs">
                                        <i class="fa-solid fa-user-shield fa-fw text-gray-400 shrink-0"></i>
                                        {{ ucwords($role) }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        @if ($user->providers->count())
                            <ul class="space-y-1 text-xs">
                                @foreach ($user->providers as $provider)
                                    <li>
                                        <i class="fab fa-{{ $provider->provider }} fa-fw"></i>
                                        {{ label_case($provider->provider) }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-1 flex-wrap">
                            <a
                                href="{{ route('backend.users.show', $user) }}"
                                class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-white bg-green-600 rounded-lg hover:bg-green-700"
                                title="{{ __('labels.backend.show') }}"
                            ><i class="fas fa-desktop fa-fw"></i></a>

                            @can('edit_users')
                                <a
                                    href="{{ route('backend.users.edit', $user) }}"
                                    class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700"
                                    title="{{ __('labels.backend.edit') }}"
                                ><i class="fas fa-wrench fa-fw"></i></a>

                                <a
                                    href="{{ route('backend.users.changePassword', $user) }}"
                                    class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-white bg-sky-500 rounded-lg hover:bg-sky-600"
                                    title="{{ __('labels.backend.changePassword') }}"
                                ><i class="fas fa-key fa-fw"></i></a>

                                @if ($user->status != 2 && $user->id != 1)
                                    <a
                                        href="{{ route('backend.users.block', $user) }}"
                                        class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-white bg-red-600 rounded-lg hover:bg-red-700"
                                        data-method="PATCH"
                                        data-token="{{ csrf_token() }}"
                                        data-confirm="@lang('Are you sure?')"
                                        title="{{ __('labels.backend.block') }}"
                                    ><i class="fas fa-ban fa-fw"></i></a>
                                @endif

                                @if ($user->status == 2)
                                    <a
                                        href="{{ route('backend.users.unblock', $user) }}"
                                        class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-white bg-sky-500 rounded-lg hover:bg-sky-600"
                                        data-method="PATCH"
                                        data-token="{{ csrf_token() }}"
                                        data-confirm="@lang('Are you sure?')"
                                        title="{{ __('labels.backend.unblock') }}"
                                    ><i class="fas fa-check fa-fw"></i></a>
                                @endif

                                @if ($user->id != 1)
                                    <a
                                        href="{{ route('backend.users.destroy', $user) }}"
                                        class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-white bg-red-600 rounded-lg hover:bg-red-700"
                                        data-method="DELETE"
                                        data-token="{{ csrf_token() }}"
                                        data-confirm="@lang('Are you sure?')"
                                        title="{{ __('labels.backend.delete') }}"
                                    ><i class="fas fa-trash-alt fa-fw"></i></a>
                                @endif

                                @if ($user->email_verified_at == null)
                                    <a
                                        href="{{ route('backend.users.emailConfirmationResend', $user->id) }}"
                                        class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700"
                                        title="@lang('Send confirmation email')"
                                    ><i class="fas fa-envelope fa-fw"></i></a>
                                @endif
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-400 dark:text-gray-500">
                        @lang('No users found.')
                    </td>
                </tr>
            @endforelse
        </tbody>
    </x-cube::lw-table>
</div>
