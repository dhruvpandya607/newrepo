<?php

namespace Database\Seeders;

use Silber\Bouncer\BouncerFacade as Bouncer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BouncerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Bouncer::allow('admin')->everything();

        Bouncer::allow('viewer')->toOwnEverything()->to('view');
    }
}
