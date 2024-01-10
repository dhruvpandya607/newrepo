<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public const STARTED = 'started';

    public const NOT_STARTED = 'not_started';

    public const COMPLETED = 'completed';

    protected $guarded = ['id'];

    public function todolist()
    {
        return $this->belongsTo(TodoList::class, 'todo_list_id');
    }

    public function label()
    {
        return $this->belongsTo(Label::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function createTask($request)
    {
        $data = $request->validated();
        $data['todo_list_id'] = $request->todo_list_id;
        $data['user_id'] = auth()->id();
        $task = self::create($data);

        return $task;
    }
}
