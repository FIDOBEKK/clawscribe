<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class Minute extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'occurred_at',
        'title',
        'markdown',
        'source_file_id',
        'drive_referat_path',
        'drive_audio_path',
    ];

    /**
     * @return BelongsTo<User, Minute>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param  Builder<Minute>  $query
     * @return Builder<Minute>
     */
    public function scopeForUser(Builder $query, User $user): Builder
    {
        return $query->where('user_id', $user->id);
    }

    /**
     * Render markdown to safe HTML.
     */
    public function getRenderedMarkdownAttribute(): HtmlString
    {
        $html = Str::markdown($this->markdown ?? '', [
            // Safety: do not allow raw HTML input in stored markdown.
            'html_input' => 'strip',
            // Safety: avoid javascript: links, etc.
            'allow_unsafe_links' => false,
        ]);

        return new HtmlString($html);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'occurred_at' => 'datetime',
        ];
    }
}
