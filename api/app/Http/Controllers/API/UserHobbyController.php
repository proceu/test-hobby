<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserHobby\AttachDetachHobbyRequest;
use App\Http\Requests\UserHobby\SyncHobbyRequest;
use App\Repo\UserRepo;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserHobbyController extends Controller
{
    private UserRepo $repo;

    public function __construct(UserRepo $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param AttachDetachHobbyRequest $request
     * @return JsonResponse
     */
    public function attach(AttachDetachHobbyRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user_id = $request->user()->getKey();

        try {
            $this->repo->attachHobby($user_id,$data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode()?:500);
        }

        return new JsonResponse([
            'message'   =>  'Success'
        ]);
    }

    /**
     * @param AttachDetachHobbyRequest $request
     * @return JsonResponse
     */
    public function detach(AttachDetachHobbyRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user_id = $request->user()->getKey();

        try {
            $this->repo->detachHobby($user_id,$data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode()?:500);
        }

        return new JsonResponse([
            'message'   =>  'Success'
        ]);
    }

    /**
     * @param SyncHobbyRequest $request
     * @return JsonResponse
     */
    public function sync(SyncHobbyRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user_id = $request->user()->getKey();

        try {
            $this->repo->syncHobby($user_id,$data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode()?:500);
        }

        return new JsonResponse([
            'message'   =>  'Success'
        ]);
    }
}
