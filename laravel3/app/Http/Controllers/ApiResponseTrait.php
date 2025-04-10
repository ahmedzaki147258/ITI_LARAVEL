<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;

trait ApiResponseTrait {
    public function apiResponse($data = [], $message = "", $statusCode = null): Response{
        $array = [
            'data' => $data,
            'message' => $message,
            'statusCode' => $statusCode
        ];

        return response($array, $statusCode);
    }
}
