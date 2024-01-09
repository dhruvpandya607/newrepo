<?php

namespace App\Policies;

use App\Models\TodoList;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Silber\Bouncer\BouncerFacade;

class TodoListPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        if (BouncerFacade::can('view-todolist', TodoList::class)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TodoList $todoList)
    {
        if (BouncerFacade::can('view-todolist', $todoList)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        if (BouncerFacade::can('create-todolist', TodoList::class)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TodoList $todoList)
    {
        if (BouncerFacade::can('update-todolist', $todoList)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TodoList $todoList)
    {
        if (BouncerFacade::can('delete-todolist', $todoList)) {
            return true;
        }

        return false;
    }
}
