<?php

namespace App\Repositories;

use App\Models\Country;
use App\Repositories\Interfaces\ICountryRepo;
class CountryRepository implements ICountryRepo
{
    protected $model;
    public function __construct(Country $country)
    {
        $this->model = $country;
    }
    public function all($filters)
    {
      return $this->model->filter($filters);
    }
    public function find($id) : ?Country
    {
      return $this->model->find($id);
    }
    public function create(array $data): Country
    {
      return $this->model->create($data);
    }
    public function update(Country $country, array $data): Country
    {
      $country->fill($data);
      $country->save();
      return $country;
    }
    public function delete(Country $country): bool
    {
      return $country->delete();
    }
}
