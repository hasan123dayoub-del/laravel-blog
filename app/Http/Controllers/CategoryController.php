<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function getAllCategoties()
    {
       // $categories=Category::all();
       $categories=Auth::user()->categories;
        return response()->json(['Categories: '=>$categories],200);
    }

    public function store(StoreCategoryRequest $reqeust)
    {
        $user_id=Auth::user()->id;
        $validated=$reqeust->validated();
        $validated['user_id']=$user_id;
        $category=Category::create($validated);
        return response()->json(
            [
                'message'=>'Category created successfuly',
                'Category'=>$category
            ],201);
    }

    public function update(UpdateCategoryRequest $reqeust,$id)
    {
        $user_id=Auth::user()->id;
        $category=Category::findOrFail($id);
        if($category->user_id != $user_id)
        {
            return response()->json(['message'=>'Unauthorized'],403);
        }
        $validated=$reqeust->validated();
        $category->update($validated);

        return response()->json([
            'message'=>'Category updated successfully',
            'Category'=>$category
        ],201);
    }

    public function destroy($id)
    {
        $user_id=Auth::user()->id;
        $category=Category::findOrFail($id);
        if($category->user_id != $user_id)
        {
            return response()->json(['message'=>'Unauthorized'],403);
        }
        $category->delete();
        return response()->json(
            [
                'message'=>'Category deleted successfully'
            ],201);
    }
}