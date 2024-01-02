<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    public const STARTED = 'started';

    public const NOT_STARTED = 'not_started';

    public const COMPLETED = 'completed';


    protected $fillable = [
        'title', 'todo_list_id', 'description', 'status', 'label_id',
    ];

    public function todolist()
    {
        return $this->belongsTo(TodoList::class, 'todo_list_id');
    }

    public function label()
    {
        return $this->belongsTo(Label::class, 'label_id');
    }
}
