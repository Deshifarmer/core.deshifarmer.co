<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\AttendanceResource;
use App\Http\Resources\v1\AttendenceResource;
use App\Models\v1\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Attendance::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        if (Attendance::where('employee_id', auth()->user()->df_id)->whereDate('check_in', now())->exists()) {
            return response()->json([
                'message' => 'You have already checked in today'
            ], 400);
        }
        $input['employee_id'] = auth()->user()->df_id;
        if ($request->has('check_in')) {
            $input['check_in'] = now();
        }
        Attendance::create($input);
        return response()->json([
            'message' => 'check in successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        if ($request->has('check_out') && $attendance->check_out != null) {
            return response()->json([
                'message' => 'You have already checked out'
            ], 400);
        } elseif ($request->has('check_out') && carbon::parse($attendance->check_in)->diffInDays(Carbon::now()) == 0) {
            $attendance->check_out = now();
            $attendance->save();
            return response()->json([
                'message' => 'Check out successfully'
            ], 200);
        } else {
            return response()->json([
                'message' => 'You can not check out for previous days'
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }


    public function todays_attendance()
    {
        $t_attend = Attendance::where('employee_id', auth()->user()->df_id)->whereDate('check_in', now())->first();
        if ( $t_attend){

            return response()->json(
                AttendanceResource::make($t_attend),
                200
            );
        }else{
            return response()->json([
                'message' => 'You have not checked in yet'
            ], 400);
        }


    }

    public function attendance_history()
    {
        $endDate = now()->subDay()->endOfDay();
        $startDate = now()->subDays(7)->startOfDay();

        $attendances = Attendance::where('employee_id', auth()->user()->df_id)
            ->whereBetween('check_in', [$startDate, $endDate])
            ->orderByDesc('id')
            ->get()->map(function ($attendance) {
                return [
                    'date' => Carbon::parse($attendance->check_in)->format('d-m-Y'),
                    'work_hour' => Carbon::parse($attendance->check_in)->diff(Carbon::parse($attendance->check_out))->format('%H')
                ];
            });

        return response()->json(
            $attendances,
            200
        );
    }
}
