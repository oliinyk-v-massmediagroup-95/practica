<?php
declare(strict_types=1);

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('users')->truncate();
        factory(\App\Models\User::class, 1)->create();
    }
}
