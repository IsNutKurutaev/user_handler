<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $amount_for_all = 0;
        foreach ($this->get() as $item) {
            $amount_for_all += $item->position->price;
        }

        return [
            'id' => $this->id,
            'start' => $this->shift->start,
            'end' => $this->shift->end,
            'active' => $this->shift->active,
            'orders' => $this->position->get(),
            'amount_for_all' => $amount_for_all,
        ];
    }
}
