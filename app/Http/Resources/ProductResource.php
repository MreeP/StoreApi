<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;
use JetBrains\PhpStorm\Pure;
use JsonSerializable;

class ProductResource extends JsonResource
{

    public function __construct(
        $resource,
        public bool $withoutDetails = true
    )
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        $withDetails = !$request->routeIs('api.products.index') || ($request->routeIs('api.products.index') && auth()->check());

        return [
            'name' => $this->name,
            'description' => $this->description,
            'sale' => $this->sale,
            $this->mergeWhen(!$withDetails || auth()->check(), [
                'id' => $this->id,
                'uri' => route('api.products.show', ['product' => $this->id]),
            ]),
            'details' => $this->when($withDetails, $this->details),
            'prices' => PriceResource::collection($this->whenLoaded('prices')),
        ];
    }
}
