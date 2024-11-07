<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function sendResponse($message, $data = [])
    {
        $status =200;
        $response = [
            'success' => true,
            'data' => $data,
            'message' => $message,
        ];

        return response()->json($response,$status);
    }

  
    public function sendError($message, $code = 400, $data = [])
    {
        $response = [
            'success' => false,
            'data' => $data,
            'message' => $message,
        ];

        return response()->json($response, $code);
    }
}
