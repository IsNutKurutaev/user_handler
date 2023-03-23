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
        $amount_for_order = 0;
        foreach ($this->productOrder as $item) {
            $amount_for_order += $item->product->price;
        }

        return [
            'id' => $this->id,
            'table' => $this->table->name,
            'shift_worker' => $this->user->name,
            'create_at' => $this->create_at,
            'status' => $this->status,
            'positions' => PositionsOrderWrapper::collection($this->productOrder),
            'price_all' => $amount_for_order,
        ];
    }
}
