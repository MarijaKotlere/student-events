<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with(['category', 'user']);

        /*
        |--------------------------------------------------------------------------
        | Search by title
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        /*
        |--------------------------------------------------------------------------
        | Filter by category
        |--------------------------------------------------------------------------
        */

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $events = $query
            ->latest()
            ->get();

        $categories = Category::all();

        return view('events.index', compact('events', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'location' => 'required|string|max:150',
            'max_participants' => 'nullable|integer|min:1',
            'category_id' => 'required|exists:categories,id',
        ]);

        Event::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'event_date' => $validated['event_date'],
            'location' => $validated['location'],
            'max_participants' => $validated['max_participants'],
            'category_id' => $validated['category_id'],
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('events.index')
            ->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        $event->load([
            'category',
            'user',
            'comments.user',
            'ratings',
            'registrations',
        ]);

        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $categories = Category::all();

        return view('events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'location' => 'required|string|max:150',
            'max_participants' => 'nullable|integer|min:1',
            'category_id' => 'required|exists:categories,id',
        ]);

        $event->update($validated);

        return redirect()
            ->route('events.show', $event)
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()
            ->route('events.index')
            ->with('success', 'Event deleted successfully.');
    }
}