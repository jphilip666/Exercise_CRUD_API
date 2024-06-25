<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * API Feature test using PHP Unit
 */
class APITest extends TestCase
{
    /**
     * Test: Create a new token.
     */
    public function test_sanctum_token(): string
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->postJson('/api/create-token', ['email' => 'jestin.philip@icloud.com', 'password' => 'letmein']);

        $data = $response->decodeResponseJson();

        $response->assertStatus(200);

        return $data['token'];
    }

    /**
     * A basic feature test example.
     *
     * @depends test_sanctum_token
     */
    public function test_api_get_all_suppliers_and_rates(string $token): void
    {
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}",
            'Accept' => 'application/json',
        ])->getJson('/api/v1/suppliers');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @depends test_sanctum_token
     */
    public function test_api_get_all_overlapping_suppliers_and_rates($token): void
    {
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}",
            'Accept' => 'application/json',
        ])->getJson('/api/v1/overlapping-suppliers');

        $response->assertStatus(200);
    }
}
