<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LabelResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'name' => $this->name,
            'color' => $this->color,
            'todolist' => $this->when($this->todolists()->exists(), function () {
                return new TodoListResource($this->todolist);
            }),
        ];
    }
}
