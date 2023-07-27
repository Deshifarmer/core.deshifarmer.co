<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\MyProfileResource;
use App\Http\Resources\v1\UserResource;
use App\Models\User;
use App\Models\v1\Employee;
use Illuminate\Http\Request;

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
        return UserResource::collection(Employee::where('type',1)->get()->sortByDesc('created_at')) ;

    }

    public function allDistributor()
    {
        return UserResource::collection(Employee::where('type',2)->get()->sortByDesc('created_at')) ;
    }

    public function allMicroEnt()
    {
       return UserResource::collection(Employee::where('type',3)->get()->sortByDesc('created_at')) ;
    }
    public function allTerritoryManager()
    {
       return UserResource::collection(Employee::where('type',4)->get()->sortByDesc('created_at')) ;
    }
    public function unassignedDistributor()
    {
        return UserResource::collection(Employee::where('type',2)
        ->where('channel',null)
        ->Where('channel_assign_by',null)
        ->get()) ;
    }

    public function unassignedMe()
    {
        return UserResource::collection(Employee::where('type',3)
        ->where('channel',null)
        ->Where('channel_assign_by',null)
        ->get()) ;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }


}
