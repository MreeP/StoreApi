<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsManagementTest extends TestCase
{

    use RefreshDatabase;

    public function test_create_product()
    {
        $user = User::factory()->createOne();

        $this->post("/api/products", [
            'name' => 'test',
            'description' => 'test',
            'active' => true,
            'sale' => false,
            'details' => null,
        ])
            ->assertStatus(403)
            ->assertJson(['message' => 'unauthenticated']);

        $this->assertDatabaseMissing('products', [
            'name' => 'test',
            'description' => 'test',
            'active' => true,
            'sale' => false,
        ]);

        auth()->setUser($user);

        $this->post("/api/products", [
            'name' => 'test',
            'description' => 'test',
            'active' => true,
            'sale' => false,
            'details' => null,
        ])
            ->assertStatus(200)
            ->assertJsonPath('message', 'success');

        $this->assertDatabaseHas('products', [
            'name' => 'test',
            'description' => 'test',
            'active' => true,
            'sale' => false,
        ]);
    }

    public function test_update_product()
    {
        $product = Product::factory()->createOne();
        $user = User::factory()->createOne();

        $this->patch("/api/products/{$product->id}", [
            'name' => 'test',
            'description' => 'test',
            'active' => true,
            'sale' => false,
            'details' => null,
        ])
            ->assertStatus(403)
            ->assertJson(['message' => 'unauthenticated']);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
            'name' => 'test',
            'description' => 'test',
            'active' => true,
            'sale' => false,
        ]);

        auth()->setUser($user);

        $this->patch("/api/products/{$product->id}", [
            'name' => 'test',
            'description' => 'test',
            'active' => true,
            'sale' => false,
            'details' => null,
        ])
            ->assertStatus(200)
            ->assertJsonPath('message', 'success');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'test',
            'description' => 'test',
            'active' => true,
            'sale' => false,
        ]);
    }

    public function test_delete_product()
    {
        $product = Product::factory()->createOne();
        $user = User::factory()->createOne();

        $this->delete("/api/products/{$product->id}")
            ->assertStatus(403)
            ->assertJson(['message' => 'unauthenticated']);

        $this->assertDatabaseHas('products', ['id' => $product->id]);

        auth()->setUser($user);

        $this->delete("/api/products/{$product->id}")
            ->assertStatus(200)
            ->assertJsonPath('message', 'success');

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
