<?php

namespace App\Http\Controllers;

use App\Models\Minute;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
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

    public function pdf(Request $request, Minute $minute): Response
    {
        abort_unless($minute->user_id === $request->user()->id, 403);

        $fileName = str(Str::ascii($minute->title))
            ->squish()
            ->replaceMatches('/[^A-Za-z0-9\-_ ]+/', '')
            ->replace(' ', '-')
            ->lower()
            ->prepend('minutes-')
            ->append('.pdf')
            ->toString();

        return Pdf::loadView('minutes.pdf', [
            'minute' => $minute,
        ])->download($fileName);
    }
}
