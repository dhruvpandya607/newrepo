<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public const STARTED = 'started';

    public const NOT_STARTED = 'not started';

    public const COMPLETED = 'completed';


    protected $fillable = [
        'title', 'description', 'status', 'user_id', 'todo_list_id', 'label_id',
    ];

    public function todolist()
    {
        return $this->belongsTo(TodoList::class);
    }

    public function label()
    {
        return $this->belongsTo(Label::class);
    }
}