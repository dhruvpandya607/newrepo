<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'title' => $this->title,
            'status' => $this->status,
            'todolist' => $this->todolist->name,
            'label' => new LabelResource($this->label),
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
