<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowOrderOnShiftResource extends JsonResource
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
        foreach ($this->order as $item) {
            foreach ($item->productOrder as $i) {
                $amount_for_all += $i->product->price;
            }
        }

        return [
            'id' => $this->id,
            'start' => $this->start,
            'end' => $this->end,
            'active' => $this->active,
            'orders' => OrderWrapperResource::collection($this->order),
            'amount_for_all' => $amount_for_all,
        ];
    }
}
