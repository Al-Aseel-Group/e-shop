<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cartItems = Cart::where('user_id',auth()->id())->get();
        return CartResource::collection($cartItems);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->validate([
            'product_id'=>'required',
            'qty'=>['nullable','numeric']
        ]);

        $item = Cart::where('product_id',$input['product_id'])
        ->where('user_id',auth()->id())->first();

        if(!$item){
            $input['user_id'] = auth()->id();
            Cart::create($input);
            return response()->json([
                'message'=>'item added'
            ]);
        }

        $cartQty = $item->qty;

        if($cartQty > $item->product->qty)
        {
            return response()->json([
                'message'=>'quantity not available'
            ]);
        }
        $item->qty = $cartQty+1;
        $item->save();
        return response()->json([
            'message'=>'quantity updated'
        ]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->validate([
            'qty'=>['required','numeric']
        ]);

        $item = Cart::where('product_id',$id)
        ->where('user_id',auth()->id())->firstOrFail();

        $cartQty = $item->qty + $request->qty;

        // dd($cartQty);
        if($cartQty > $item->product->qty)
        {
            return response()->json([
                'message'=>'quantity not available'
            ]);
        }
        $item->qty = $cartQty;
        $item->save();
        return response()->json([
            'message'=>'quantity updated'
        ]);
    }

    public function remove(Request $request,$id)
    {
        $input = $request->validate([
            'qty'=>['required','numeric']
        ]);

        $item = Cart::where('product_id',$id)
        ->where('user_id',auth()->id())->firstOrFail();

        $cartQty = $item->qty - $request->qty;

        // dd($cartQty);
        if($cartQty <= 1)
        {
            $item->qty = 1;
            $item->save();
            return response()->json([
                'message'=>'the minimum is 1'
            ]);
        }
        $item->qty = $cartQty;
        $item->save();
        return response()->json([
            'message'=>'quantity updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Cart::where('product_id',$id)
        ->where('user_id',auth()->id())->firstOrFail();
        $item->delete();
        return response()->json([
            'message'=>'item deleted'
        ]);

    }
}
