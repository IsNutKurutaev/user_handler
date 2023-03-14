<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'data' => [
                    'id' => $this->id,
                    'status' => 'created'
            ]
        ];
    }
}
