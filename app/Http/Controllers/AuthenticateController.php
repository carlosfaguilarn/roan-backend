<?php

namespace Roan\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use DB;

class AuthenticateController extends Controller{
    public function authenticate(Request $request){
        $credentials = $request->only('email', 'password');
        try{
            if(!$token = JWTAuth::attempt($credentials)){
                return response()->json(['error'=>'invalid_credentials'], 401);
            }
        }catch(JWTException $e){
            return response()->json(['error'=>'could_not_create_token'], 500);
        }

        $response = compact('token');

        $response['user'] = DB::table('users')
          ->join('roles', 'roles.id', '=', 'users.id_rol')
          ->select('users.*', 'roles.name as role')
          ->where('users.id', Auth::user()->id)
          ->get();

        return $response;
    }
}
