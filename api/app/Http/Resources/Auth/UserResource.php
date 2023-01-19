<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\HobbyResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class UserResource extends JsonResource
{
    /**
     * @var string|null
     */
    public static $wrap = 'user';

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'id'    =>  $this->id,
            'name'  =>  $this->name,
            'email' =>  $this->email,
            'hobbies' => HobbyResource::collection($this->hobbies),
        ];
    }
}
