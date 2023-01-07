<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::guard('api')->attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::guard('api')->user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::guard('api')->login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::guard('api')->user(),
            'authorisation' => [
                'token' => Auth::guard('api')->refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    public function getmaid(Request $request)
    {
        
        $data = json_decode($request->getContent());
        // dd($data);
        if(Auth::guard('api')->user()->user_type == "Api" || Auth::guard('api')->user()->user_type == "Admin"){
            $id = "";
            $con = false;
            if(isset($data->er_id) && $data->er_id != ""){
                $con = true;
                $id = $data->er_id;
            }elseif (isset($data->maid_id) && $data->maid_id != "") {
                $con = true;
                $id = $data->maid_id;
            }

            if($con == false){
                return response()->json([
                    'status' => 'false',
                    'msg' => 'Please check your payload'
                ]);
            }else{
                $record = DB::select("SELECT * FROM applicants WHERE er_ref = '$id' or maid_ref = '$id'");
                return response()->json([
                    'status' => 'success',
                    'msg' => $record
                ]);
            }
        }else{
            Auth::guard('api')->logout();
            return response()->json([
                'status' => 'success',
                'msg' => 'Your account does not have permission to use this.' 
            ]);
        }
    }
}
