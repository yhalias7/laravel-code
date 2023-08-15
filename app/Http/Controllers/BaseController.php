<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseController extends Controller
{
    
    /**
     * Summary of responseSuccess
     * @param array|JsonResource $data
     * @param string $message
     * @return array
     */
    public function responseSuccess(array|JsonResource $data, string $message)
    {
        $result = [
            'success' => true,
            'message' => $message,
        ];

        if (!empty($data)) {
            $result['data'] = $data;
        }

        return response()->json($result, 200);
    }

    /**
     * Summary of responseError
     * @param array $error
     * @param string $message
     * @param int $code
     * @return array
     */
    public function responseError(array $error, string $message, int $code = 404)
    {
        $result = [
            'success' => false,
            'message' => $message,
        ];
        if (!empty($error)) {
            $result['data'] = $error;
        }

        return response()->json($result, $code);
    }
}
