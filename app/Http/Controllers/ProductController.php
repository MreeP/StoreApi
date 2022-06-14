<?php

namespace App\Http\Controllers;

use App\Facades\ProductRepository;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return ProductResource::collection(
            ProductRepository::search($request)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductRequest $request
     * @return array|string[]
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->all());
        return [
            'message' => 'success',
            'id' => $product->id,
            'url' => route('api.products.show', ['product' => $product->id]),
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return ProductResource
     */
    public function show(Product $product): ProductResource
    {
        return new ProductResource(
            $product->load('prices'),
            false
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return string[]
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->all());
        return ['message' => 'success'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return string[]
     */
    public function destroy(Product $product)
    {
        if (auth()->check()) {
            $product->delete();
            return ['message' => 'success'];
        }
        return ['message' => 'unauthorized action'];
    }
}
