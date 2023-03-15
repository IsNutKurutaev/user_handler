<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ShowUsersResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return \Illuminate\Support\Collection
     */
    public function toArray($request)
    {
        $collection_for_return_an_array = new Collection();
        foreach ($this as $item)
        {
            $collection_for_return_an_array->add(
                [
                    'id' => $item->id,
                    'name' => $item->name,
                    'login' => $item->login,
                    'status' => $item->status ? 'working' : 'vacation',
                    'group' => $item->group->name
                ]
            );
        }

        return $collection_for_return_an_array;
    }
}
