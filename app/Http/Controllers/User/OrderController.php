<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('user_id',auth()->id())->with('orderItems.product')->get();

        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $input  = $request->validate([
            'address' => 'required',
            'phone_number' => 'required',
        ]);


        $orderId  = Order::latest()->first();

        if($orderId == null){
            $orderId = 1;
        }else{
            $orderId = $orderId->id +1;
        }

        $cartItems = Cart::where('user_id',auth()->id())->get();

        $orderTotal = 0;
        foreach($cartItems as $item){
            OrderItem::create([
                'order_id'=>$orderId,
                'product_id'=>$item->product_id,
                'qty'=>$item->qty
            ]);
            $item->decrease();
            $orderTotal = $orderTotal + $item->total;
            $item->delete();
        }

        Order::create([
            'user_id'=>auth()->id(),
            'total' => $orderTotal,
            'address' => $input['address'],
            'phone_number' =>$input['phone_number']
        ]);

        return response()->json([
            'message'=>'order is created'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
}
