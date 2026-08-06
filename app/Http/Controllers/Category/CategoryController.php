<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\Environment\Console;
use Yajra\DataTables\DataTables;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::select('id', 'name', 'image', 'order')->orderBy('order', 'asc');
            return DataTables::of($categories)
                ->editColumn('image', function ($category) {
                    if (!$category->image) return '<div class="text-center"><img src="/uploads/categories/no_img.jpg"  width="70" height="70"></div>';
                    return '<div class="text-center"><img src="uploads/categories/' . $category->image . '"  width="70" height="70"></div>';
                })
                ->addColumn('action', function ($category) {
                    return
                        ' <div class="text-center">
                           <a href="' . route('categories.edit', $category->id) . '"
                                class="btn btn-info"
                                style="cursor:pointer;">
                                Edit
                            </a>

                            <button  class="btn btn-danger delete-category " style="cursor:pointer;" 
                            data-id="' . $category->id . '">
                            Delete
                            </button>
                            
                        </div> ';
                })

                ->rawColumns(['image', 'action'])
                ->make(true);
        }
        return view('Dashboard.Categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories'],
            'order' => ['required', 'string', 'max:64', 'unique:categories'],
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);



        // ========================
        // 🔹 Store Image
        // ========================
        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('uploads/categories'), $imageName);
        }

        Category::create([
            'name' => $request->name,
            'order' => $request->order,
            'image' => $imageName,
        ]);
        return response()->json([
            'data' => true,
            'message' => 'Category added successfully'
        ]);
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
    public function edit(Category $category)
    {

        return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Category $category)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255|unique:categories,name,' . $category->id,
            'order' => 'required|integer|min:0|unique:categories,order,' . $category->id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        ]);

        if ($validator->fails()) {
            // لو الفالديشن فشل، رجع JSON فيه كل الرسائل
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $imageName = $category->image;

        if ($request->hasFile('image')) {

            if (
                $category->image &&
                $category->image !== 'no_img.jpg' &&
                file_exists(public_path('uploads/categories/' . $category->image))
            ) {
                unlink(public_path('uploads/categories/' . $category->image));
            }

            $image = $request->file('image');

            $imageName =
                uniqid('cat_') .
                '.' .
                $image->extension();

            $image->move(
                public_path('uploads/categories'),
                $imageName
            );
        }

        $category->update([
            'name' => $request->name,
            'order' => $request->order,
            'image' => $imageName,
        ]);

        return response()->json([
            'data' => true,
            'message' => 'Category updated successfully'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Category Deleted successfully'
        ]);
    }
}
