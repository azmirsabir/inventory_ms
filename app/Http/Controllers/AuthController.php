<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Services\Interface\IAuthService;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Authentication APIs"
 * )
 */
class AuthController extends Controller
{
    protected IAuthService $authService;
    public function __construct(IAuthService $authService)
    {
        $this->authService = $authService;
    }
  
  /**
   * @OA\Post(
   *     path="/api/v1/auth/register",
   *     tags={"Auth"},
   *     summary="Register a new user",
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             required={"name", "email", "password"},
   *             @OA\Property(property="name", type="string", example="Test User"),
   *             @OA\Property(property="email", type="string", example="test@example.com"),
   *             @OA\Property(property="password", type="string", format="password", example="password"),
   *         )
   *     ),
   *     @OA\Response(response=201, description="User registered successfully"),
   *     @OA\Response(response=422, description="Validation error")
   * )
   */
    public function register(UserRegisterRequest $request)
    {
        return $this->authService->register($request->validated());
    }
  
  /**
   * @OA\Post(
   *     path="/api/v1/auth/login",
   *     tags={"Auth"},
   *     summary="User login",
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             required={"email", "password"},
   *             @OA\Property(property="email", type="string", example="john@example.com"),
   *             @OA\Property(property="password", type="string", format="password", example="12345678")
   *         )
   *     ),
   *     @OA\Response(response=200, description="Login successful"),
   *     @OA\Response(response=401, description="Invalid credentials")
   * )
   */
    public function login(UserLoginRequest $request)
    {
        return $this->authService->login($request->validated());
    }
  
  /**
   * @OA\Post(
   *     path="/api/v1/auth/logout",
   *     tags={"Auth"},
   *     summary="Logout current user",
   *     security={{"bearerAuth":{}}},
   *     @OA\Response(response=200, description="Logout successful")
   * )
   */
    public function logout()
    {
      return $this->authService->logout();
    }
  
  /**
   * @OA\Get(
   *     path="/api/v1/auth/user",
   *     tags={"Auth"},
   *     summary="Get authenticated user details",
   *     security={{"bearerAuth":{}}},
   *     @OA\Response(response=200, description="User details")
   * )
   */
    public function getUser()
    {
        return $this->authService->getUser();
    }
  
  /**
   * @OA\Put(
   *     path="/api/v1/auth/user",
   *     tags={"Auth"},
   *     summary="Update authenticated user",
   *     security={{"bearerAuth":{}}},
   *     @OA\RequestBody(
   *         @OA\JsonContent(
   *             @OA\Property(property="name", type="string", example="Jane Smith"),
   *             @OA\Property(property="email", type="string", example="jane@example.com"),
   *             @OA\Property(property="password", type="string", example="newpassword123")
   *         )
   *     ),
   *     @OA\Response(response=200, description="User updated successfully"),
   *     @OA\Response(response=422, description="Validation error")
   * )
   */
    public function updateUser(UserUpdateRequest $request)
    {
        return $this->authService->updateUser($request->validated());
    }
}
