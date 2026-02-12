<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApiTokenController extends Controller
{
    public function index(Request $request): View
    {
        $tokens = $request->user()->tokens()->latest()->get();

        return view('settings.api-tokens', [
            'tokens' => $tokens,
            'plainTextToken' => session('plainTextToken'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $plainTextToken = $request->user()->createToken($data['name'])->plainTextToken;

        return back()->with('plainTextToken', $plainTextToken);
    }

    public function destroy(Request $request, string $tokenId): RedirectResponse
    {
        $request->user()->tokens()->whereKey($tokenId)->delete();

        return back();
    }
}
