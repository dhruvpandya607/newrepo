<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRolesAndAbilities, Notifiable;

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public const ADMIN = 'admin';

    public const VIEWER = 'viewer';

    public function todolists()
    {
        return $this->belongsToMany(TodoList::class, 'user_todolist');
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'user_task');
    }

    public function hasTodolist($todo_list_id)
    {
        $todolist = $this->todolists()->pluck('todo_list_id')->toArray();

        return in_array($todo_list_id, $todolist);
    }
}
