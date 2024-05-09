<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $response = Http::post('http://127.0.0.1:8001/api/postlogin', [
            'username' => $request->username,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            return response()->json(['redirect' => '/']); 
        } else {
            return response()->json(['message' => 'Login gagal. Silakan coba lagi.'], $response->status());
        }
    }
}