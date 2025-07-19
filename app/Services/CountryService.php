<?php
  
  namespace App\Services;
  
  use App\Exceptions\NotFoundException;
  use App\Http\Resources\CountryResource;
  use App\Repositories\Interfaces\ICountryRepo;
  use App\Services\Interface\ICountryService;
  
  class CountryService implements ICountryService
  {
    protected ICountryRepo $countryRepository;
    
    public function __construct(ICountryRepo $countryRepository)
    {
      $this->countryRepository = $countryRepository;
    }
    
    public function getAllCountries($filters)
    {
      $counties = $this->countryRepository->all($filters);
      if ($filters->isPaginated()) {
        return response()->withPagination($counties, CountryResource::collection($counties));
      }
      return CountryResource::collection($counties);
    }
    
    /**
     * @throws NotFoundException
     */
    public function getCountryById($id): CountryResource
    {
      $country = $this->countryRepository->find($id);
      if (!$country) {
        throw new NotFoundException("Country with ID {$id} not found.");
      }
      return new CountryResource($country);
    }
    
    public function createCountry(array $data): CountryResource
    {
      return new CountryResource($this->countryRepository->create($data));
    }
    
    /**
     * @throws NotFoundException
     */
    public function updateCountry($id, array $data): CountryResource
    {
      $country = $this->countryRepository->find($id);
      if (!$country) {
        throw new NotFoundException("Country with ID {$id} not found.");
      }
      return new CountryResource($this->countryRepository->update($country, $data));
    }
    
    /**
     * @throws NotFoundException
     */
    public function deleteCountry($id): bool
    {
      $country = $this->countryRepository->find($id);
      
      if (!$country) {
        throw new NotFoundException("Country with ID {$id} not found.");
      }
      
      return $this->countryRepository->delete($country);
    }
  }
