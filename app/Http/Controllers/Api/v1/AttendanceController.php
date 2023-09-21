<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\AttendanceResource;

use App\Models\v1\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $today = Carbon::today();
        return AttendanceResource::collection( Attendance::whereDate('created_at', $today)->orderBy('id', 'desc')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'cin_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cin_location' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => $validator->errors()
                ],
                422
            );
        }

        $input = $request->only(['cin_location', 'cin_image', 'check_in']);

        if (Attendance::where('employee_id', auth()->user()->df_id)->whereDate('check_in', now())->exists()) {
            return response()->json([
                'message' => 'You have already checked in today'
            ], 400);
        }

        if ($request->has('check_in')) {
            $input['employee_id'] = auth()->user()->df_id;
            $extension = $request->file('cin_image')->getClientOriginalExtension();
            $request->file('cin_image')->storeAs('public/attendance', time() . '.' . $extension);
            $image_path = '/attendance/' . time() . '.' . $extension;
            $input['cin_image'] =  $image_path;
            $input['check_in'] = now();
            Attendance::create($input);
            return response()->json([
                'message' => 'check in successfully'
            ], 201);
        }
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

        $validator = Validator::make($request->all(), [
            'cout_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cout_location' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => $validator->errors()
                ],
                422
            );
        }
        if ($request->has('check_in')) {
            return response()->json([
                'message' => 'You have already checked in yet'
            ], 400);
        }
        if ($request->has('check_out') && $attendance->check_out != null) {
            return response()->json([
                'message' => 'You have already checked out'
            ], 400);
        } elseif ($request->has('check_out') && carbon::parse($attendance->check_in)->diffInDays(Carbon::now()) == 0 && $attendance->check_out == null && $attendance->check_in != null) {
            $extension = $request->file('cout_image')->getClientOriginalExtension();
            $request->file('cout_image')->storeAs('public/attendance', time() . '.' . $extension);
            $image_path = '/attendance/' . time() . '.' . $extension;

            $attendance->update([
                'check_out' => now(),
                'cout_location' => $request->cout_location,
                'cout_image' => $image_path
            ]);
            return response()->json([
                'message' => 'Check out successfully'
            ], 200);
        } else {
            return response()->json([
                'message' => 'You can not check in today'
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
        if ($t_attend) {

            return response()->json(
                AttendanceResource::make($t_attend),
                200
            );
        } else {
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
