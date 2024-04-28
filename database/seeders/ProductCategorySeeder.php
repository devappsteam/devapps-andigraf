<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $current = Carbon::now();

        ProductCategory::insert([
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "01.01. - Livros de Texto",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "01.02. - Livros Culturais e de Arte",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "01.03. - Livros Ilustrados e Livros Técnicos",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "01.04. - Livros Institucionais",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "01.05. - Livros Infantis e Juvenis",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "01.06. - Guias, Manuais e Anuários",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "01.07. - Livros Didáticos",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "02.01. - Periódicos Informativos de Impressão Diária",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "02.02. - Jornais de Circulação não Diária",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "03.01. - Revistas Periódicas de Caráter Variado sem Recurso Gráficos Especiais",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "03.02. - Revistas Periódicas de Caráter Variado com Recurso Gráficos Especiais",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "03.03. - Revistas Infantis / Juvenis ou de desenhos",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "03.04. - Revistas Institucionais",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "04.01. - Rótulos Convencionais com e sem efeitos especiais",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "04.02. - Rótulos em autoadesivo sem efeitos especiais",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "04.03. - Rótulos em autoadesivo com efeitos especiais",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "04.04. - Etiquetas",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "05.01. - Embalagens semirrígidas sem efeitos gráficos",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "05.02. - Embalagens semirrígidas com efeitos gráficos especiais",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "05.03. - Embalagens de Microondulados com e sem efeitos especiais",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "05.04. - Embalagens Sazonais",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "05.05. - Sacolas",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "06.01. - Pôsteres e cartazes",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "06.02. - Catálogos promocionais e de arte sem efeitos especiais",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "06.03. - Catálogos promocionais e de arte com efeitos especiais",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "06.04. - Relatórios de empresas",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "06.05. - Folhetos publicitários",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "06.06. - Kits promocionais",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "06.07. - Displays, móbiles e materiais de ponto de venda de mesa ou de chão",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "06.08. - Calendários de Mesa e de Parede",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "07.01. - Convites",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "07.02. - Convites de Formatura",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "07.03. - Papelarias, certificados e diplomas",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "07.04. - Cartões de visita",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "07.05. - Agendas e Cadernos em Geral",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "07.06. - Cardápios",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "08.01. - Produtos Próprios / Kits Promocionais",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "08.02. - Produtos Próprios / Calendários",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "08.03. - Produtos Próprios / Impressos promocionais",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "08.04. - Produtos Próprios / Sacolas próprias",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "08.05. - Produtos Próprios / Cartões de Visitas e Papelarias",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "09.01. - Impressão Digital",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "09.02. - Impressão Digital em Grandes Formatos",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "09.03. - Impressão Digital em Pequenos e Médios Formatos",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "10.01. - Impressão Serigráfica",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "11.01. - Impressão Flexográfica",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "12.01. - Design gráfico",
                "created_at" => $current,
                "updated_at" => $current
            ],
            [
                "uuid" => Str::uuid()->toString(),
                "name" => "13.01. - Sustentabilidade ambiental",
                "created_at" => $current,
                "updated_at" => $current
            ],
        ]);
    }
}
