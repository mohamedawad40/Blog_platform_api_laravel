<?php

namespace App\Http\Controllers;

use App\Http\Requests\postRequest;
use App\Http\Resources\postResource;
use App\Models\Post;
use App\utilities\ApiResponse;
use  App\utilities\apiError;
use Illuminate\Http\Request;

class postController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user','category')->get();
        if(!$posts) return ApiError::sendError('There is no posts' ,404);

        return ApiResponse::sendResponse(200 ,'success', postResource::collection($posts));
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
    public function store(postRequest $request)
    {
        $post = Post::create([
            'title'     =>  $request->title,
            'content'   =>  $request->content,
            'user_id'   =>  $request->user_id,
            'category_id'   =>  $request->category_id,
        ]);

        if(!$post) return ApiError::sendError('invalid post Id',404);

        return ApiResponse::sendResponse(201, 'post created successfully', $post);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::with('user')->get();

        if(!$post) return ApiError::sendError('There is no posts' ,404);

        return ApiResponse::sendResponse(200 ,'post is found', postResource::collection($post));
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
    public function update(postRequest $request, string $id)
    {
        $post = Post::find($id);

        if(!$post) return ApiError::sendError('invalid post Id',404);

        $post->update([
            'title'     =>  $request->title,
            'content'   =>  $request->content,
            'user_id'   =>  $request->user_id,
            'category_id'   =>  $request->category_id
        ]);

        return ApiResponse::sendResponse(201, 'post updated successfully', $post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);

        if(!$post) return ApiError::sendError('invalid post Id',404);

        $post->delete();
        return ApiResponse::sendResponse(200, 'post deleted successfully');
    }
}
