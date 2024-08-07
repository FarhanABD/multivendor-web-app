<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\DataTables\CategoryDataTable;

class CategoryController extends Controller
{
    
    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.category.index');
    }

    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'icon' => ['required','not_in:empty'],
            'name' => ['required','max:200','unique:categories,name'],
            'status' => ['required']
        ]);

        $category = new Category();
        $category->icon = $request->icon;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status;
        $category->save();

        toastr('created successfully', 'success');
        return redirect()->route('admin.category.index');
    }

  
    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'icon' => ['required','not_in:empty'],
            'name' => ['required','max:200','unique:categories,name,'.$id],
            'status' => ['required']
        ]);

        $category = Category::findorfail($id);
        $category->icon = $request->icon;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status;
        $category->save();

        toastr('updated successfully', 'success');
        return redirect()->route('admin.category.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findorfail($id);
        $category->delete();
        return response(['status'=>'success','message'=> 'Deleted Successfully']);
    }

    public function changeStatus(Request $request)
{
    try {
        $category = Category::findOrFail($request->id);
        $category->status = $request->status == 'true' ? 1 : 0;
        $category->save();

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

    

}