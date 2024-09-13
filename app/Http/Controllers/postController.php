<?php

namespace App\Http\Controllers;

use App\Http\Requests\postRequest;
use App\Http\Resources\postResource;
use App\Models\Category;
use App\Models\Post;
use App\utilities\ApiResponse;
use  App\utilities\apiError;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class postController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $category = $request->query('category');
        $author = $request->query('author');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = Post::query();

        if($category){
            $query->whereHas('category',function($q)use ($category){
                $q->where('name',$category);
            });
        }

        if($author){
            $query->whereHas('user',function($q)use ($author){
                $q->where('name',$author);
            });
        }

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $posts = $query->with('user', 'category')->paginate(10);

        // $posts = Post::with('user','category')->paginate(3);
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
        $this->authorize('create', Post::class);
        $post = Post::create([
            'title'     =>  $request->title,
            'content'   =>  $request->content,
            'user_id'   =>  auth()->id(),
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
        $post = Post::with('user', 'category')->findOrFail($id);

        if(!$post) return ApiError::sendError('There is no posts' ,404);

        $this->authorize('view', $post);

        return ApiResponse::sendResponse(200 ,'post is found', new postResource($post));
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
        $this->authorize('update', $post);

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
        $this->authorize('delete', $post);

        if(!$post) return ApiError::sendError('invalid post Id',404);

        $post->delete();
        return ApiResponse::sendResponse(200, 'post deleted successfully');
    }
}
