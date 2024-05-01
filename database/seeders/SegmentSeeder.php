<?php

namespace Database\Seeders;

use App\Models\Segment;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SegmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $current = Carbon::now();

        Segment::insert([
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Livros",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Jornais",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Revistas",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Produtos para Identificação",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Acondicionamentos",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Promocional",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Comercial",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Produtos Próprios",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Impressão Digital e Sinalização",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Impressão Serigráfica",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Impressão Flexográfica",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Design Gráfico",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "Sustentabilidade Ambiental",
                "created_at" => $current,
                "updated_at" => $current
            ],
        ]);
    }
}
