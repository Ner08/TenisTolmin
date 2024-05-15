<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use DateTime;

class EventController extends Controller
{
    // Show all the events
    public function index()
    {
        return view('events.index', [
            'events' => Event::paginate(12),
        ]);
    }

    // Show a single event
    public function show(Event $event)
    {
        $created_at = new DateTime('now');

        return view('events.show', [
            'event' => $event,
        ]);
    }

    public function store(EventRequest $request)
    {
        // Create event
        Event::create($request->validated());

        return back()->with(['message' => 'Dogodek uspešno ustvarjen.']);
    }

    public function edit(Event $event, EventRequest $request)
    {
        // Create event
        $event->update($request->validated());

        return redirect()->route('admin')->with(['message' => 'Dogodek uspešno ustvarjen.']);
    }

    public function destroy(Event $event)
    {
        //Delete event
        $event->delete();

        return back()->with(['message' => 'Dogodek uspešno zbrisan.']);
    }
}
