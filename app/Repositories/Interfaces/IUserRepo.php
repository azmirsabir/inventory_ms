<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface IUserRepo
{
    public function all($filters);

    public function find($id);

    public function create(array $data);

    public function update($user, array $data);

    public function delete($user): bool;

    public function findByEmail(string $email);
}
