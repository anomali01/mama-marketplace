<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\StudyProgram;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $buyer;
    private User $seller;
    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a study program and category for the product
        $prodi = StudyProgram::factory()->create();
        $category = Category::factory()->create();

        // Create a seller and a buyer
        $this->seller = User::factory()->create(['role' => 'mahasiswa', 'prodi_id' => $prodi->id]);
        $this->buyer = User::factory()->create(['role' => 'pelanggan', 'prodi_id' => $prodi->id]);

        // Create a product
        $this->product = Product::factory()->create([
            'seller_id' => $this->seller->id,
            'category_id' => $category->id,
            'prodi_id' => $prodi->id,
            'status' => 'verified',
            'stock' => 10,
            'price' => 100.00,
        ]);
    }

    /** @test */
    public function an_authenticated_user_can_successfully_purchase_a_product_with_sufficient_stock()
    {
        // Act as the buyer
        $response = $this->actingAs($this->buyer)->post(route('orders.store'), [
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        // Assertions
        $response->assertRedirect(route('orders.index'));
        $response->assertSessionHas('success', 'Order placed successfully.');

        // Check the database for the new order
        $this->assertDatabaseHas('orders', [
            'buyer_id' => $this->buyer->id,
            'total_amount' => 200.00, // 2 * 100.00
        ]);

        // Check the database for the order item
        $this->assertDatabaseHas('order_items', [
            'product_id' => $this->product->id,
            'quantity' => 2,
            'price_at_order' => 100.00,
        ]);

        // Check if the product stock was decremented
        $this->assertDatabaseHas('products', [
            'id' => $this->product->id,
            'stock' => 8, // 10 - 2
        ]);
    }

    /** @test */
    public function an_attempt_to_purchase_a_product_with_insufficient_stock_fails()
    {
        $initialStock = $this->product->stock;

        // Act as the buyer and attempt to buy more than available
        $response = $this->actingAs($this->buyer)->post(route('orders.store'), [
            'product_id' => $this->product->id,
            'quantity' => $initialStock + 1,
        ]);

        // Assertions
        $response->assertRedirect();
        $response->assertSessionHas('error', 'Not enough stock for this product.');

        // Verify no order was created
        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('order_items', 0);

        // Verify product stock did not change
        $this->assertDatabaseHas('products', [
            'id' => $this->product->id,
            'stock' => $initialStock,
        ]);
    }
}
