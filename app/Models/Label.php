<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function createLabel($request)
    {
        $data = $request->validated();
        $data['task_id'] = $request->task_id;
        $data['user_id'] = auth()->id();

        $label = self::create($data);

        return $label;
    }
}
