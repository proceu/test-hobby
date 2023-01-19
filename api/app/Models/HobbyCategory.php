<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HobbyCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
    /**
     * @return HasMany
     */
    public function hobbies(): HasMany
    {
        return $this->hasMany(Hobby::class);
    }
}
