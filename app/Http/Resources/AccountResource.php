<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'username' => $this->user->username,
            'bio' => $this->bio,
            'phone_number' => $this->phone_number,
            'image' => $this->image,
            'college_name' => $this->college->name,
            'linkedIn_account' => $this->linkedIn_account,
            'facebook_account' => $this->facebook_account,
            'github_account' => $this->github_account,
            'x_account' => $this->x_account,
            'skills' => $this->skills,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
