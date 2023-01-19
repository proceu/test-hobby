<?php

namespace App\Services;

use App\Repo\UserRepo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class AuthService
{
    private UserRepo $repo;

    public function __construct(UserRepo $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param array $data
     * @return Model|Builder
     */
    public function login(array $data): Model|Builder
    {
        if (!Auth::attempt($data)) {
            throw new RuntimeException('Wrong credentials', 401);
        }

        $user = $this->repo->findByEmail($data['email']);

        return $user;
    }

    /**
     * @param array $data
     * @return Model|Builder
     */
    public function register(array $data): Model|Builder
    {
        $data['password'] = Hash::make($data['password']);

        $user = $this->repo->store($data);

        return $user;
    }

    /**
     * @param int $id
     * @return void
     */
    public function logout(int $id): void
    {
        if (!$user = $this->repo->find($id)) {
            throw new RuntimeException('User not found', 404);
        }

        $user->tokens()->delete();
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function user(int $id): ?Model
    {
        $user = $this->repo->find($id);

        return $user;
    }
}
