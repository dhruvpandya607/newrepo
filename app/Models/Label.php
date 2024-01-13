<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function todolists()
    {
        return $this->belongsToMany(TodoList::class, 'todo_lists_label');
    }

    public static function createLabel($request)
    {
        $data = $request->validated();
        $label = self::create($data);

        return $label;
    }
}
