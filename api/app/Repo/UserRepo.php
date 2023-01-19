<?php

namespace App\Repo;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;

class UserRepo extends CoreRepo
{
    protected function getModelClass(): string
    {
        return User::class;
    }

    /**
     * @param string $email
     * @return Model|Builder
     */
    public function findByEmail(string $email): Model|Builder
    {
        $query = $this->query();
        $query->where('email',$email);

        return $query->firstOrFail();
    }

    /**
     * @param int $id
     * @param array $data
     * @return void
     */
    public function attachHobby(int $id, array $data): void
    {
        $user = $this->find($id);

        $user->hobbies()->attach($data['hobby_id']);
    }

    /**
     * @param int $id
     * @param array $data
     * @return void
     */
    public function detachHobby(int $id, array $data): void
    {
        $user = $this->find($id);

        $user->hobbies()->detach($data['hobby_id']);
    }

    /**
     * @param int $id
     * @param array $data
     * @return void
     */
    public function syncHobby(int $id, array $data): void
    {
        $user = $this->find($id);

        $user->hobbies()->sync($data['hobby_ids']);
    }
}
