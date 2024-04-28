<?php

namespace Database\Seeders;

use App\Models\PrintProcess;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PrintProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $current = Carbon::now();

        PrintProcess::insert([
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Impressão Digital",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Impressão Rotativa Heatset",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Flexografia",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Acabamento Editorial",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Impressão Offset Plana",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Impressão Rotativa Coldset",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Serigrafia",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Acabamento Cartotécnico",
                "created_at" => $current,
                "updated_at" => $current
            ],
        ]);
    }
}
