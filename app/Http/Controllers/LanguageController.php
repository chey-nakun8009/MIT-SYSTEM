<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LanguageController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'language' => [
                'required',
                'string',
                Rule::in(array_keys(config('app.available_locales', []))),
            ],
        ]);

        $language = $validated['language'];

        // Store language in session.
        session()->put('locale', $language);

        // Store language permanently for logged-in users.
        if ($request->user()) {
            $request->user()->update([
                'language' => $language,
            ]);
        }

        return redirect()->back();
    }
}
