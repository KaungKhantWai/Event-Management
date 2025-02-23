@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <div class="card mb-2">
        <div class="card-body">

            <h5 class="card-title">{{ $event->title }}</h5>

            <div class="card-subtitle mb-2 text-muted">
                Category: <b> {{ $event->category->name }} </b>
            </div>
            <p class="card-text">{{ $event->description }}</p>
            <p class="card-text">{{ $event->address }}</p>
            <p class="card-text">{{ $event->date }}</p>
            @if($event->category)
            <p class="card-text">{{ $event->category->name }}</p>
            @endif

            <div class="small mt-2">
                By {{ $event->user ? $event->user->name : 'Unknown User' }},
                {{ $event->created_at->diffForHumans() }}
            </div>

            @auth
                @if(Gate::allows('delete-event', $event))
                    <form action="{{ url("/events/delete/$event->id") }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                    <form action="{{ url("/events/edit/$event->id") }}" method="GET" style="display:inline;">
                        <button type="submit" class="btn btn-sm btn-outline-primary">Edit</button>
                    </form>
                @endif
            @endauth
        </div>


    </div>


    <ul class="list-group">
        <li class="list-group-item active">
            <span class="badge bg-info">Comments ({{ $event->comments->count() }})</span>
        </li>
        @foreach($event->comments as $comment)
        <div class="card mb-2">
            <div class="card-body">
                <p>{{ $comment->content }}</p>
                <small>By {{ $comment->user ? $comment->user->name : 'Unknown User' }} - {{ $comment->created_at->diffForHumans() }}</small>

                @if(Auth::check() && (Auth::user()->role === 'admin' || $comment->user_id === Auth::id()))
                <form action="{{ url("/comments/delete/$comment->id") }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger"
                        onclick="return confirm('Delete this comment?')">Delete</button>
                </form>
                @endif
            </div>
        </div>
        @endforeach

    </ul>

    @auth
    <form action="{{ url("/comments/add") }}" method="post">
        @csrf
        <input type="hidden" name="event_id" value="{{ $event->id }}">
        <textarea name="content" class="form-control mb-2" placeholder="Add a comment"></textarea>
        <button type="submit" class="btn btn-primary">Add Comment</button>
    </form>
    @endauth
</div>
@endsection