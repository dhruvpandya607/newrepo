<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class, 'todo_lists_label');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_todolist');
    }

    public static function createTodolist($request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $todo_list = self::create($data);

        return $todo_list;
    }
}
