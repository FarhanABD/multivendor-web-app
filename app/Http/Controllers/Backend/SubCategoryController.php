<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\DataTables\SubCategoryDataTable;
use App\Models\ChildCategory;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SubCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.sub-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.sub-category.create',compact('categories'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request ->validate([
           'category' => ['required'],
           'name' => ['required','max:200','unique:sub_categories,name'],
           'status' => ['required'],
        ]);

        $subCategory = new SubCategory();

        $subCategory->category_id = $request->category;
        $subCategory->name = $request->name;
        $subCategory->slug = Str::slug($request->name);
        $subCategory->status = $request->status;
        $subCategory->save();
        
        toastr('Created Successfully','success');
        return redirect()->route('admin.sub-category.index');
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
        $subCategory = SubCategory::findorfail($id);
        
        return view('admin.sub-category.edit',compact('subCategory','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request ->validate([
            'category' => ['required'],
            'name' => ['required','max:200','unique:sub_categories,name,'.$id],
            'status' => ['required'],
         ]);
 
         $subCategory = SubCategory::findorfail($id);
 
         $subCategory->category_id = $request->category;
         $subCategory->name = $request->name;
         $subCategory->slug = Str::slug($request->name);
         $subCategory->status = $request->status;
         $subCategory->save();
         
         toastr('Updated Successfully','success');
         return redirect()->route('admin.sub-category.index');
    }

    public function changeStatus(Request $request)
    {
    try {
        $subCategory = SubCategory::findOrFail($request->id);
        $subCategory->status = $request->status == 'true' ? 1 : 0;
        $subCategory->save();

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
        $subCategory = SubCategory::findorfail($id);
        $childCategory = ChildCategory::where('sub_category_id',$subCategory->id)->count();
        
        if($childCategory > 0){
            return response(['status'=>'error','message'=> 'This item contain sub item']);
        }
        $subCategory->delete();
        return response(['status'=>'success','message'=> 'Deleted Successfully']);
    }

    
}