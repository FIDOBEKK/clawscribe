<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class MinutesPreference extends Model implements HasMedia
{
    use InteractsWithMedia;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'instructions',
        'template_extracted_text',
        'template_filename',
        'template_mime_type',
    ];

    /**
     * @return BelongsTo<User, MinutesPreference>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('template')
            ->singleFile();

        $this->addMediaCollection('examples');
    }
}
