<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderWrapperResource extends JsonResource
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
        foreach ($this->productOrder as $i) {
            $amount_for_order += $i->product->price;
        }
        return [
            'id' => $this->id,
            'table' => $this->table->name,
            'shift_worker' => $this->user->name,
            'create_at' => $this->create_at,
            'status' => $this->status,
            'price' => $amount_for_order,
        ];
    }
}
