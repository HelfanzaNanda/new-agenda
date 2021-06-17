<?php

namespace App\Http\Resources\User;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
			'id' => $this->id,
			'name' => $this->name,
			'role' => $this->roles()->count() ? $this->getRoleNames()[0] : null,
			'email' => $this->email,
			'api_token' => $this->api_token,
		];
    }
}
