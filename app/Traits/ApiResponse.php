<?php

namespace App\Traits;

use Illuminate\Validation\ValidationException;
use Throwable;

trait ApiResponse 
{
    public function successResponse($data,$message = null,  int $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data ?? null,
        ], $code);
    }

    public function errorResponse(Throwable $e)
    {
        $errorCode = $e->getCode();
        
        if($e instanceof ValidationException) {
            $errorCode = 422; 
        } else if($errorCode == 0) { 
            $errorCode = 400; 
        }
        
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
        ]);
    }


}