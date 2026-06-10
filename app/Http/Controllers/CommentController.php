<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'content' => $validated['content'],
            'user_id' => auth()->id(),
            'event_id' => $event->id,
        ]);

        return redirect()
            ->route('events.show', $event)
            ->with('success', 'Comment added successfully.');
    }
}