<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    public function task()
    {
        return $this->hasMany(Task::class, 'todo_list_id');
    }
}
