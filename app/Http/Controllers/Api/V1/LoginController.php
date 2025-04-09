<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index(){
        return User::all();
    }

    public function show($id){
        return User::find($id);
    }

    public function store(Request $request){
        try {
            $request->validate([
                'name'=>'required',
                'email'=>'required|email',
                'password'=>'required',
            ],[
                'name.required'=>'Name is required',
                'email.required'=>'Email is required',
                'email.email'=>'Email must be a valid email address',
                'password.required'=>'Password is required',
            ]);


            $hashPassword = Hash::make($request->password);
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>$hashPassword,
            ]);
            return response()->json([
                'message'=>'User Created Successfully',
                'user'=>$user,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message'=>$th->getMessage()],
                500);
        }

    }

    public function update(Request $request, $id){
        try {
            $request->validate([
                'name'=>'required',
                'email'=>'required|email',
                'password'=>'required',
            ]);

            $user = User::find($id);
            if(!$user){
                return response()->json([
                    'message'=>'User Not Found',
                ], 404);
            }

            $user->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
            ]);
            return response()->json([
                'message'=>'User Updated Successfully',
                'user'=>$user,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message'=>$th->getMessage()],
                500);
        }

    }

    public function destroy($id){
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'message'=>'User Not Found',
            ], 404);
        }

        $user->delete();
        return response()->json([
            'message'=>'User Deleted Successfully',
        ]);
    }
}

