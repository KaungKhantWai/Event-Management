<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        $data = Event::latest()->paginate(5);
        // if (auth()->check() && auth()->user()->role === 'admin') {
        //     $data = Event::latest()->paginate(5); // Admin sees all events
        // } else {
        //     $data = Event::where('user_id', auth()->id())->latest()->paginate(5);
        // }
        return view('events.index', ['events' => $data]);
    }

    public function detail($id)
    {
        $event = Event::find($id);
        return view('events.detail', [
            'event' => $event,
            'comments' => $event->comments
        ]);
        // // Allow access if user is admin OR if it's their own event
        // if (auth()->user()->role === 'admin' || $event->user_id === auth()->id()) {
        //     return view('events.detail', [
        //         'event' => $event,
        //         'comments' => $event->comments
        //     ]);
        // }

        // return redirect('/events')->with('error', 'Unauthorized access');
    }

    public function add()
    {
        $data = [
            ["id" => 1, "name" => "Music"],
            ["id" => 2, "name" => "Sports"],
            ["id" => 3, "name" => "Art"],
            ["id" => 4, "name" => "Food"],
            ["id" => 5, "name" => "Festival"],
            ["id" => 6, "name" => "Other"],
        ];
        return view('events.add', ['categories' => $data]);
    }

    public function create()
    {
        $validator = Validator(request()->all(), [
            'title' => 'required',
            'description' => 'required',
            'address' => 'required',
            'date' => 'required',
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $event = new Event;
        $event->title = request('title');
        $event->description = request('description');
        $event->address = request('address');
        $event->date = request('date');
        $event->category_id = request('category_id');
        $event->user_id = auth()->user()->id;
        $event->save();

        return redirect('/events');
    }

    public function delete($id)
    {
        $event = Event::find($id);
        if (auth()->user()->role === 'admin' || $event->user_id === auth()->id()) {
            $event->delete();
            return redirect('/events')->with('success', 'Event deleted successfully');
        }
        return redirect('/events')->with('error', 'Unauthorized action');
    }

    public function edit($id)
    {
        $event = Event::find($id);
        $categories = Category::all();
        return view('events.edit', ['event' => $event, 'categories' => $categories]);
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required',
        'description' => 'required',
        'address' => 'required',
        'date' => 'required',
        'category_id' => 'required',
    ]);

    $event = Event::findOrFail($id);
    $event->update($request->only(['title', 'description', 'address', 'date', 'category_id']));

    return redirect('/events/detail/' . $event->id)->with('success', 'Event updated successfully!');
}

    public function __construct()
    {
        $this->middleware('auth')->except('index', 'detail');
    }
}
