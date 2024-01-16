<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Silber\Bouncer\BouncerFacade;

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

    public function setRole()
    {
        BouncerFacade::scope()->to($this->id);

        $admin = BouncerFacade::role()->firstOrCreate([
            'name' => 'admin',
            'title' => 'Admin',
            'scope' => $this->id,
        ]);

        foreach (config('abilities.abilities') as $ability) {
            BouncerFacade::allow($admin)->to($ability['ability'], $ability['model']);
        }
    }

    public static function createTodolist($request)
    {
        $data = $request->validated();
        $todo_list = self::create($data);

        return $todo_list;
    }
}
