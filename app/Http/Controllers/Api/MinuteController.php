<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Minute;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MinuteController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'source_file_id' => ['required', 'string', 'max:255'],
            'occurred_at' => ['required', 'date'],
            'title' => ['required', 'string', 'max:255'],
            'markdown' => ['required', 'string'],
            'drive_referat_path' => ['nullable', 'string', 'max:255'],
            'drive_audio_path' => ['nullable', 'string', 'max:255'],
        ]);

        $user = $request->user();

        $minute = Minute::query()->updateOrCreate(
            [
                'user_id' => $user->id,
                'source_file_id' => $data['source_file_id'],
            ],
            [
                'occurred_at' => $data['occurred_at'],
                'title' => $data['title'],
                'markdown' => $data['markdown'],
                'drive_referat_path' => $data['drive_referat_path'] ?? null,
                'drive_audio_path' => $data['drive_audio_path'] ?? null,
            ],
        );

        return response()->json([
            'ok' => true,
            'minute' => [
                'id' => $minute->id,
                'source_file_id' => $minute->source_file_id,
            ],
        ], $minute->wasRecentlyCreated ? 201 : 200);
    }
}
