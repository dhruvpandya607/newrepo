<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Label;
use App\Http\Resources\LabelResource;
use App\Http\Requests\LabelValidateRequest;

class LabelController extends Controller
{

    public function index(Task $task)
    {
        $labels = Label::where('task_id', $task->id)->get();
        return LabelResource::collection($labels);
    }

    public function store(LabelValidateRequest $request, Task $task)
    {
        $Label = $task->label()->create($request->validated());
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
}
