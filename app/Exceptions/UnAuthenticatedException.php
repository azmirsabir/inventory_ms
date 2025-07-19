<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class UnAuthenticatedException extends Exception
{
    protected $message;
    
    public function __construct($message = "Authenticated.")
    {
      parent::__construct($message);
    }
    
    public function render($request): JsonResponse
    {
      return response()->json([
        'success' => false,
        'message' => $this->getMessage(),
      ], 401);
    }
}
