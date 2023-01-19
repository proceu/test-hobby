<?php

namespace App\Repo;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;

abstract class CoreRepo
{
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * CoreRepo constructor.
     */
    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    /**
     * @return string
     */
    abstract protected function getModelClass(): string;


    /**
     * @return Builder|Model
     */
    protected function query(): Model|Builder
    {
        return $this->model->newModelQuery();
    }

    /**
     * @param int $id
     * @return Model
     */
    public function find(int $id): Model
    {
        if (!$item = $this->query()->find($id)) {
            throw new RuntimeException('Item not found!',404);
        }
        return $item;
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->query()->get();
    }

    /**
     * @param array $data
     * @return Model|Builder
     */
    public function store(array $data): Model|Builder
    {
        return $this->query()->create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Builder|Collection|Model
     */
    public function update(int $id, array $data): Model|Collection|Builder
    {
        $query = $this->query();

        $item = $query->find($id);

        $item->update($data);

        return $item;
    }

    /**
     * @param int $id
     * @return void
     */
    public function destroy(int $id): void
    {
        $query = $this->query();

        $item = $query->find($id);

        $item->delete();
    }

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function search(array $data): LengthAwarePaginator
    {
        $perPage = array_key_exists('perPage', $data) && $data['perPage']? $data['perPage']:10;
        $page = array_key_exists('page', $data) && $data['page']? $data['page']:1;
        $query = $this->query();

        if (array_key_exists('q', $data) && $data['q']) {
            $query->where('name','like','%'.$data['q'].'%');
        }

        return $query->paginate($perPage,['*'],'page',$page);
    }
}
