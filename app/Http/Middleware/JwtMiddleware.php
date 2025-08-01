<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use Illuminate\Http\Request;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
      try {
        $user = JWTAuth::parseToken()->authenticate();
        
        if (!$user) {
          return response()->json(['error' => 'User not found'], 404);
        }
      } catch (TokenExpiredException $e) {
        return response()->json(['error' => 'Token has expired'], 401);
      } catch (TokenInvalidException $e) {
        return response()->json(['error' => 'Token is invalid'], 401);
      } catch (JWTException $e) {
        return response()->json(['error' => 'Token is missing'], 401);
      }
      
      return $next($request);
    }
}
