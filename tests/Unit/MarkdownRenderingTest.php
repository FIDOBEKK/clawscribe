<?php

namespace Tests\Unit;

use App\Models\Minute;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarkdownRenderingTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_renders_headings_and_tables(): void
    {
        $user = User::factory()->create();

        $markdown = <<<'MD'
# Heading 1

## Heading 2

| Col A | Col B |
| ---- | ---- |
| A1 | B1 |
MD;

        $minute = Minute::query()->create([
            'user_id' => $user->id,
            'occurred_at' => now(),
            'title' => 'Test',
            'markdown' => $markdown,
            'source_file_id' => 'md-test-1',
        ]);

        $html = (string) $minute->rendered_markdown;

        $this->assertStringContainsString('<h1', $html);
        $this->assertStringContainsString('Heading 1', $html);
        $this->assertStringContainsString('<table', $html);
        $this->assertStringContainsString('Col A', $html);
    }
}
