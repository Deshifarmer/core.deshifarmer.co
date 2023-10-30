<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\MyProfileResource;
use App\Http\Resources\v1\UserResource;
use App\Models\User;
use App\Models\v1\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function allCompany()
    {
        return UserResource::collection(Employee::where('type', 1)->inRandomOrder()->get());
    }

    public function allDistributor()
    {
        return UserResource::collection(Employee::where('type', 2)->get()->sortByDesc('created_at'));
    }

    public function allMicroEnt()
    {
        return UserResource::collection(Employee::where('type', 3)->get()->sortByDesc('created_at'));
    }
    public function allTerritoryManager()
    {
        return UserResource::collection(Employee::where('type', 4)->get()->sortByDesc('created_at'));
    }
    public function unassignedDistributor()
    {
        return UserResource::collection(Employee::where('type', 2)
            ->where('channel', null)
            ->Where('channel_assign_by', null)
            ->get());
    }

    public function unassignedMe()
    {
        return UserResource::collection(Employee::where('type', 3)
            ->where('channel', null)
            ->Where('channel_assign_by', null)
            ->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nid' => 'string|unique:users,nid,' . $user->id,
            'phone' => 'string|unique:users,phone,' . $user->id,
            'email' => 'string|email|unique:users,email,' . $user->id,

        ]);
        if ($validator->fails()) {
            return ['Error validation', $validator->errors()];
        }
        if (Auth::user()->df_id == 'HQ-01' || Auth::user()->df_id == $user->df_id) {

            $user->update(
                $request->only('first_name', 'last_name', 'nid', 'phone', 'email')
            );
            $employee_db = Employee::where('df_id', $user->df_id)->first();
            if ($request->hasFile('photo')) {
                Storage::delete('public/' .  $employee_db->photo);
                $extension = $request->photo->getClientOriginalExtension();
                $request->photo->storeAs('public/image/employee', $user->df_id . '.' . $extension);
                $image_path = '/image/employee/' . $user->df_id . '.' . $extension;
            }
            Employee::where('df_id', $user->df_id)->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'nid' => $request->nid,
                'phone' => $request->phone,
                'email' => $request->email,
                'photo' => $image_path ?? $employee_db->photo
            ]);
            return response()->json(['message' => 'User Updated Successfully'], 200);
        } else {
            return response()->json(['error' => 'unauthorize'], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
