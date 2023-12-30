<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabelValidateRequest;
use App\Models\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{

    public function index()
    {
        $labels = Label::all();
        return $labels;
    }

    public function create()
    {
        return view('label.create');
    }

    public function store(LabelValidateRequest $request)
    {
        return Label::create($request->all());
    }

    public function update(LabelValidateRequest $request, Label $label)
    {
        $Label = Label::where('id', $label->id)->update($request->all());
        return $Label;
    }

    public function destroy(Label $label)
    {
        $label->delete();
    }

    public function edit(string $id)
    {
        return view('label.edit');
    }
}
