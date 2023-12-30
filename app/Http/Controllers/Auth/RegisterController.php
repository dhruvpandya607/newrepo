<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{

    public function create()
    {
        return view('register.create');
    }


    public function store(RegisterRequest $request)
    {
        $user = User::create($request->all());
        return $user;
    }
}
