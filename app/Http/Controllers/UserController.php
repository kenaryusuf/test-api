<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return response()->json(['status' => 'fail', 'message' => 'Email veya parola hatalı!'],401);
        }

        if(Hash::check($request->input('password'), $user->password)){
            $token = base64_encode(Str::random(40));
            $user->remember_token = $token;
            $user->save();
            return response()->json(['status' => 'success','token' => $token]);
        }else{
            return response()->json(['status' => 'fail', 'message' => 'Email veya parola hatalı!'],401);
        }
    }
}
