<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiDocumentationTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_documentation_page_requires_authentication(): void
    {
        $response = $this->get('/settings/api-documentation');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_api_documentation_page(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/settings/api-documentation');

        $response
            ->assertOk()
            ->assertSee('API documentation')
            ->assertSee('/api/v1/minutes')
            ->assertSee('Authorization: Bearer YOUR_TOKEN');
    }
}
