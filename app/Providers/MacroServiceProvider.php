<?php

namespace App\Providers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
  public function boot(): void
  {
    Response::macro('withPagination', function (LengthAwarePaginator $paginator, $data) {
      $resourceAdditional = method_exists($data, 'additional') ? $data->additional : [];
      $extra = $resourceAdditional['extra'] ?? [];
      return response()->json([
        'data' => $data,
        'meta' => array_merge([
          'pagination' => [
            'total' => $paginator->total(),
            'count' => $paginator->count(),
            'per_page' => $paginator->perPage(),
            'current_page' => $paginator->currentPage(),
            'total_pages' => $paginator->lastPage(),
            'links' => [
              'prev' => $paginator->previousPageUrl(),
              'next' => $paginator->nextPageUrl(),
            ],
          ],
        ], $extra),
      ]);
    });
  }
}
