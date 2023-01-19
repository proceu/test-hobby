<?php

namespace App\Repo;

use App\Models\Hobby;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class HobbyRepo extends CoreRepo
{
    protected function getModelClass(): string
    {
        return Hobby::class;
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
            $query->where('name', 'like','%'.$data['q'].'%');
        }

        if (array_key_exists('hobby_category', $data) && $data['hobby_category']) {
            $query->whereHas('category', function (Builder $sub) use ($data) {
                $sub->where('name','like','%'.$data['hobby_category'].'%');
            });
        }

        return $query->paginate($perPage,['*'],'page',$page);
    }
}
