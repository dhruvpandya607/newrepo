<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Http\Resources\LabelResource;
use App\Http\Requests\LabelValidateRequest;

class LabelController extends Controller
{

    public function index()
    {
        $labels = auth()->user()->label;
        return LabelResource::collection($labels);
    }

    public function create()
    {
        return view('label.create');
    }

    public function store(LabelValidateRequest $request)
    {
        $Label = Label::create($request->validated());
        return new LabelResource($Label);
    }

    public function update(LabelValidateRequest $request, Label $label)
    {
        $label->update($request->validated());
        return new LabelResource($label);
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
