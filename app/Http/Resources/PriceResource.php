<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PriceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'variant' => $this->variant,
            'value' => $this->value,
            $this->mergeWhen(auth()->check(), [
                'product_id' => $this->product_id,
                'id' => $this->id,
                'active' => $this->active,
                'url' => route('api.prices.show', ['price' => $this->id]),
            ]),
        ];
    }
}
