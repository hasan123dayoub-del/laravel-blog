<?php

// namespace App\Http\Controllers;

// use App\Http\Requests\StoreCategoryRequest;
// use App\Http\Requests\UpdateCategoryRequest;
// use App\Models\Category;
// use GuzzleHttp\Promise\Create;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// class CategoryController extends Controller
// {
//     public function index()
//     {
//        $categories=Auth::user()->categories;
//         return response()->json(['Categories: '=>$categories],200);
//     }

//     public function store(StoreCategoryRequest $reqeust)
//     {
//         $user_id=Auth::user()->id;
//         $validated=$reqeust->validated();
//         $validated['user_id']=$user_id;
//         $category=Category::create($validated);
//         return response()->json(
//             [
//                 'message'=>'Category created successfuly',
//                 'Category'=>$category
//             ],201);
//     }

//     public function update(UpdateCategoryRequest $reqeust,$id)
//     {
//         $user_id=Auth::user()->id;
//         $category=Category::findOrFail($id);
//         if($category->user_id != $user_id)
//         {
//             return response()->json(['message'=>'Unauthorized'],403);
//         }
//         $validated=$reqeust->validated();
//         $category->update($validated);

//         return response()->json([
//             'message'=>'Category updated successfully',
//             'Category'=>$category
//         ],201);
//     }

//     public function destroy($id)
//     {
//         $user_id=Auth::user()->id;
//         $category=Category::findOrFail($id);
//         if($category->user_id != $user_id)
//         {
//             return response()->json(['message'=>'Unauthorized'],403);
//         }
//         $category->delete();
//         return response()->json(
//             [
//                 'message'=>'Category deleted successfully'
//             ],201);
//     }
// }


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller {
    public function index(){
        $categories = Category::paginate(20);
        return view('admin.categories.index', compact('categories'));
    }
    public function create(){ return view('admin.categories.create'); }
    public function store(Request $r){
        $r->validate(['name'=>'sometimes|unique:categories,name']);
        Category::create($r->only('name'));
        return redirect()->route('admin.categories.index')->with('success','تم الإنشاء');
    }
    public function edit(Category $category){ return view('admin.categories.edit', compact('category')); }
    public function update(Request $r, Category $category){
        $r->validate(['name'=>'required|unique:categories,name,'.$category->id]);
        $category->update($r->only('name'));
        return redirect()->route('admin.categories.index')->with('success','تم التحديث');
    }
    public function destroy(Category $category){
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success','تم الحذف');
    }
}
