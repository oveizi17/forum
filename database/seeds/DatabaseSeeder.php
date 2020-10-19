<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class)->create([
            'id' => 1,
            'name' => 'Orald Veizi',
            'email' => 'orald.veizi@gmail.com',

        ]);
        factory(App\User::class, 4)->create();

        factory(\App\Channel::class,5)->create();

        factory(\App\Thread::class, 20)->create();

        factory(\App\Reply::class, 50)->create();
    }
}
