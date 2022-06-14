<?php

namespace Database\Seeders;

use App\Models\Price;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Output\ConsoleOutput;

class DatabaseSeeder extends Seeder
{
    private int $productsCount = 10;
    private int $pricesPerProduct = 3;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->seedUser();
        $this->seedProductsWithPrices();
    }

    private function seedUser()
    {
        $console = new ConsoleOutput();

        $password = 'password'; // Str::random();
        $user = User::factory()
            ->createOne([
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make($password),
            ]);

        $console->writeln("New user: <info>{$user->email}:{$password}</info>");
    }

    private function seedProductsWithPrices()
    {
        Product::factory()
            ->count($this->productsCount)
            ->has(Price::factory()->count($this->pricesPerProduct))
            ->create();
    }
}
