<?php

return [

    'backend'   => [
        'users' => [
            'index' => [
                'action' => 'List',
                'title' => 'Users',
                'sub-title' => 'Users Management',
            ],
            'show' => [
                'action' => 'Show',
                'title' => 'Users',
                'sub-title' => 'Users Management',
                'profile' => 'Profile',
            ],
            'edit' => [
                'action' => 'Edit',
                'title' => 'Users',
                'sub-title' => 'Users Management',
            ],
            'fields'    =>  [
                'name' => 'Name',
                'email' => 'Email',
                'password' => 'Password',
                'password_confirmation' => 'Password Confirmation',
                'confirmed' => 'Confirmed',
                'active' => 'Active',
                'roles' => 'roles',
                'permissions' => 'Permissions',
                'social' => 'Social',
                'picture' => 'Picture',
                'status' => 'Status',
                'created_at' => 'Created At',
                'updated_at' => 'Updated At',
            ],

        ],
        'action' => 'Action',
        'create' => 'Create',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'save' => 'Save',
        'show' => 'Show',
        'update' => 'Update',
        'total' => 'Total',
    ],

    'buttons'   =>  [
        'general'   =>  [
            'create'    =>  'Create',
            'save'    =>  'Save',
            'cancel'    =>  'Cancel',
            'update'    =>  'Update',
        ]
    ],

];
