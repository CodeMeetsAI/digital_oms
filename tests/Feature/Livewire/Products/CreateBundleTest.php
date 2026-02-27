<?php

namespace Tests\Feature\Livewire\Products;

use App\Livewire\Products\CreateBundle;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CreateBundleTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_bundle()
    {
        $category = Category::factory()->create();
        $unit = Unit::factory()->create();

        $product1 = Product::factory()->create([
            'buying_price' => 1000, // $10.00
            'selling_price' => 2000, // $20.00
            'quantity' => 10,
        ]);

        $product2 = Product::factory()->create([
            'buying_price' => 1500, // $15.00
            'selling_price' => 3000, // $30.00
            'quantity' => 10,
        ]);

        Livewire::test(CreateBundle::class)
            ->set('name', 'Test Bundle')
            ->set('sku_autogenerate', true)
            ->set('selling_price', 5000) // $50.00
            ->set('category_id', $category->id)
            ->set('unit_id', $unit->id)
            ->call('addProduct', $product1)
            ->call('addProduct', $product2)
            ->call('updateQuantity', 0, 2) // 2 units of product1
            ->call('store')
            ->assertRedirect(route('products.index'));

        $this->assertDatabaseHas('products', [
            'name' => 'Test Bundle',
            'selling_price' => 5000,
            'buying_price' => 3500, // (1000 * 2) + (1500 * 1) = 2000 + 1500 = 3500
        ]);

        $bundleProduct = Product::where('name', 'Test Bundle')->first();

        $this->assertDatabaseHas('bundles', [
            'product_id' => $bundleProduct->id,
            'total_cost' => 3500,
        ]);

        $this->assertDatabaseHas('bundle_items', [
            'product_id' => $product1->id,
            'quantity' => 2,
        ]);

        $this->assertDatabaseHas('bundle_items', [
            'product_id' => $product2->id,
            'quantity' => 1,
        ]);
    }

    public function test_validates_required_fields()
    {
        Livewire::test(CreateBundle::class)
            ->call('store')
            ->assertHasErrors(['name', 'selling_price', 'category_id', 'unit_id', 'selectedProducts']);
    }
}
