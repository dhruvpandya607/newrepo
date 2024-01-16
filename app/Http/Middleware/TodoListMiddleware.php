<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class TodoListMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Schema::hasTable('user_todolist')) {
            $user = $request->user();

            if (! $request->header('todolist') || ! $user->hasTodolist($request->header('todolist'))) {
                $request->headers->set('todolist', $user->todolists()->first()->id);
            }
        }

        return $next($request);
    }
}
