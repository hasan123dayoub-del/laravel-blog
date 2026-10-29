<?php

// namespace App\Http\Controllers;

// use App\Http\Requests\StoreBlogRequest;
// use App\Http\Requests\UpdateBlogRequest;
// use GuzzleHttp\Promise\Create;
// use Illuminate\Http\Request;
// use App\Models\Blog;
// use Illuminate\Support\Facades\Auth;

// class BlogController extends Controller
// {
//     public function index()
//     {
//         $blogs=Blog::all();
//         return response()->json([ 'Blogs: '=>$blogs ] ,200);
//             }
    
//     public function store(StoreBlogRequest $request)
//     {
//         $user_id=Auth::user()->id;
//         $validated=$request->validated();
//         $validated['user_id']=$user_id;
//         if($request->hasFile('image'))
//         {
//             $path=$request->file('image')->store('my photo','public');
//             $validated['image']=$path;
//         }
//         $blog=Blog::create($validated);

//         if ($request->has('categories')) {
//         $blog->categories()->attach($request->categories);
//     }
    
//         return response()->json([
//             'messsage'=>'Blog created successfully',
//             'Blog'=>$blog
//         ],201);
//     }

//     public function update(UpdateBlogRequest $request,$id)
//     {
//     $user_id = Auth::user()->id;
//     $blog = Blog::findOrFail($id);

//     if ($blog->user_id != $user_id) {
//         return response()->json(['message' => 'Unauthorized'], 403);
//     }

//     $validated = $request->validated();
//     $blog->update($validated);

//     if ($request->has('categories')) {
//         $blog->categories()->sync($request->categories);
//     }

//     return response()->json([
//         'message' => 'Blog updated successfully',
//         'profile' => $blog
//     ], 201);
//     }

//     public function show($id)
// {
//     $blog = Blog::findOrFail($id);

//     return response()->json([
//         'Blog' => $blog
//     ], 200);
// }


//     public function destroy($id)
//     {
//         $user_id=Auth::user()->id;
//         $blog=Blog::findOrFail($id);
//         if($blog->user_id != $user_id)
//         {
//             return response()->json(['message'=>'Unauthorized'],403);
//         }
//         $blog->delete();
//         return response()->json([
//             'message'=>'Blog deleted successfully'
//         ],201);
//     }

//     public function trash()
//     {
//         $blogs = Blog::onlyTrashed()->get();

//         return response()->json([
//             'Trash' => $blogs
//         ], 200);
//     }

//     public function restore($id)
//     {
//         $user_id = Auth::id();

//         $blog = Blog::onlyTrashed()->where('id', $id)->firstOrFail();

//         if ($blog->user_id != $user_id) {
//             return response()->json(['message' => 'Unauthorized'], 403);
//         }

//         $blog->restore();

//         return response()->json([
//             'message' => 'Blog restored successfully',
//             'Blog' => $blog
//         ], 200);
//     }

//     public function forceDelete($id)
//     {
//         $user_id = Auth::id();

//         $blog = Blog::onlyTrashed()->where('id', $id)->firstOrFail();

//         if ($blog->user_id != $user_id) {
//             return response()->json(['message' => 'Unauthorized'], 403);
//         }

//         $blog->forceDelete();

//         return response()->json([
//             'message' => 'Blog permanently deleted'
//         ], 200);
//     }
//     public function filterByCategory($category_id)
// {
//     $blogs = Blog::whereHas('categories', function ($query) use ($category_id) {
//         $query->where('categories.id', $category_id);
//     })->get();

//     return response()->json([
//         'Blogs' => $blogs
//     ], 200);
// }

// public function addToFavorite($blog_id)
// {
//     $user = Auth::user();

//     if ($user->favorites()->where('blog_id', $blog_id)->exists()) {
//         return response()->json(['message' => 'Already in favorites'], 400);
//     }

//     $user->favorites()->attach($blog_id);

//     return response()->json(['message' => 'Added to favorites'], 200);
// }

// public function removeFromFavorite($blog_id)
// {
//     $user = Auth::user();

//     $user->favorites()->detach($blog_id);

//     return response()->json(['message' => 'Removed from favorites'], 200);
// }

// }


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller {

    public function index(){
        $blogs = Blog::with('categories')->paginate(10);
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create(){
        $categories = Category::all();
        return view('admin.blogs.create', compact('categories'));
    }

   public function store(Request $r)
{

    $r->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'image' => 'nullable|image|max:2048',
        'categories' => 'nullable|array'
    ]);


    $data = $r->only(['title', 'content']);
    $data['user_id'] = Auth::id(); 

    if ($r->hasFile('image')) {
        $path = $r->file('image')->store('blogs', 'public');
        $data['image'] = basename($path);
    }


    $blog = Blog::create($data);

    
    if ($r->has('categories')) {
        $blog->categories()->sync($r->input('categories'));
    }

    return redirect()->route('admin.blogs.index')->with('success', 'تم إنشاء المقال بنجاح');
}

    public function edit(Blog $blog){
        $categories = Category::all();
        $blog->load('categories');
        return view('admin.blogs.edit', compact('blog','categories'));
    }

    public function update(Request $r, Blog $blog){
        $r->validate([
            'title'=>'sometimes',
            'content'=>'sometimes',
            'image'=>'nullable|image'
        ]);
        $data = $r->only(['title','content']);
        if ($r->hasFile('image')){
        
            if ($blog->image) Storage::disk('public')->delete('blogs/'.$blog->image);
            $path = $r->file('image')->store('blogs','public');
            $data['image'] = basename($path);
        }
        $blog->update($data);
        $blog->categories()->sync($r->input('categories',[]));
        return redirect()->route('admin.blogs.index')->with('success','تم التحديث');
    }

   public function destroy($id)
{
    $blog = Blog::findOrFail($id);
    $user_id = Auth::id();

    
    if ($blog->user_id != $user_id) {
        return redirect()->route('admin.blogs.index')
                         ->with('error', 'لا يمكنك حذف هذا المقال');
    }

    // Soft delete: keep the image and categories so the post comes back complete if it is restored.
    // They are removed in forceDelete().
    $blog->delete();

    return redirect()->route('admin.blogs.index')->with('success', 'تم حذف المقال بنجاح');
}


   public function trash()
{
    $blogs = Blog::onlyTrashed()->paginate(10);
    return view('admin.blogs.trash', compact('blogs'));
}


    public function restore($id){
        $b = Blog::onlyTrashed()->findOrFail($id);
        $b->restore();
        return back()->with('success','تم الاستعادة');
    }

    public function forceDelete($id){
        $b = Blog::onlyTrashed()->findOrFail($id);
        if ($b->image) Storage::disk('public')->delete('blogs/'.$b->image);
        $b->categories()->detach();
        $b->forceDelete();
        return back()->with('success','حذف نهائي');
    }


    public function frontendIndex(){
        $blogs = Blog::with('categories')->latest()->paginate(9);
        $categories = Category::all();
        return view('frontend.index', compact('blogs','categories'));
    }

    public function frontendShow($id){
        $blog = Blog::with('categories')->findOrFail($id);
        return view('frontend.show', compact('blog'));
    }

    public function frontendByCategory($id){
        $category = Category::findOrFail($id);
        $blogs = $category->blogs()->with('categories')->paginate(9);
        $categories = Category::all();
        return view('frontend.index', compact('blogs','categories'));
    }

//     public function toggleFavorite($id)
// {
//     $user = Auth::user();
//     if (!$user) {
//         return response()->json(['status' => 'unauthenticated'], 401);
//     }

//     $blog = Blog::findOrFail($id);

//     if ($user->favorites()->where('blog_id', $id)->exists()) {
//         $user->favorites()->detach($id);
//         $status = 'removed';
//     } else {
//         $user->favorites()->attach($id);
//         $status = 'added';
//     }

//     if (request()->ajax()) {
//         return response()->json(['status' => $status, 'blog_id' => $id]);
//     }

//     return back();
// }

// public function myFavorites()
// {
//     $blogs = Auth::user()->favorites()->paginate(9);
//     return view('frontend.favorite', compact('blogs'));
// }
 public function toggleFavorite($id)
{
    $user = Auth::user();
    $blog = Blog::findOrFail($id);

    if ($user->favorites()->where('blog_id', $id)->exists()) {
        $user->favorites()->detach($id);
        $status = 'removed';
    } else {
        $user->favorites()->attach($id);
        $status = 'added';
    }

    return response()->json([
        'status' => $status,
        'blog_id' => $id
    ]);
}


public function myFavorites()
{
    $blogs = Auth::user()->favorites()->paginate(9);
    return view('frontend.favorite', compact('blogs'));
}



    // إزالة المقال من المفضلة فقط (اختياري)
    public function removeFromFavorites($id)
    {
        $user = auth()->user();
        $blog = Blog::findOrFail($id);

        if ($user->favorites()->where('blog_id', $id)->exists()) {
            $user->favorites()->detach($id);
        }

        return redirect()->route('frontend.favorites')->with('success', 'تمت إزالة المقال من المفضلة');
    }
}

