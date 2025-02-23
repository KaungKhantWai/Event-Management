@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <form action="{{ route('admin.ban', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-warning opacity-50">Ban</button>
                    </form>
                    @if($user->banned)
                    <form action="{{ route('admin.users.unban', $user) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-success">Unban</button>
                    </form>
                    @endif
                    <form action="{{ route('admin.delete', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection