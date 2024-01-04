<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskValidateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules()
    {
        return [
            'title' => 'required',
            'description' => '',
            'status' => '',
            'todo_list_id' => '',
            'user_id' => '',
        ];
    }
}
