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
        $this->call(PermissionTableSeeder::class);
        $this->call(DefaultDataSeeder::class);
        $this->call(ParametrosSeeder::class);
        $this->call(PreguntasSeeder::class);
        $this->call(TestDataSeeder::class);
        $this->call(TablasSeeder::class);
        $this->call(CondicionSeeder::class);
    }
}
