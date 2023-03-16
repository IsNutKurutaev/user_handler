<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUserOnShiftRequest;
use App\Models\WorkerOnShift;
use Illuminate\Http\Request;

class UserOnShiftController extends Controller
{
    public function addUserOnShift(AddUserOnShiftRequest $request)
    {
        $is_user_on_shift = WorkerOnShift::query()->where('shift_id', $request->id)->where('user_id', $request->user_id)->first();

        if ($is_user_on_shift) {
            return response(['error' => ['code' => 403, ' message' => 'Forbidden. The worker is already on shift']], 403);
        }

        $add_user_on_shift = WorkerOnShift::forceCreate([
            'user_id' => $request->user_id,
            'shift_id' => $request->id,
        ]);

        return response(['data' => ['id_user' => $add_user_on_shift->id, 'status' => 'added']], 200);
    }
}
