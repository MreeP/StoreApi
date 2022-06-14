<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePriceRequest;
use App\Http\Requests\UpdatePriceRequest;
use App\Http\Resources\PriceResource;
use App\Models\Price;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PriceController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePriceRequest $request
     * @return array
     */
    public function store(StorePriceRequest $request): array
    {
        $price = Price::create($request->all());
        return [
            'message' => 'success',
            'id' => $price->id,
            'url' => route('api.prices.show', ['price' => $price->id]),
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param Price $price
     * @return PriceResource
     */
    public function show(Price $price)
    {
        return new PriceResource($price);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePriceRequest $request
     * @param Price $price
     * @return string[]
     */
    public function update(UpdatePriceRequest $request, Price $price)
    {
        $price->update($request->all());
        return ['message' => 'success'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Price $price
     * @return string[]
     */
    public function destroy(Price $price)
    {
        $price->delete();
        return ['message' => 'success'];
    }
}
