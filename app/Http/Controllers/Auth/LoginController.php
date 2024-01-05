<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{

    public function create()
    {
        return view('login.create');
    }

    public function store(LoginRequest $request)
    {
        $user = User::where(['email' => $request->email])->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email and Password not matched.'],
            ]);
        };

        $token = $user->createToken('firstToken');
        // dd($token->plainTextToken);
        return ['token' => $token->plainTextToken];
    }
}
