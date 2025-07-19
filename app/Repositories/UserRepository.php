<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\IUserRepo;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserRepository implements IUserRepo
{
   
    protected User $model;
    /**
     * Create a new class instance.
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }
    public function all($filters)
    {
        return $this->model->filter($filters);
    }
    public function find($id): ?User
    {
        return $this->model->find($id);
    }
    public function create(array $data): User
    {
        return $this->model->create($data);
    }
    public function update($user, array $data): User
    {
        $user->fill($data);
        $user->save();
        return $user;
    }
    public function delete($user): bool
    {
        return $user->delete();
    }
    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }
}
