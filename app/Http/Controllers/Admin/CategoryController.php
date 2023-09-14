<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = Category::query();


        if(request()->has('name')){
            $q->where('name','LIKE',$request->name.'%');
        }
        $categories = $q->get();
        return response()->json([
            'data'=>$categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->validate([
            'name'=>'required'
        ]);

        Category::create($input);

        return response()->json([
            'message'=>'category created'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);

        return response()->json([
            'data'=>$category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->validate([
            'name'=>'required'
        ]);
        $category = Category::findOrFail($id);

        $category->update($input);

        return response()->json([
            'data'=>$category,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json([
            'message'=>'category deleted'
        ]);
    }
}
