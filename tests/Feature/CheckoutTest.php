<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class CheckoutTest extends TestCase
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
        $this->product = Product::create([
            'category_id' => $cat->id,
            'name' => 'Hammer',
            'description' => 'A hammer.',
            'price' => 9.99,
            'stock_quantity' => 3,
            'image_url' => null,
        ]);
    }

    private function createBasketForUser(User $user, Product $product, int $quantity = 2) {
        $basket = $user->basket()->create([
            'user_id' => $user->id,
        ]);

        $basket->basketItems()->create([
            'basket_id' => $basket->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
        ]);

        return $basket;
    }

    public function test_authenticated_user_can_checkout()
    {
        $this->createBasketForUser($this->user, $this->product, 2);

        $response = $this->actingAs($this->user)->post(route('checkout.process'), [
            'street_address' => '123 Main St',
            'city' => 'Sample City',
            'postal_code' => 'A1 2BC',
            'phone_number' => '0712345678',
        ]);

        $response->assertRedirect();

        $order = Order::where('user_id', $this->user->id)->latest()->first();
        $this->assertNotNull($order);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'user_id' => $this->user->id,
            'price' => 19.98,
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('shipping_addresses', [
            'order_id' => $order->id,
            'street_address' => '123 Main St',
            'city' => 'Sample City',
            'postal_code' => 'A1 2BC',
            'phone_number' => '0712345678',
        ]);

        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $this->product->id,
            'quantity' => 2,
            'purchase_price' => 9.99, 
        ]);

        $this->assertDatabaseHas('stock_movements', [
            'product_id' => $this->product->id,
            'type' => 'out',
            'quantity' => 2,
            'reference' => 'Customer order #' . $order->id,
        ]);   

        $this->assertDatabaseHas('products', [
            'id' => $this->product->id,
            'stock_quantity' => 1,
        ]);

        $this->assertDatabaseMissing('basket_items', [
            'product_id' => $this->product->id,
        ]);
    }

    public function test_checkout_fails_when_basket_is_empty()
    {
        $response = $this->actingAs($this->user)->post(route('checkout.process'), [
            'street_address' => '123 Main St',
            'city' => 'Sample City',
            'postal_code' => 'A1 2BC',
            'phone_number' => '0712345678',
        ]);

        $response->assertRedirect(route('basket'));
        $response->assertSessionHas('error', 'Basket is empty');

        $this->assertDatabaseCount('orders', 0);
    }

    public function test_checkout_requires_valid_shipping_info()
    {
        $this->createBasketForUser($this->user, $this->product, 1);

        $response = $this->actingAs($this->user)->post(route('checkout.process'));

        $response->assertSessionHasErrors(['street_address', 'city', 'postal_code', 'phone_number']);

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('shipping_addresses', 0);
    }

    public function test_user_cannot_view_another_users_order()
    {
        $otherUser = User::factory()->create();
        $order = Order::create([
            'user_id' => $otherUser->id,
            'order_number' => 'ORD-2026-999',
            'price' => 9.99,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->user)->get(route('order.show', $order));

        $response->assertStatus(403);
    }
}
