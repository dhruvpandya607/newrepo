<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbilitiesController extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->json(['abilities' => config('abilities.abilities')]);
    }
}
