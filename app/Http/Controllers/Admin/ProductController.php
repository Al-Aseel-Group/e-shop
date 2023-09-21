<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($category)
    {
        $products = Product::where('category_id',$category)->get()->load('category');
        return response()->json([
            'data'=>$products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $input = $request->validated();

        // $image = $request->file('image_url')->store('public');
        // $image = explode('/',$image)[1];

        // $input['image_url']=$image;
        $input['image_url']=//adfjlskdfjl;aksjdflkasdf.png;

        Product::create($input);

        return response()->json([
            'message'=>'product added'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);

        return response()->json([
            'data' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $input = $request->validated();

        $product = Product::findOrFail($id);

        $product->update($input);
        return response()->json([
            'data'=>$product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::findOrFail($id)->delete();
        return response()->json([
            'message'=>'deleted'
        ]);
    }
}
