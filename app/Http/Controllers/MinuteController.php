<?php

namespace App\Http\Controllers;

use App\Models\Minute;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MinuteController extends Controller
{
    public function index(Request $request): View
    {
        $minutes = Minute::query()
            ->forUser($request->user())
            ->orderByDesc('occurred_at')
            ->paginate(50);

        return view('minutes.index', [
            'minutes' => $minutes,
        ]);
    }

    public function show(Request $request, Minute $minute): View
    {
        abort_unless($minute->user_id === $request->user()->id, 403);

        return view('minutes.show', [
            'minute' => $minute,
        ]);
    }
}
