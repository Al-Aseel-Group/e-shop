<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::getActive()->get();

        return response()->json([
            'data'=>$products
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product  = Product::findOrFail($id);
        return response()->json([
            'data'=>$product
        ]);
    }


}
