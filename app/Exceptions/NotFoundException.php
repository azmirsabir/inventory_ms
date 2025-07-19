<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class NotFoundException extends Exception
{
  protected $message;
  
  public function __construct($message = "Resource not found")
  {
    parent::__construct($message);
  }
  
  public function render($request): JsonResponse
  {
    return response()->json([
      'success' => false,
      'message' => $this->getMessage(),
    ], 404);
  }
}
