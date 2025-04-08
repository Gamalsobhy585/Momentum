<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'posts_count' => $this->posts_count ?? $this->posts()->count(),

          
        ];

        return $data;
    }
}




