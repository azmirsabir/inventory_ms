<?php

namespace App\Repositories\Interfaces;

use App\Models\Country;

interface ICountryRepo
{
    public function all($filters);
    public function find($id): ?Country;
    public function create(array $data): Country;
    public function update(Country $country, array $data) : Country;
    public function delete(Country $country): bool;
}
