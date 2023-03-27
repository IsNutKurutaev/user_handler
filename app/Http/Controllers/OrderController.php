<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeOrderStatusRequest;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Resources\ShowOrderOnShiftResource;
use App\Http\Resources\ShowOrderResource;
use App\Http\Resources\ShowOrderTakenResource;
use App\Models\Order;
use App\Models\Shifts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class OrderController extends Controller
{
    public function createOrder(CreateOrderRequest $request)
    {
        $shift = Shifts::find($request['work_shift_id']);

        if (!$shift?->active) {
            return response(['error' => ['code' => 403, 'message' => 'Forbidden. The shift must be active!']], 403);
        }

        $is_worker_on_shift = $shift->users->pluck('id')->contains(Auth::user()->id);

        if ($is_worker_on_shift) {
            $worker_on_shift = Order::create([
                'shift_workers' => Auth::user()->id,
                'create_at' => now(),
                'status' => Order::ACCEPTED,
                'shift_id' => $shift->id,
                'person_tally' => $request['count'],
                'table_id' => $request['table_id'],
            ]);

            return response(['data' => [
                'id' => $worker_on_shift->id,
                'table' => $worker_on_shift->table->name,
                'shift_worker' => $worker_on_shift->user->name,
                'create_at' => $worker_on_shift->create_at,
                'status' => $worker_on_shift->status,
                'price' => 0,
            ]], 200);
        }
        return response(['error' => ['code' => 403, 'message' => 'Forbidden. You don`t work this shift!']], 403);
    }

    public function showOrder(Request $request)
    {
        $order = Order::find($request->id);

        $user = User::firstWhere('api_token', $request->bearerToken());

        if ($order->shift_workers === $user->id) {
            return (new ShowOrderResource($order))->response()->setStatusCode(200);
        }

        return response(['error' => ['code' => 403, 'message' => 'Forbidden. You did not accept this order!']], 403);
    }

    public function showOrderOnShift(Request $request)
    {
        $order = Order::find($request->id);

        $user = User::firstWhere('api_token', $request->bearerToken());

        $shift = Shifts::find($request->id);

        if ($order->shift_workers === $user->id) {
            return ShowOrderOnShiftResource::collection($shift->get())->response()->setStatusCode(200);
        }

        return response(['error' => ['code' => 403, 'message' => 'Forbidden. You did not accept this order!']], 403);
    }

    public function changeOrderStatus(Order $order, ChangeOrderStatusRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();

        Gate::authorize('shift-active', $order);

        if ($user->group->slug === User::WAITER) {
            Gate::authorize('waiter-order-owner', $order);

            if (!Gate::check('waiter-can-change-status', [$order, $request])) {
                return response(['error' => ['code' => 403, 'message' => 'Forbidden! Can`t change existing order status']], 403);
            }
        }

        if ($user->group->slug === User::COOK) {
            if (!Gate::check('cook-can-change-status', [$order, $request])) {
                return response(['error' => ['code' => 403, 'message' => 'Forbidden! Can`t change existing order status']], 403);
            }
        }

        $order->update(['status' => $request->status]);

        return response(['data' => ['id' => $order->id, 'status' => $order->status]], 200);
    }

    public function showOrderTaken()
    {
        $order = Order::query()->where('status', Order::ACCEPTED)->orWhere('status', Order::PREPARING)->get();

        return ShowOrderTakenResource::collection($order)->response()->setStatusCode(200);
    }
}
