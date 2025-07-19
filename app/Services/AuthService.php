<?php

namespace App\Services;

use App\Exceptions\UnAuthenticatedException;
use App\Http\Resources\AuthResource;
use App\Http\Resources\UserResource;
use App\Repositories\Interfaces\IUserRepo;
use App\Services\Interface\IAuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService implements IAuthService
{
  protected IUserRepo $userRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(IUserRepo $IUserRepo)
    {
        $this->userRepository = $IUserRepo;
    }
    
    public function register(array $data)
    {
      $data['password'] = Hash::make($data['password']);
      $user= $this->userRepository->create($data);
      $token = JWTAuth::fromUser($user);
      $user->api_token = $token;
      $user->expires_in = auth('api')->factory()->getTTL() * 60;
      return new AuthResource($user);
    }
    public function login(array $credentials)
    {
      try {
        if (!$token = JWTAuth::attempt($credentials)) if (!$token)
          throw new UnAuthenticatedException();
          $user = Auth::user();
          $user->api_token = $token;
          $user->expires_in = auth('api')->factory()->getTTL() * 60;
          return new AuthResource($user);
      } catch (\Exception $e) {
        throw new UnAuthenticatedException();
      }
    }
    
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }
    
    public function getUser()
    {
        return new UserResource(Auth::user());
    }
    
    public function updateUser(array $data)
    {
        $user = Auth::user();
        $updatedUser=$this->userRepository->update($user, $data);
        return new UserResource($updatedUser);
    }
}
