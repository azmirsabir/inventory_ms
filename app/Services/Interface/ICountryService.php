<?php

namespace App\Services\Interface;

use App\Http\Resources\CountryResource;

interface ICountryService
{
    public function getAllCountries($filters);
    public function getCountryById($id) : CountryResource;
    public function createCountry(array $data) : CountryResource;
    public function updateCountry($id, array $data) : CountryResource;
    public function deleteCountry($id) : bool;
}
