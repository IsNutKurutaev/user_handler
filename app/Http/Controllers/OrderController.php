<?php

namespace App\Http\Controllers;

use App\Http\Resources\ShowOrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function showOrder(Request $request)
    {
        $order = Order::find($request->id);

        return ShowOrderResource::collection(Order::all())->response()->setStatusCode(200);
    }
}
