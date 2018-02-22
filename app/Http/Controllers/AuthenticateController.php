<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AuthenticateController extends Controller
{
    public function login(Request $request) {
        $token = app('auth')->attempt($request->only('phone_number', 'password'));
        return response()->json(compact('token'));
    }
}
