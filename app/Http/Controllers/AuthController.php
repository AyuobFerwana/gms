<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
            'remember' => 'required|boolean',
        ]);

        if (!$validator->fails()) {
            $user = User::where('users', $request->input('username'))->first();
            if(!$user){
                return response()->json([
                    'message' => 'Wrong username or password.',
                ] ,Response::HTTP_BAD_REQUEST);
            }
            if(Hash::check($request->input('password'), $user->password)) {
                Auth::login($user, $request->input('remember'));
                return response()->json([
                    'message' => 'Logged in successfully!',
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'message' => 'Wrong email or password.',
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('login');
    }
}
