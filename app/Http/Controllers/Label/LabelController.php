<?php

namespace App\Http\Controllers\Label;

use App\Http\Controllers\Controller;
use App\Http\Requests\LabelValidateRequest;
use App\Http\Resources\LabelResource;
use App\Models\Label;
use App\Models\Task;

class LabelController extends Controller
{
    public function index(Task $task)
    {
        $labels = Label::where('task_id', $task->id)->get();

        return LabelResource::collection($labels);
    }

    public function store(LabelValidateRequest $request)
    {
        $this->authorize('create', Label::class);

        $label = Label::createLabel($request);

        return new LabelResource($label);
    }

    public function update(LabelValidateRequest $request, Label $label)
    {
        $this->authorize('update', $label);

        $label->update($request->validated());

        return new LabelResource($label);
    }

    public function destroy(Label $label)
    {
        $this->authorize('delete', $label);

        $label->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}