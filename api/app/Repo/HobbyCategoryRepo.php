<?php

namespace App\Repo;

use App\Models\HobbyCategory;

class HobbyCategoryRepo extends CoreRepo
{
    protected function getModelClass(): string
    {
        return HobbyCategory::class;
    }
}
