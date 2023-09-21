<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Upload extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $image = $request->file('image')->store('public');
        $image = explode('/',$image)[1];
        return response()->json([
            'image_name'=>$image,
            'image_base_url'=>url('/storage'),
            'full_path'=>url('/') . '/storage/' . $image
        ]);
    }
}
