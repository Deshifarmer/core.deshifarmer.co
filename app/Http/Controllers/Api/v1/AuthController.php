<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\v1\AuthResource;
use App\Http\Resources\v1\UserResource;
use App\Models\User;
use App\Models\v1\Employee;
use App\Models\v1\EmployeeAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users,phone',
            'nid' => 'required|unique:users,nid',
            'role' => 'required|in:0,1,2,3',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $arr = [
            0 => 'HQ-',
            1 => 'CO-',
            2 => 'DB-',
            3 => 'ME-'
        ];
        $input['df_id'] = $arr[$input['role']] . $this->generateUuid();

        Employee::create([
            'df_id' => $input['df_id'],
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'phone' => $input['phone'],
            'email' => $input['email'],
            'nid' => $input['nid'],
            'type' => $input['role'],
            'onboard_by' => auth()->user()->df_id,
        ]);
        EmployeeAccount::create([
           'acc_number' => $input['df_id'],
        ]);
        $user = User::create($input);
        // return AuthResource::make($user);
        return response()->json(['success' => 'User created successfully'], 201);
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        if (Auth::attempt([$fieldType => $credentials['email'], 'password' => $credentials['password']])) {
            $user = Auth::user();
            if ($user->access_revoked) {

                return response()->json(['error' => 'Access revoked'], 401);
            }
            if ($user->role == 0 || $user->role == 1) {
                return AuthResource::make($user);
            }
            if ($user->role == 2 && Employee::where('df_id', $user->df_id)->first()->channel != null) {
                return AuthResource::make($user);
            } else if ($user->role == 3 && Employee::where('df_id', $user->df_id)->first()->under != null) {
                return AuthResource::make($user);
            } else {

                return response()->json(
                    ['error' => 'You do not have access to this portal'],
                    401
                );
            }
        } else {
            return response()->json(['error' => 'Email or password incorrect'], 401);
        }
    }

    /**
     * Logout api
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'user logged out successfull'
        ];
    }
}
