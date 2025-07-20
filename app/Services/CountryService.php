<?php
  
  namespace App\Services;
  
  use App\Exceptions\NotFoundException;
  use App\Http\Resources\CountryResource;
  use App\Models\Country;
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
      return $this->countryRepository->all($filters);
    }
    
    /**
     * @throws NotFoundException
     */
    public function getCountryById($id): Country
    {
      $country = $this->countryRepository->find($id);
      if (!$country) {
        throw new NotFoundException("Country with ID {$id} not found.");
      }
      return $country;
    }
    
    public function createCountry(array $data): Country
    {
      return $this->countryRepository->create($data);
    }
    
    /**
     * @throws NotFoundException
     */
    public function updateCountry($id, array $data): Country
    {
      $country = $this->countryRepository->find($id);
      if (!$country) {
        throw new NotFoundException("Country with ID {$id} not found.");
      }
      return $this->countryRepository->update($country, $data);
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
