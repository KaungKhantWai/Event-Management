<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function create()
    {
        $comment = new Comment();
        $comment->content = request('content');
        $comment->event_id = request('event_id');
        $comment->user_id = auth()->user()->id;
        $comment->save();
        return redirect()->back();
    }

    public function delete($id)
    {
        $comment = Comment::find($id);
        if (auth()->user()->role === 'admin' || $comment->user_id === auth()->id()) {
            $comment->delete();
            return back()->with('success', 'Comment deleted successfully');
        }
        return back()->with('error', 'Unauthorized action');
    }

    public function __construct()
    {
        $this->middleware('auth');
    }
}
