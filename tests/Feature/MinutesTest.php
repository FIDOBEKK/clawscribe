<?php

namespace Tests\Feature;

use App\Models\Minute;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
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
            ->assertSee('# Hello')
            ->assertSee('Export PDF');
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

    public function test_it_allows_exporting_minutes_as_pdf_for_owner(): void
    {
        $user = User::factory()->create();

        $minute = Minute::query()->create([
            'user_id' => $user->id,
            'occurred_at' => now(),
            'title' => 'Gadder investormøte',
            'markdown' => "# Beslutninger\n\n- Punkt A",
            'source_file_id' => 'source-3',
        ]);

        $response = $this->actingAs($user)
            ->get(route('minutes.pdf', $minute));

        $response->assertOk();

        $contentType = (string) $response->headers->get('content-type');
        $this->assertStringContainsString('application/pdf', $contentType);

        $contentDisposition = (string) $response->headers->get('content-disposition');

        $this->assertStringContainsString('attachment;', $contentDisposition);
        $this->assertStringContainsString('minutes-gadder-investormote.pdf', Str::ascii($contentDisposition));
    }

    public function test_it_forbids_exporting_another_users_minute_as_pdf(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $minute = Minute::query()->create([
            'user_id' => $owner->id,
            'occurred_at' => now(),
            'title' => 'Secret PDF',
            'markdown' => 'Top secret',
            'source_file_id' => 'source-4',
        ]);

        $this->actingAs($otherUser)
            ->get(route('minutes.pdf', $minute))
            ->assertForbidden();
    }
}
