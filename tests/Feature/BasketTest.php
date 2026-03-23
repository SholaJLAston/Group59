<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class BasketTest extends TestCase
{
    use RefreshDatabase;
    
    private User $user;
    private Product $product;
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        // seed minimal categories and products
        $cat = Category::create(['name' => 'General Tools']);
        Product::create([
            'category_id' => $cat->id,
            'name' => 'Hammer',
            'description' => 'A hammer.',
            'price' => 9.99,
            'stock_quantity' => 3,
            'image_url' => null,
        ]);
    }

    public function test_authenticated_user_can_add_product_to_basket()
    {
        $response = $this->actingAs($this->user)->post(route('basket.add', $this->product), [
            'quantity' => 2,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Product added to basket successfully.');

        $this->assertDatabaseHas('basket_items', [
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);  
    }

    public function test_adding_same_product_twice_updates_quantity()
    {
        $this->actingAs($this->user)->post(route('basket.add', $this->product), [
            'quantity' => 1,
        ]);

        $this->actingAs($this->user)->post(route('basket.add', $this->product), [
            'quantity' => 2,
        ]);

        $this->assertDatabaseHas('basket_items', [
            'product_id' => $this->product->id,
            'quantity' => 3,
        ]);  
    }

    public function test_cannot_add_product_exceeding_stock()
    {
        $response = $this->actingAs($this->user)->post(route('basket.add', $this->product), [
            'quantity' => 5, 
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Requested quantity exceeds available stock.');

        $this->assertDatabaseMissing('basket_items', [
            'product_id' => $this->product->id,
        ]);  
    }

    public function test_user_cannot_update_another_user_basket_item()
    {
        $otherUser = User::factory()->create();

        $basketItem = $otherUser->basket()->firstOrCreate()->basketItems()->create([
            'product_id' => $this->product->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($this->user)->patch(route('basket.update', $basketItem), [
            'quantity' => 2,
        ]);

        $response->assertStatus(403); 
    }

    public function test_user_can_clear_their_basket()
    {
        $this->actingAs($this->user)->post(route('basket.add', $this->product), [
            'quantity' => 2,
        ]);

        $response = $this->actingAs($this->user)->delete(route('basket.clear'));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Basket cleared successfully.');

        $this->assertDatabaseMissing('basket_items', [
            'product_id' => $this->product->id,
        ]);
    }

    public function test_user_cannot_remove_another_user_basket_item()
    {
        $otherUser = User::factory()->create();
        $basketItem = $otherUser->basket()->firstOrCreate()->basketItems()->create([
            'product_id' => $this->product->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($this->user)->delete(route('basket.remove', $basketItem));

        $response->assertStatus(403); 
    }

}
