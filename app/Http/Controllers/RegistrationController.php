<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;

class RegistrationController extends Controller
{
    public function store(Event $event)
    {
        $alreadyRegistered = Registration::where('user_id', auth()->id())
            ->where('event_id', $event->id)
            ->exists();

        if ($alreadyRegistered) {
            return redirect()
                ->route('events.show', $event)
                ->with('success', 'You are already registered for this event.');
        }

        if ($event->max_participants !== null && $event->registrations()->count() >= $event->max_participants) {
            return redirect()
                ->route('events.show', $event)
                ->with('success', 'This event is already full.');
        }

        Registration::create([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
            'registered_at' => now(),
        ]);

        return redirect()
            ->route('events.show', $event)
            ->with('success', 'You registered for this event successfully.');
    }
}