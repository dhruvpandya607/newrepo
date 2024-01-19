<?php

namespace App\Http\Controllers\Admin\Abilities;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AbilitiesController extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->json(['abilities' => config('abilities.abilities')]);
    }
}
