<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *    title="Inventory Management API",
 *    version="1.0.0",
 * )
 * @OA\SecurityScheme(
 *     type="http",
 *     securityScheme="bearerAuth",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 * @OA\Parameter(
 * parameter="AcceptHeader",
 * name="Accept",
 * in="header",
 * required=true,
 * @OA\Schema(type="string", default="application/json"),
 * description="Force response format to JSON"
 * )
 */
abstract class Controller
{
  public function include(string $relation): bool
  {
    $param = request()->get('include');
    
    if (!$param) {
      return false;
    }
    
    $includeValues = explode(',', $param);
    
    return in_array(strtolower($relation), $includeValues);
  }
}

