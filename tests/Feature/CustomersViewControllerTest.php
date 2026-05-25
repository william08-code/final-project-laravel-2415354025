<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomersViewControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_store_redirects_and_persists_customer_without_internal_http_call(): void
    {
        $response = $this->post('/customers', [
            'customer_id' => 'cust-001',
            'name' => 'Customer One',
            'email' => 'customer.one@example.com',
            'phone' => '081234567890',
            'address' => 'Street 1',
            'status' => 'active',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('toast_success', 'Customer created successfully');
        $this->assertDatabaseHas('customers', [
            'customer_id' => 'cust-001',
            'name' => 'Customer One',
            'email' => 'customer.one@example.com',
        ]);
    }
}
