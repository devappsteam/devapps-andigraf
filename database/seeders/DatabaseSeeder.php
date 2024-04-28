<?php

namespace Database\Seeders;

use App\Models\PrintProcess;
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
        $this->call([
            PrintProcessSeeder::class,
            ProductCategorySeeder::class,
        ]);
    }
}
