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
    public function view(User $user, TodoList $todo_list)
    {
        if (BouncerFacade::can('view-todolist', $todo_list)) {
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
    public function update(User $user, TodoList $todo_list)
    {
        if (BouncerFacade::can('update-todolist', $todo_list) && $todo_list->user_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TodoList $todo_list)
    {
        if (BouncerFacade::can('delete-todolist', $todo_list) && $todo_list->user_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TodoList $todo_list)
    {
        if (BouncerFacade::can('restore-todolist', $todo_list)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TodoList $todo_list)
    {
        if (BouncerFacade::can('delete-todolist', $todo_list) && $todo_list->user_id === $user->id) {
            return true;
        }

        return false;
    }
}
