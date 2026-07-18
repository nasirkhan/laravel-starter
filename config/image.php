<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Laravel's image manipulation features are powered by Intervention Image
    | and support the "gd" and "imagick" PHP extensions. You may also set
    | the driver using the IMAGE_DRIVER environment variable.
    |
    */

    'driver' => env('IMAGE_DRIVER', 'gd'),

];
