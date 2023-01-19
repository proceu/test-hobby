<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\HobbyCategory\SearchHobbyCategoryRequest;
use App\Http\Requests\HobbyCategory\StoreHobbyCategoryRequest;
use App\Http\Requests\HobbyCategory\UpdateHobbyCategoryRequest;
use App\Http\Resources\HobbyCategoryResource;
use App\Repo\HobbyCategoryRepo;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class HobbyCategoryController extends Controller
{
    private HobbyCategoryRepo $repo;

    public function __construct(HobbyCategoryRepo $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param SearchHobbyCategoryRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(SearchHobbyCategoryRequest $request): AnonymousResourceCollection
    {
        $data = $request->validated();

        return HobbyCategoryResource::collection($this->repo->search($data));
    }

    /**
     * @param StoreHobbyCategoryRequest $request
     * @return HobbyCategoryResource|JsonResponse
     */
    public function store(StoreHobbyCategoryRequest $request): HobbyCategoryResource|JsonResponse
    {
        $data = $request->validated();

        try {
            $category = $this->repo->store($data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode()?:500);
        }

        return new HobbyCategoryResource($category);
    }

    /**
     * @param int $id
     * @return HobbyCategoryResource|JsonResponse
     */
    public function show(int $id): HobbyCategoryResource|JsonResponse
    {
        try {
            $category = $this->repo->find($id);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode()?:500);
        }

        return new HobbyCategoryResource($category);
    }

    /**
     * @param int $id
     * @param UpdateHobbyCategoryRequest $request
     * @return HobbyCategoryResource|JsonResponse
     */
    public function update(int $id, UpdateHobbyCategoryRequest $request): HobbyCategoryResource|JsonResponse
    {
        $data = $request->validated();

        try {
            $category = $this->repo->update($id,$data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode()?:500);
        }

        return new HobbyCategoryResource($category);
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
