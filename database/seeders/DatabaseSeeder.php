<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\TodoList;
use App\Models\User;
use Illuminate\Database\Seeder;
use Silber\Bouncer\BouncerFacade;
use Vinkla\Hashids\Facades\Hashids;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $admin = BouncerFacade::role()->firstOrCreate([
            'name' => 'admin',
            'title' => 'administration',
        ]);

        foreach (config('abilities.abilities') as $ability) {
            BouncerFacade::allow($admin)->to($ability['ability'], $ability['model']);
        }

        $user = User::factory()->create([
            'name' => 'dhruv',
            'email' => 'dhruv@gmail.com',
            'password' => 'password123',
            'role' => 'admin',
        ]);

        $todolist = TodoList::factory()->create([
            'name' => 'demo list',
            'user_id' => $user->id,
        ]);

        $todolist->unique_hash = Hashids::connection(TodoList::class)->encode($todolist->id);
        $todolist->save();

        $user->todolists()->attach($todolist->id);
        BouncerFacade::scope()->to($todolist->id);

        BouncerFacade::assign('admin')->to($user);
    }
}
