<?php

return [

    'backend'   => [
        'users' => [
            'index' => [
                'action'    => 'List',
                'title'     => 'Users',
                'sub-title' => 'Users Management',
            ],
            'show' => [
                'action'    => 'Show',
                'title'     => 'Users',
                'sub-title' => 'Users Management',
                'profile'   => 'Profile',
            ],
            'edit' => [
                'action'    => 'Edit',
                'title'     => 'Users',
                'sub-title' => 'Users Management',
            ],
            'create' => [
                'action'    => 'Create',
                'title'     => 'Users',
                'sub-title' => 'Users Management',
            ],
            'fields'    => [
                'name'                  => 'Name',
                'email'                 => 'Email',
                'mobile'                => 'Mobile',
                'gender'                => 'Gender',
                'date_of_birth'         => 'Date of Birth',
                'url_website'           => 'Website',
                'url_facebook'          => 'Facebook',
                'url_twitter'           => 'Twitter',
                'url_googleplus'        => 'Google Plus',
                'url_linkedin'          => 'LinkedIn',
                'url_1'                 => 'URL 1',
                'url_2'                 => 'URL 2',
                'url_3'                 => 'URL 3',
                'profile_privecy'       => 'Profile Privecy',
                'address'               => 'Address',
                'bio'                   => 'Bio',
                'logins_count'          => 'Login Count',
                'last_login'            => 'Last Login',
                'password'              => 'Password',
                'password_confirmation' => 'Password Confirmation',
                'confirmed'             => 'Confirmed',
                'active'                => 'Active',
                'roles'                 => 'Roles',
                'permissions'           => 'Permissions',
                'social'                => 'Social',
                'picture'               => 'Picture',
                'avatar'                => 'Avatar',
                'status'                => 'Status',
                'created_at'            => 'Created At',
                'updated_at'            => 'Updated At',
            ],

        ],
        'roles' => [
            'index' => [
                'action'    => 'List',
                'title'     => 'Roles',
                'sub-title' => 'Roles Management',
            ],
            'show' => [
                'action'    => 'Show',
                'title'     => 'Roles',
                'sub-title' => 'Roles Management',
                'profile'   => 'Profile',
            ],
            'edit' => [
                'action'    => 'Edit',
                'title'     => 'Roles',
                'sub-title' => 'Roles Management',
            ],
            'create' => [
                'action'    => 'Create',
                'title'     => 'Roles',
                'sub-title' => 'Roles Management',
            ],
            'fields'    => [
                'name'        => 'Name',
                'status'      => 'Status',
                'permissions' => 'Permissions',
                'created_at'  => 'Created At',
                'updated_at'  => 'Updated At',
            ],

        ],
        'action'            => 'Action',
        'create'            => 'Create',
        'edit'              => 'Edit',
        'changePassword'    => 'Change Password',
        'delete'            => 'Delete',
        'restore'           => 'Restore',
        'save'              => 'Save',
        'show'              => 'Show',
        'update'            => 'Update',
        'total'             => 'Total',
        'block'             => 'Block',
        'unblock'           => 'Unblock',
        'cancel'            => 'Cancel',
    ],

    'buttons'   => [
        'general'   => [
            'create'    => 'Create',
            'save'      => 'Save',
            'cancel'    => 'Cancel',
            'update'    => 'Update',
        ],
    ],

];
