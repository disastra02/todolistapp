<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $req)
    {
        $req->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        //get credentials from request
        $credentials = $req->only('email', 'password');

        //if auth failed
        if(!$token = auth()->guard('api')->attempt($credentials)) {
            return $this->sendError('Email atau Password Anda salah', 401);
        }

        //if auth success
        $data = [
            'user' => auth()->guard('api')->user(),
            'token' => $token 
        ];

        return $this->sendResponse($data, 'Login berhasil', 201);
    }

    public function register(Request $req)
    {
        $req->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|min:3|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
        ]);

        // Jika register berhasil
        if($user) {
            return $this->sendResponse($user, 'Registrasi berhasil, silahkan login', 201);
        }

        // Jika gagal
        return $this->sendError('Permintaan tidak dapat diproses', 409);
    }

    public function logout(Request $req)
    {
        //remove token
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

        if($removeToken) {
            //return response JSON
            return $this->sendResponse([], 'Logout berhasil');
        }
    }
}
