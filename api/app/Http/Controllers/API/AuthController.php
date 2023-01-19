<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\TokenResource;
use App\Http\Resources\Auth\UserResource;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthService $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse|TokenResource
     */
    public function login(LoginRequest $request): JsonResponse|TokenResource
    {
        $data = $request->validated();

        try {
            $user = $this->service->login($data);
        } catch (Exception $exception) {
            return new JsonResponse([
                'message'   =>  $exception->getMessage(),
            ],$exception->getCode());
        }

        return new TokenResource($user);
    }

    /**
     * @param RegisterRequest $request
     * @return TokenResource|JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse|TokenResource
    {
        $data = $request->validated();

        try {
            $user = $this->service->register($data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return new TokenResource($user);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $this->service->logout($request->user()->getKey());
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
        return new JsonResponse([
            'message'   =>  'Logout success',
        ]);
    }

    /**
     * @param Request $request
     * @return UserResource|JsonResponse
     */
    public function user(Request $request): JsonResponse|UserResource
    {
        try {
            $user = $this->service->user($request->user()->getKey());
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return new UserResource($user);
    }
}
