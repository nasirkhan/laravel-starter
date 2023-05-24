<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;

trait AjaxReturnFormatTrait
{

    protected function responseWithSuccess($message = '', $data = [], $code = 200)
    {

        if (blank($data)) {
            $data = (object) $data;
        }

        $output = response()->json([
            'status'    => true,
            'message'   => $message,
            'data'      => $data,
        ]);
        return $output;
    }

    protected function responseWithError($message = '', $data = [], $code = 400)
    {

        if (blank($data)) {
            $data = (object) $data;
        }


        $output = response()->json([
            'status'    => false,
            'message'   => $message,
            'data'      => $data,
        ]);


        return $output;
    }

    protected function responseExceptionError($message = '', $data = [], $code = null): JsonResponse
    {
        return response()->json([
            'api_end_point' => \request()->url(),
            'exception_error' => true,
            'exception_message' => $message,
        ], $code);
    }


    public function createJsonFile($response, $fileName)
    {
        // decode the JSON response to a PHP object
        $data = json_decode($response);
        // encode the PHP object back to a JSON string without headers
        $json = json_encode($data);

        $filePath = public_path() . "/api/json/" . $fileName . ".json";
        // create directory if not exist
        if (!file_exists(public_path() . "/api/json/")) {
            mkdir(public_path() . "/api/json/", 0777, true);
        }
        // create file if not exist
        if (!file_exists($filePath)) {
            $file = fopen($filePath, "w");
            fclose($file);
        }
        // write data in file
        $file = fopen(public_path() . "/api/json/" . $fileName . ".json", "w");
        fwrite($file, $json);
        fclose($file);
    }
}
