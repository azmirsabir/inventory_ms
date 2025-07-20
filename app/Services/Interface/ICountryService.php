<?php

namespace App\Services\Interface;

use App\Http\Resources\CountryResource;
use App\Models\Country;

interface ICountryService
{
    public function getAllCountries($filters);
    public function getCountryById($id) : Country;
    public function createCountry(array $data) : Country;
    public function updateCountry($id, array $data) : Country;
    public function deleteCountry($id) : bool;
}
