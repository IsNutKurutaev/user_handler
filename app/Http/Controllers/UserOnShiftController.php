<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUserOnShiftRequest;
use App\Models\Shifts;

class UserOnShiftController extends Controller
{
    public function addUserOnShift(Shifts $shift, AddUserOnShiftRequest $request)
    {
        if ($shift->users->pluck('id')->contains($request->get('user_id'))) {
            return response(['error' => ['code' => 403, ' message' => 'Forbidden. The worker is already on shift']], 403);
        }

        $shift->users()->attach($request->get('user_id'));

        return response(['data' => ['id_user' => $request->get('user_id'), 'status' => 'added']], 200);
    }
}
