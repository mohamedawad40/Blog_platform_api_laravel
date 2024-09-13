<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\utilities\ApiError;
use App\utilities\ApiResponse;
use Illuminate\Http\Request;

class commentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $postID)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $post = Post::find($postID);
        if(!$post) return ApiError::sendError('invalid post ID' ,404);

        $comment = Comment::create([
            'user_id' => auth()->user()->id,
            'post_id' => $postID,
            'content' => $request->content,
        ]);

        return ApiResponse::sendResponse(200 ,'success', $comment);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
