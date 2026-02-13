<?php

namespace Tests\Feature;

use App\Models\Minute;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MinutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_shows_a_users_minute_content(): void
    {
        $user = User::factory()->create();

        $minute = Minute::query()->create([
            'user_id' => $user->id,
            'occurred_at' => now(),
            'title' => 'Test Minute',
            'markdown' => "# Hello\n\nWorld",
            'source_file_id' => 'source-1',
        ]);

        $this->actingAs($user)
            ->get(route('minutes.show', $minute))
            ->assertOk()
            ->assertSee('Test Minute')
            ->assertSee('# Hello');
    }

    public function test_it_forbids_accessing_another_users_minute(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $minute = Minute::query()->create([
            'user_id' => $userA->id,
            'occurred_at' => now(),
            'title' => 'Secret',
            'markdown' => 'Top secret',
            'source_file_id' => 'source-2',
        ]);

        $this->actingAs($userB)
            ->get(route('minutes.show', $minute))
            ->assertForbidden();
    }
}
