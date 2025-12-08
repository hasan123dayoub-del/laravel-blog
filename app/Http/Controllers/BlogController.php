<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function getAllBlogs()
    {
        $blogs=Blog::all();
        return response()->json([ 'Blogs: '=>$blogs ] ,200);
            }
    
    public function store(StoreBlogRequest $request)
    {
        $user_id=Auth::user()->id;
        $validated=$request->validated();
        $validated['user_id']=$user_id;
        if($request->hasFile('image'))
        {
            $path=$request->file('image')->store('my photo','public');
            $validated['image']=$path;
        }
        $blog=Blog::create($validated);

        if ($request->has('categories')) {
        $blog->categories()->attach($request->categories);
    }
    
        return response()->json([
            'messsage'=>'Blog created successfully',
            'Blog'=>$blog
        ],201);
    }

    public function update(UpdateBlogRequest $request,$id)
    {
    $user_id = Auth::user()->id;
    $blog = Blog::findOrFail($id);

    if ($blog->user_id != $user_id) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    $validated = $request->validated();
    $blog->update($validated);

    if ($request->has('categories')) {
        $blog->categories()->sync($request->categories);
    }

    return response()->json([
        'message' => 'Blog updated successfully',
        'profile' => $blog
    ], 201);
    }

    public function show($id)
{
    $blog = Blog::findOrFail($id);

    return response()->json([
        'Blog' => $blog
    ], 200);
}


    public function destroy($id)
    {
        $user_id=Auth::user()->id;
        $blog=Blog::findOrFail($id);
        if($blog->user_id != $user_id)
        {
            return response()->json(['message'=>'Unauthorized'],403);
        }
        $blog->delete();
        return response()->json([
            'message'=>'Blog deleted successfully'
        ],201);
    }
    
    public function trash()
    {
        $blogs = Blog::onlyTrashed()->get();

        return response()->json([
            'Trash' => $blogs
        ], 200);
    }

    public function restore($id)
    {
        $user_id = Auth::id();

        $blog = Blog::onlyTrashed()->where('id', $id)->firstOrFail();

        if ($blog->user_id != $user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $blog->restore();

        return response()->json([
            'message' => 'Blog restored successfully',
            'Blog' => $blog
        ], 200);
    }

    public function forceDelete($id)
    {
        $user_id = Auth::id();

        $blog = Blog::onlyTrashed()->where('id', $id)->firstOrFail();

        if ($blog->user_id != $user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $blog->forceDelete();

        return response()->json([
            'message' => 'Blog permanently deleted'
        ], 200);
    }
    public function filterByCategory($category_id)
{
    $blogs = Blog::whereHas('categories', function ($query) use ($category_id) {
        $query->where('categories.id', $category_id);
    })->get();

    return response()->json([
        'Blogs' => $blogs
    ], 200);
}

public function addToFavorite($blog_id)
{
    $user = Auth::user();

    if ($user->favorites()->where('blog_id', $blog_id)->exists()) {
        return response()->json(['message' => 'Already in favorites'], 400);
    }

    $user->favorites()->attach($blog_id);

    return response()->json(['message' => 'Added to favorites'], 200);
}

public function removeFromFavorite($blog_id)
{
    $user = Auth::user();

    $user->favorites()->detach($blog_id);

    return response()->json(['message' => 'Removed from favorites'], 200);
}

}

