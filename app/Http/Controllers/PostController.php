<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
{
    $this->middleware('superadmin')->only('review');
}


public function index()
{
    $posts = Post::all();
    return view('posts.index', compact('posts'));
}

public function create()
{
    return view('posts.create');
}

public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
    ]);

    $post = auth()->user()->posts()->create([
        'title' => $request->input('title'),
        'content' => $request->input('content'),
    ]);

    return redirect()->route('posts.show', $post);
}

public function edit(Post $post)
{
    return view('posts.edit', compact('post'));
}

public function update(Request $request, Post $post)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
    ]);

    $post->update([
        'title' => $request->input('title'),
        'content' => $request->input('content'),
    ]);

    return redirect()->route('posts.show', $post);
}

public function show(Post $post)
{
    return view('posts.show', compact('post'));
}

public function destroy(Post $post)
{
    $post->delete();
    return redirect()->route('posts.index');
}

// Review and Approval
public function review(Post $post)
{
    return view('posts.review', compact('post'));
}

public function approve(Post $post)
{
    $post->update(['approved' => true]);
    return redirect()->route('posts.index');
}
}
