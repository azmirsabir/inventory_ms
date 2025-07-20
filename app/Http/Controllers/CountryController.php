<?php
  
  namespace App\Http\Controllers;
  
  use App\Http\Filters\CountryFilter;
  use App\Http\Requests\CountryStoreRequest;
  use App\Http\Requests\CountryUpdateRequest;
  use App\Http\Resources\CountryResource;
  use App\Services\Interface\ICountryService;
  
  /**
   * @OA\Tag(
   *     name="Country",
   *     description="Country management APIs"
   * )
   */
  class CountryController extends Controller
  {
    protected $countryService;
    
    public function __construct(ICountryService $countryService)
    {
      $this->countryService = $countryService;
    }
    
    /**
     * @OA\Get(
     *     path="/api/v1/country",
     *     tags={"Country"},
     *     summary="Get all countries",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(ref="#/components/parameters/AcceptHeader"),
     *     @OA\Response(response=200, description="List of countries")
     * )
     */
    public function index(CountryFilter $filters)
    {
      $counties = $this->countryService->getAllCountries($filters);
      if ($filters->isPaginated()) {
        return response()->withPagination($counties, CountryResource::collection($counties));
      }
      return CountryResource::collection($counties);
    }
    
    /**
     * @OA\Post(
     *     path="/api/v1/country",
     *     tags={"Country"},
     *     summary="Create a new country",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(ref="#/components/parameters/AcceptHeader"),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","code"},
     *             @OA\Property(property="name", type="string", maxLength=255),
     *             @OA\Property(property="code", type="string", minLength=3, maxLength=3)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Country created")
     * )
     */
    public function store(CountryStoreRequest $request)
    {
      return CountryResource::make($this->countryService->createCountry($request->validated()));
    }
    
    /**
     * @OA\Get(
     *     path="/api/v1/country/{id}",
     *     tags={"Country"},
     *     summary="Get country by ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(ref="#/components/parameters/AcceptHeader"),
     *     @OA\Parameter(
     *         name="id", in="path", required=true, @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Country details"),
     *     @OA\Response(response=404, description="Country not found")
     * )
     */
    public function show(string $id)
    {
      return CountryResource::make($this->countryService->getCountryById($id));
    }
    
    /**
     * @OA\Put(
     *     path="/api/v1/country/{id}",
     *     tags={"Country"},
     *     summary="Update a country",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(ref="#/components/parameters/AcceptHeader"),
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", maxLength=255),
     *             @OA\Property(property="code", type="string", minLength=3, maxLength=3)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Country updated"),
     *     @OA\Response(response=404, description="Country not found")
     * )
     */
    public function update(CountryUpdateRequest $request, string $id)
    {
      return CountryResource::make($this->countryService->updateCountry($id, $request->validated()));
    }
    
    /**
     * @OA\Delete(
     *     path="/api/v1/country/{id}",
     *     tags={"Country"},
     *     summary="Delete a country",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(ref="#/components/parameters/AcceptHeader"),
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Response(response=204, description="Country deleted"),
     *     @OA\Response(response=404, description="Country not found")
     * )
     */
    public function destroy(string $id)
    {
      return $this->countryService->deleteCountry($id);
    }
  }
