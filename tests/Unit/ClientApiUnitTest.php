<?php

namespace Tests\Unit;

use App\Client;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientApiUnitTest extends TestCase
{
    public function test_get_all_clients()
    {
        $response = $this->get('/api/clients');

        $response->assertStatus(200);
    }

    public function test_get_single_client()
    {
        $response = $this->get('/api/clients/1');
        $response->assertStatus(200);

        $response = $this->get('/api/clients/9999999');
        $response->assertStatus(404);
    }

    public function test_create_remove_new_client()
    {
        $data = [
            'first_name' => 'Test',
            'last_name' => 'Test',
            'email' => 'test_create_remove_client@gmail.com',
            'password' => 'secret1234',
        ];

        $response = $this->json('POST', url('api/clients'), $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('clients', [
            'email' => 'test_create_remove_client@gmail.com'
        ]);

        $client_id = Client::where('email', 'test_create_remove_client@gmail.com')->first()->id;

        $response = $this->json('DELETE', url('api/clients/' . $client_id));

        $response->assertStatus(204);
        $this->assertDatabaseMissing('clients', [
            'email' => 'test_create_remove_client@gmail.com'
        ]);
    }
}
