<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function registerUser(Request $request){
        $users = DB::table('users');
        $rules = array(
            'name' => ['required', 'regex: /^[a-zA-Z0-9\s]*$/'],
            'email' => 'required |email | unique:users,email',
            'password' => 'required | min:4'
        );
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(), 402);
        }
        else{
            $users->insertOrIgnore([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            if($users){
                $request->session()->put('email', $request->email);
                return response()->json(['result' => 'Registered successfully'], 200);
            }
            else{
                return response()->json(['result' => 'Registration failed'], 404);
            }
        }
    }

    public function loginUser(Request $request){
        $users = DB::table('users');
        $rules = array(
            'email' => 'required |email',
            'password' => 'required | min:4'
        );
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(), 402);
        }
        else{
            $user = $users->where('email',$request->email)->first();
            if(!$user || !Hash::check($request->password, $user->password)){
                return response()->json(['result' => 'Invalid user'], 500);
            }else{
                $request->session()->put('email', $request->email);
                return response()->json(['result' => 'Login successfully'], 200);
            }
        }
    }

    public function logoutUser(){
        if(session()->has('email')){
            session()->pull('email');
            return response()->json(['result' => 'Logout successfully'], 200);
        }else{
            return response()->json(['result' => 'Logout failed'], 500);
        }
    }
}
