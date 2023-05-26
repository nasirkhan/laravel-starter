<?php

namespace App\Traits;


trait ReturnFormatTrait
{

    protected function responseWithSuccess($message = '', $data = [])
    {
        return [
            'status'    => true,
            'message'   => $message,
            'data'      => $data,
        ];
    }

    protected function responseWithError($message = '', $data = [])
    {
        return [
            'status'    => false,
            'message'   => $message,
            'data'      => $data,
        ];
    }
}
