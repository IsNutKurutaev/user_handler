<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowUsersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */

        public function  toArray($request)
        {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'login' => $this->login,
                'status' => $this->status->name,
                'group' => $this->group->name
            ];
        }
}
