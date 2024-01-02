<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\LabelResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'todolist' => $this->todolist->name,
            'label' => new LabelResource($this->label),
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
