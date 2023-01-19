<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Hobby\SearchHobbyRequest;
use App\Http\Requests\Hobby\StoreHobbyRequest;
use App\Http\Requests\Hobby\UpdateHobbyRequest;
use App\Http\Resources\HobbyResource;
use App\Repo\HobbyRepo;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class HobbyController extends Controller
{
    private HobbyRepo $repo;

    public function __construct(HobbyRepo $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param SearchHobbyRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(SearchHobbyRequest $request): AnonymousResourceCollection
    {
        $data = $request->validated();

        return HobbyResource::collection($this->repo->search($data));
    }

    /**
     * @param StoreHobbyRequest $request
     * @return JsonResponse|HobbyResource
     */
    public function store(StoreHobbyRequest $request): JsonResponse|HobbyResource
    {
        $data = $request->validated();

        try {
            $hobby = $this->repo->store($data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode()?:500);
        }

        return new HobbyResource($hobby);
    }

    /**
     * @param int $id
     * @return JsonResponse|HobbyResource
     */
    public function show(int $id): JsonResponse|HobbyResource
    {
        try {
            $hobby = $this->repo->find($id);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode()?:500);
        }

        return new HobbyResource($hobby);
    }

    /**
     * @param int $id
     * @param UpdateHobbyRequest $request
     * @return JsonResponse|HobbyResource
     */
    public function update(int $id, UpdateHobbyRequest $request): JsonResponse|HobbyResource
    {
        $data = $request->validated();

        try {
            $hobby = $this->repo->update($id,$data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode()?:500);
        }

        return new HobbyResource($hobby);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->repo->destroy($id);
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
