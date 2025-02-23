@extends('layouts.app')

@section('content')
<div class="container">

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    {{$events->links()}}
    @foreach ($events as $event)
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">{{ $event->title }}</h5>
            <div class="card-subtitle mb-2 text-muted small">
                {{ $event->created_at->diffForHumans() }}
            </div>
            <p class="card-text">{{ $event->address }}</p>
            <p class="card-text">{{ $event->date }}</p>
            <div class="small mt-2 mb-2">
                Posted by <b>{{ $event->user ? $event->user->name : 'Unknown User' }}</b>,
                <b>Category: {{ $event->category->name }}</b>
            </div>
            <a href="{{ url("/events/detail/$event->id")}}" class="btn btn-outline-info card-link">View</a>
            @if(Auth::check() && (Auth::user()->role === 'admin' || $event->user_id === Auth::id()))
            <form action="{{ url("/events/delete/$event->id") }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger card-link"
                    onclick="return confirm('Are you sure to delete this event?')">Delete</button>
            </form>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endsection