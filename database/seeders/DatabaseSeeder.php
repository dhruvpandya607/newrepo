<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Silber\Bouncer\BouncerFacade;

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

        BouncerFacade::allow($admin)->everything();

        $authUser = User::factory()->create([
            'name' => 'dhruv',
            'email' => 'dhruv@gmail.com',
            'password' => 'password123',
            'role' => 'admin',
        ]);

        $authUser->assign($admin);
    }
}
