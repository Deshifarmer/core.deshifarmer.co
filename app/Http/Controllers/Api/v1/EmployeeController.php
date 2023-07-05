<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;

use App\Models\v1\Employee;
use Illuminate\Http\Request;
use App\Http\Resources\v1\MyProfileResource;
use App\Http\Resources\v1\UserResource;
use Illuminate\Support\Facades\Validator;



class EmployeeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return EmployeeResource::collection(Employee::orderBy('id', 'desc')->paginate($this->perPage));
        // return EmployeeResource::collection(Employee::all());


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     'nid' => 'required|string',
        //     'phone' => 'required'
        // ]);

        // if ($validator->fails()) {
        //     return $this->sendError('Error validation', $validator->errors());
        // }
        $data = $request->all();


        if ($request->photo){
            $extension = $request->photo->getClientOriginalExtension();

            $request->photo->storeAs('public/image/employee',$request->df_id . '.' . $extension);
            $image_path = '/image/employee/' . $request->df_id . '.' . $extension;
        }
        else{
            $image_path = "/image/employee/default.png";
        }
        $data['photo'] =  $image_path;
        $employee = Employee::create($data);
       return Response()->json([
            'message' => 'Employee created successfully',
            'data' => $employee
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return new UserResource($employee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $employee->update(
            $request->all()
        );
        return new UserResource($employee);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        // return $employee->delete();
    }

    public function distributorsMe(Employee $employee)
    {
        return UserResource::collection(
            Employee::where('under', $employee->df_id)->get()
        );
    }



    public function myMe()
    {
        return UserResource::collection(
            Employee::where('under', auth()->user()->df_id)->get()
        );
    }

    public function myProfile()
    {
       return MyProfileResource::make(Employee::where('df_id', auth()->user()->df_id)->first());
    }

    public function myMeProfile(Employee $employee)
    {
        return MyProfileResource::make($employee);
    }

}
