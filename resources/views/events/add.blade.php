@extends('layouts.app')

@section('content')

@auth
<div class="container">
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="post">
        @csrf
        <div class="mb-3">
            <label for="">Title</label>
            <input type="text" name="title" class="form-control">
        </div>
        <div class="mb-3">
            <label for="">Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="">Address</label>
            <input type="text" name="address" class="form-control">
        </div>
        <div class="mb-3">
            <label for="">Date</label>
            <input type="date" name="date" class="form-control">
        </div>
        <div class="mb-3">
            <label for="">Category</label>
            <select name="category_id" class="form-select">
                @foreach($categories as $category)
                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                @endforeach

            </select>
        </div>
        <input type="submit" value="Add Event" class="btn btn-info">
    </form>

</div>
@endauth

@endsection