<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTokensController extends Controller
{
    public function store(Request $request){

        $request->validate([
            'email'=>'required|email|max:255',
            'password'=>'required|string|min:8',
            'device_name'=>'string|max:255',
        ]);

        $user=User::where('email',$request->email)->first();
        if($user && Hash::check($request->password,$user->password)){

            $device_name=$request->post('device_name',$request->userAgent());
            $token=$user->createToken($device_name);
            return Response::json([
                'token' => $token->plainTextToken,
                'user' => $user,
            ],201);
        }

         return Response::json([
            'message'=>'Invalid',
         ],401);
    }

    public function destory($token = null){

        $user=Auth::guard('sanctum')->user();

        $user->tokens()->delete();

        // if(null === $token){
        //     $user->currentAccessToken()->delete();
        //     return ;
        // }

        // $personalAccessToken=PersonalAccessToken::findToken($token);

        // if($user->id == $personalAccessToken->tokenable_id 
        //     && get_class($user) == $personalAccessToken->tokenable_type){
        //     $personalAccessToken->delete();

        // }

        return Response::json(['message'=>"Successfully logged out."],200);
        //$user->tokens()->where('token',$token)->delete();
    }
}
