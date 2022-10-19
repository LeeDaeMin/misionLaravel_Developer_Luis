<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{

    public function login(Request $request)
    {

            $credentials = $request->only(['username', 'password']);

            if (!$token = Auth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => 21600
            ]);


    }



    public function me()
    {
        $user = User::where('id', Auth::user()->id)->with(['roles' , 'roles.permissions' ])->first();
        return response()->json($user);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|string',
                'admin_global' => 'string'
            ]);

            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            if ($request->admin_global && $request->admin_global = "adminKey")
            {
                $user->assignRole('admin');
            }else {
                $user->assignRole('customer');
            }

        }
        catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json([
            '오케이' => 'Successfully created user !'
        ], 201);
    }


}
