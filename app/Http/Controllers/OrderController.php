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
use App\Models\WorkerOnShift;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    public function createOrder(CreateOrderRequest $request)
    {
        $shift = Shifts::find($request['work_shift_id']);

        if (! $shift?->active) {
            return response(['error' => ['code' => 403, 'message' => 'Forbidden. The shift must be active!']], 403);
        }

        $user = User::firstWhere('api_token', $request->bearerToken());

        $is_worker_on_shift = WorkerOnShift::query()->where('user_id', $user->id)->where('shift_id', $shift?->id)->first();

        if ($is_worker_on_shift) {
            $worker_on_shift = Order::forceCreate([
                'shift_workers' => User::firstWhere('api_token', $request->bearerToken())->id,
                'create_at' => now(),
                'status' => 'Принят',
                'shift_id' => Shifts::firstWhere('active', 1)->id,
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

    public function changeOrderStatus(ChangeOrderStatusRequest $request)
    {

        $user = User::firstWhere('api_token', $request->bearerToken());

        $order = Order::find($request->id);

        if ( ! $order->shift->active) {
            return response(['error' => ['code' => 403, 'message' => 'You cannot change the order status of a closed shift!']], 403);
        }

        if ($user->group->slug === 'waiter') {
            if ($order->user->id !== $user->id) {
                return response(['error' => ['code' => 403, 'message' => 'Forbidden! You did not accept this order!']], 403);
            }

            if ( ! (($order->status === 'Принят' && $request->status === 'Отменен') || ($order->status === 'Готов' && $request->status === 'Оплачен')) ) {
                return response(['error' => ['code' => 403, 'message' => 'Forbidden! Can`t change existing order status']], 403);
            }
        }

        if ($user->group->slug === 'cook') {
            if ( ! (($order->status === 'Принят' && $request->status === 'Готовится') || ($order->status === 'Готовится' && $request->status === 'Готов')) ) {
                return response(['error' => ['code' => 403, 'message' => 'Forbidden! Can`t change existing order status']], 403);
            }
        }

        $order->update(['status' => $request->status]);

        return response(['data' => ['id' => $order->id, 'status' => $order->status]], 200);
    }

    public function showOrderTaken()
    {
        $order = Order::query()->where('status', 'Принят')->orWhere('status', 'Готовится')->get();

        return ShowOrderTakenResource::collection($order)->response()->setStatusCode(200);
    }
}
