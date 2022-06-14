<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsListingTest extends TestCase
{

    use RefreshDatabase;

    public function test_receives_response()
    {
        $response = $this->get('/api/products/');
        $response->assertStatus(200);
    }

    public function test_products_list_entries()
    {
        $products = Product::factory()->count(10)->create(['active' => true]);

        $response = $this->get('/api/products');
        $response->assertStatus(200)
            ->assertSeeInOrder(
                $products->sortBy('name', SORT_STRING|SORT_FLAG_CASE)
                    ->pluck('name')
                    ->toArray()
            );
    }

    public function test_products_sorting()
    {
        $products = Product::factory()->count(10)->create(['active' => true]);

        $response = $this->get('/api/products?asc=0');
        $response->assertStatus(200)
            ->assertSeeInOrder(
                $products->sortByDesc('name', SORT_NATURAL|SORT_FLAG_CASE)
                    ->pluck('name')
                    ->toArray()
            );
    }

    public function test_products_filtering()
    {
        $products = Product::factory()->count(10)->create(['active' => true]);

        $response = $this->get('/api/products?onSale=1');
        $content = collect(json_decode($response->content())->data);

        $this->assertTrue(
            $content->pluck('name')
                ->diff(
                    $products->where('sale', true)
                        ->pluck('name')
                        ->toArray()
                )->isEmpty()
        );

        $this->assertFalse($content->pluck('name')->hasAny(
            $products->where('sale', false)
                ->pluck('name')
                ->toArray()
        ));
    }

    public function test_search()
    {
        $products = Product::factory()->count(10)->create(['active' => true]);

        $response = $this->get("/api/products?search={$products->first()['name']}");
        $content = collect(json_decode($response->content())->data);

        $this->assertCount(1, $content);

        $response = $this->get("/api/products?search=this_id_doesnt_exist");
        $content = collect(json_decode($response->content())->data);

        $this->assertCount(0, $content);
    }

    public function test_admin_fields()
    {
        $products = Product::factory()->count(10)->create(['active' => true]);
        $user = User::factory()->createOne();

        $response = $this->get("/api/products");
        $response->assertJsonMissingPath('data.0.details');

        auth()->setUser($user);

        $response = $this->get("/api/products");
        $response->assertJsonPath('data.0.details',
            $products->sortBy('name', SORT_STRING|SORT_FLAG_CASE)->first()['details']
        );
    }
}
