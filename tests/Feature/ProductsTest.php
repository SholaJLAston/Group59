<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
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

    public function test_products_page_can_be_rendered()
    {
        $response = $this->get(route('products'));
        $response->assertStatus(200);
        $response->assertViewIs('products');
        $response->assertSee('Our Products');

        // when no filter is applied there should be at least one product
        $response->assertSee('product-card');
        $this->assertEquals(1, \App\Models\Product::count());
    }

    public function test_home_page_displays_categories()
    {
        // category from setup should appear
        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee('General Tools');
    }

    public function test_filter_by_category_parameter()
    {
        // Create second category and product
        $other = Category::create(['name' => 'Materials']);
        Product::create([
            'category_id' => $other->id,
            'name' => 'Wood',
            'description' => 'A plank of wood.',
            'price' => 5.00,
            'stock_quantity' => 10,
            
        ]);

        $response = $this->get(route('products', ['category' => 'materials']));
        $response->assertStatus(200);
        $response->assertSee('Wood');
        $response->assertDontSee('Hammer');

        // clear filter link should appear when a category is selected
        $response->assertSee('Show all products');

        // also test search filtering
        $searchResponse = $this->get(route('products', ['search' => 'Hammer']));
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('Hammer');
        $searchResponse->assertDontSee('Wood');

        // when clearing the filter we see both names
        $clear = $this->get(route('products'));
        $clear->assertSee('Hammer');
        $clear->assertSee('Wood');
    }

    public function test_product_detail_page_shows_information()
    {
        $product = Product::first();
        $response = $this->get(route('products.show', $product));
        $response->assertStatus(200);
        $response->assertViewIs('productdetails');
        $response->assertSee($product->name);
        $response->assertSee((string)number_format($product->price,2));
    }
}
