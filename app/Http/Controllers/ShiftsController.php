<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShiftRequest;
use App\Models\Shifts;
use Illuminate\Http\Request;

class ShiftsController extends Controller
{
    public function createShift(ShiftRequest $request)
    {
        $shift = Shifts::create($request->all());

        return response(['id' => $shift->id, 'start' => $shift->start, 'end' => $shift->end]);
    }
    public function shiftOpen(Request $request)
    {
        $is_shift_are_opens = Shifts::firstWhere('active', true);

        if ($is_shift_are_opens != null) {
            return response(['error' => ['code' => 403, 'message' => 'Forbidden. There are open shifts']], 403);
        }

        $current_shift = Shifts::find($request->id);
        $current_shift->update(['active' => true]);

        return response(['data' => ['id' => $current_shift->id, 'start' => $current_shift->start, 'end' => $current_shift->end, 'active' => $current_shift->active]],200);
    }
    public function shiftClose(Request $request)
    {
        $current_shift = Shifts::find($request->id);

        if (! $current_shift->active) {
            return response(['error' => ['code' => 403, 'message' => 'Forbidden. The shift is already closed!']], 403);
        }

        $current_shift->update(['active' => false]);
        return response(['data' => ['id' => $current_shift->id, 'start' => $current_shift->start, 'end' => $current_shift->end, 'active' => $current_shift->active]],200);
    }
}
