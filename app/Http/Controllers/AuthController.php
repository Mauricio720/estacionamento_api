<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function logged()
    {
        return Auth::user();
    }

    public function login(AuthRequest $request)
    {

        $token = Auth::guard('api')->attempt([
            'email'=>$request->input('email'),
            'password'=>$request->input('password'),
            'type'=>1
        ]);

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email e/ou senha estão incorretos',
            ], 401);
        }

        $user = Auth::guard('api')->user();
        
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'token' => $token,
        ]);
    }

    
    public function register(UserRequest $request){
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->type = 1;
        $user->password = Hash::make($request->input('password'));
        $user->save();

        $token = Auth::guard('api')->attempt([
            'email'=>$request->input('email'),
            'password'=>$request->input('password'),
        ]);

        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'token' => $token,
        ],201);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'token' => Auth::refresh(),
        ]);
    }

    public function unauthorized()
    {
        return response()->json([
            'status' => 'Não Autorizado',
        ]);
    }

}