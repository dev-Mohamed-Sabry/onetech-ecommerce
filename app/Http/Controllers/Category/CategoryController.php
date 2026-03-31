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
            $categories = Category::select('id', 'name', 'order');
            return DataTables::of($categories)
                ->addColumn('action', function ($category) {
                    return
                        '
                    <div class="text-center">
                        <button  class="btn btn-info edit-category " style="cursor:pointer;" data-id="' . $category->id . '" data-name="' . $category->name . '">Update</button>
                        <button  class="btn btn-danger delete-category " style="cursor:pointer;" data-id="' . $category->id . '">Delete</button>
                    </div>
                ';
                })
                ->rawColumns(['action'])
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
        ]);

        Category::create([
            'name' => $request->name,
            'order' => $request->order,
        ]);

        return response()->json(['data' => true]);
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
    public function edit(Category $category) {}

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255|unique:categories,name,' . $id,
        ]);

        if ($validator->fails()) {
            // لو الفالديشن فشل، رجع JSON فيه كل الرسائل
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $category = Category::findOrFail($id);
        $category->update(['name' => $request->name]);

        return response()->json([
            'status' => 'success',
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