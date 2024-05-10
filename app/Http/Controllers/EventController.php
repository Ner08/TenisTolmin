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
            'login' => false,
            'admin' => true
        ]);
    }

    // Show a single event
    public function show(Event $event)
    {
        $created_at = new DateTime('now');

        return view('events.show', [
            'comments' => [['username' => 'John Doe', 'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet natus debitis autem temporibus qui. Cupiditate nam, dignissimos nesciunt exercitationem et accusamus libero, natus sequi blanditiis at nobis, eos nemo saepe magnam? Nobis quod tenetur fugiat? Vitae consequuntur optio placeat, consequatur exercitationem sint, eveniet minus tenetur ut ipsum quaerat blanditiis? Reiciendis, unde quasi. Alias rem, quo, repellat delectus vel at consectetur inventore incidunt ipsum fuga autem unde mollitia pariatur ipsam ducimus est ut suscipit consequuntur, reiciendis quos nesciunt soluta sequi perspiciatis quaerat. Ex sit laboriosam quos, aperiam ipsam non, iste illo ratione sequi, quo eaque corporis doloremque? Dolorum iusto, possimus aliquid accusamus asperiores consectetur voluptatem repellat illo rem doloribus dignissimos sequi eum, numquam recusandae eaque ullam deserunt autem. Inventore debitis molestias neque tenetur, reprehenderit amet asperiores aperiam illum eaque architecto quam quaerat minima aut sit minus quis autem ratione vitae cum alias eius. Incidunt provident, doloribus maiores quod in maxime ea nulla mollitia qui amet harum quos aperiam dolores, distinctio laudantium explicabo id ullam laboriosam. Placeat eveniet dolorum totam suscipit earum numquam temporibus ipsam atque tenetur! Nesciunt expedita hic eius aspernatur in omnis doloribus facere ipsum ducimus error facilis rerum repudiandae et minus itaque, iure vero commodi. Magnam quia quae doloribus.', 'created_at' => $created_at]],
            'event' => $event,
            'login' => false,
            'admin' => true
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
