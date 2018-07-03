<?php

return [
    'app' => [
        'title' => 'General',
        'desc'  => 'All the general settings for application.',
        'icon'  => 'glyphicon glyphicon-sunglasses',

        'elements' => [
            [
                'type'  => 'text', // input fields type
                'data'  => 'string', // data type, string, int, boolean
                'name'  => 'app_name', // unique name for field
                'label' => 'App Name', // you know what label it is
                'rules' => 'required|min:2|max:50', // validation rule of laravel
                'class' => 'w-auto px-2', // any class for input
                'value' => 'CoolApp', // default value if you want
            ],
        ],
    ],
    'email' => [

        'title' => 'Email',
        'desc'  => 'Email settings for app',
        'icon'  => 'glyphicon glyphicon-envelope',

        'elements' => [
            [
                'type'  => 'email', // input fields type
                'data'  => 'string', // data type, string, int, boolean
                'name'  => 'email', // unique name for field
                'label' => 'Email', // you know what label it is
                'rules' => 'required|email', // validation rule of laravel
                'class' => 'w-auto px-2', // any class for input
                'value' => 'info@example.com', // default value if you want
            ],
        ],

    ],
];
