<?php

namespace Database\Seeders;

use App\Models\Associate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AssociateFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = Storage::disk('public')->path('associados_andigraf.json');
        $jsonString = file_get_contents($file);
        $jsonData = json_decode($jsonString, true);

        foreach ($jsonData as $registro) {
            $associate = new Associate();
            $associate->uuid = Str::uuid()->toString();
            $associate->document = (isset($registro['cnpj'])) ? preg_replace("/[^0-9]/", "", $registro['cnpj']) : "";
            $associate->corporate_name = (isset($registro['razao_social'])) ? ucwords(strtolower($registro['razao_social'])) : "";
            $associate->fantasy_name = (isset($registro['fantazia'])) ? ucwords(strtolower($registro['fantazia'])) : "";
            $associate->responsible_first_name = $registro['responsavel'] ?? "";
            $associate->phone = (isset($registro['telefone'])) ? preg_replace('/[^\x20-\x7E]/', '', trim(substr($registro['telefone'], 0, 14))) : "";
            $associate->email = $registro['email'] ?? "";
            $associate->address = $registro['endereco'] ?? "";
            $associate->district = $registro['bairro'] ?? "";
            $associate->city = $registro['municipio'] ?? "";
            $associate->state = (isset($registro['estado'])) ? substr($registro['estado'], 0, 2) : "";
            $associate->type = 'legal';
            $associate->origin = "manual";
            $associate->status = "incomplete";
            $associate->save();
        }
    }
}
