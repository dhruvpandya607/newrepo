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

    public function todolists()
    {
        return $this->belongsTo(TodoList::class, 'todo_list_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_task');
    }

    public static function createTask($request)
    {
        $data = $request->validated();
        $data['todo_list_id'] = $request->todo_list_id;
        $task = self::create($data);

        return $task;
    }
}
