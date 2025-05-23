<?php

namespace App\Traits;

trait ApiResponse
{
    protected function success($data = null, $message = 'Thành công', $code = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function error($message = 'Lỗi hệ thống', $errors = [], $code = 400)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }
}

