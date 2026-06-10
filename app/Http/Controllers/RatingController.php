<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'score' => 'required|integer|min:1|max:5',
        ]);

        Rating::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'event_id' => $event->id,
            ],
            [
                'score' => $validated['score'],
            ]
        );

        return redirect()
            ->route('events.show', $event)
            ->with('success', 'Rating saved successfully.');
    }
}