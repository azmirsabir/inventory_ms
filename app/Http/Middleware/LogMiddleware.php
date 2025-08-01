<?php
  
  namespace App\Http\Middleware;
  
  use Closure;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Log;
  use Symfony\Component\HttpFoundation\Response;
  
  class LogMiddleware
  {
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
      Log::info("Azmirrrrrr");
      Log::channel("http")->info('Incoming Request', [
        'method' => $request->method(),
        'url' => $request->fullUrl(),
        'headers' => $request->headers->all(),
        'body' => $request->except(['password', 'password_confirmation']),
      ]);
      
      $response = $next($request);
      
      // Log outgoing response
      Log::channel("http")->info('Response', [
        'status' => $response->getStatusCode(),
        'content' => method_exists($response, 'getContent') ? $response->getContent() : 'Binary/Streamed content',
      ]);
      
      return $response;
    }
  }
