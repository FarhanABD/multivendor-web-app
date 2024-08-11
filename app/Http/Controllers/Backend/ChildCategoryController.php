<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ChildCategory;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\DataTables\ChildCategoryDataTable;

class ChildCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ChildCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.child-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.child-category.create',compact('categories'));
    }

    public function getSubCategories(Request $request){
        $subcategories = SubCategory::where('category_id', $request->id)->where('status',1)->get();
        return $subcategories;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
          'category'=> ['required'],
          'sub_category' => ['required'],
          'name' => ['required','max:200','unique:child_categories,name'],
          'status' => ['required'],
        ]);

        $childCategory = new ChildCategory();
        $childCategory->category_id = $request->category;
        $childCategory->sub_category_id = $request->sub_category;
        $childCategory->name = $request->name;
        $childCategory->slug = Str::slug($request->name);
        $childCategory->status = $request->status;
        $childCategory->save();

        toastr('created successfully', 'success');
        return redirect()->route('admin.child-category.index');
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
        $categories = Category::all();
        $subCategories = SubCategory::all();
        $childCategory = ChildCategory::findorfail($id);
        
        return view('admin.child-category.edit',compact('childCategory','categories','subCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function changeStatus(Request $request)
    {
    try {
        $childCategory = ChildCategory::findOrFail($request->id);
        $childCategory->status = $request->status == 'true' ? 1 : 0;
        $childCategory->save();

        return response(['message' => 'Status  Updated Successfully']);
        
    } catch (\Illuminate\Database\QueryException $e) {
        // Handle database-related errors
        Log::error('Database error: ' . $e->getMessage());
        return response(['message' => 'An error occurred while accessing the database'], 500);
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Handle validation errors
        return response(['message' => 'Validation error: ' . $e->getMessage()], 422);
    } catch (\Exception $e) {
        // Handle other exceptions
        Log::error('General error: ' . $e->getMessage());
        return response(['message' => 'An unexpected error occurred'], 500);
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $childCategory = ChildCategory::findorfail($id);
        $childCategory->delete();
        return response(['status'=>'success','message'=> 'Deleted Successfully']);
    }

   

}