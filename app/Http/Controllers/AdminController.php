<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }

    public function ban(User $user)
    {
        $user->update(['banned' => true]);
        return redirect()->route('admin.dashboard')->with('success', 'User banned successfully');
    }

    public function unban(User $user)
    {
        $user->update(['banned' => false]);
        return redirect()->route('admin.dashboard')->with('success', 'User unbanned successfully');
    }

    public function delete(User $user)
    {
        $user->delete();
        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully');
    }
}
