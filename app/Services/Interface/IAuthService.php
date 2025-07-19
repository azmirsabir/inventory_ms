<?php

namespace App\Services\Interface;

use App\Repositories\Interfaces\IUserRepo;

interface IAuthService
{
    /**
     * Register a new user.
     *
     * @param array $data
     * @return mixed
     */
    public function register(array $data);

    /**
     * Login an existing user.
     *
     * @param array $credentials
     * @return mixed
     */
    public function login(array $credentials);

    /**
     * Logout the authenticated user.
     *
     * @return mixed
     */
    public function logout();

    /**
     * Get the authenticated user.
     *
     * @return mixed
     */
    public function getUser();

    /**
     * Update the authenticated user's information.
     *
     * @param array $data
     * @return mixed
     */
    public function updateUser(array $data);
}
