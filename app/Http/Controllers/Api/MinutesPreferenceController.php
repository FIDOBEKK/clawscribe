<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MinutesPreference;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MinutesPreferenceController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $preference = MinutesPreference::query()->firstOrCreate([
            'user_id' => $request->user()->id,
        ]);

        $template = $preference->getFirstMedia('template');
        $examples = $preference->getMedia('examples');

        return response()->json([
            'ok' => true,
            'preferences' => [
                'instructions' => $preference->instructions,
                'template' => [
                    'filename' => $preference->template_filename,
                    'mime_type' => $preference->template_mime_type,
                    'extracted_text' => $preference->template_extracted_text,
                ],
                'examples' => $examples->map(fn ($m) => [
                    'id' => $m->id,
                    'filename' => $m->file_name,
                    'mime_type' => $m->mime_type,
                    'extracted_text' => $m->getCustomProperty('extracted_text'),
                ])->values(),
            ],
        ]);
    }
}
