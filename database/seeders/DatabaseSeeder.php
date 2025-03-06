<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserTableSeeder;
use Database\Seeders\ProjectTableSeeder;
use Database\Seeders\AttributeTableSeeder;
use Database\Seeders\TimesheetTableSeeder;
use Database\Seeders\AttributeValueTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            UserTableSeeder::class,
            ProjectTableSeeder::class,
            AttributeTableSeeder::class,
            AttributeValueTableSeeder::class,
            TimesheetTableSeeder::class,
        ]);
    }
}
