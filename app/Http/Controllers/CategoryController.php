<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public $edit = false;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.list', ['categories' => $categories]);
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
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:20|unique:categories,category_name',
        ]);

        $category = new Category();
        $category->category_name = $request->category_name;
        $category->user_id = Auth::user()->id;
        $category->save();

        return redirect()->route('category.index')->with('success', 'category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $category_name)
    {  
        $category = Category::where('category_name',$category_name)->first();

        $categories = Category::all();

        if($category) {
            $posts = Post::where('category_id', $category->id)->paginate(12);
            return view('blogs.home', ['posts' => $posts, 'categories' => $categories]);
        } else {
            abort(403, 'category does not exist');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->edit = true;
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(),[
            'category_name' => [
                'required','string','max:20',
                Rule::unique('categories')->ignore($category->id),
            ],
        ]);
        
        if($validator->fails()) {
            return redirect('manage/categories')
            ->withErrors($validator)
            ->with("edit_id", $category->id);
        }

        $validated = $validator->validated();

        $category->category_name = $validated['category_name'];
        $category->user_id = Auth::user()->id;
        $category->save();

        return redirect()->route('category.index')->with('success', 'category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('category.index')->with('success', 'category deleted successfully.');
    }
}
