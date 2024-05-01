<?php

namespace App\Services;

use App\Models\Segment;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SegmentService
{

    public function list(int $perpage = 15)
    {
        return Segment::paginate($perpage);
    }

    public function all()
    {
        return Segment::all();
    }

    public function get(string $uuid)
    {
        try {
            if (!Str::isUuid($uuid)) {
                abort(404, 'Código enviado é inválido.');
            }

            if (!$Segment = Segment::where('uuid', $uuid)->first()) {
                abort(404, 'Registro não encontrado.');
            }
            return $Segment;
        } catch (Exception $ex) {
            Log::error('Falha ao buscar segmento.', array(
                'error' => $ex->getMessage(),
                'uuid' => $uuid
            ));
            return null;
        }
    }

    public function store(array $data): bool
    {
        try {
            $Segment = new Segment();
            $Segment->uuid = Str::uuid()->toString();
            $Segment->name = $data['name'];
            $Segment->description = $data['description'];
            $Segment->save();
            return true;
        } catch (Exception $ex) {
            Log::error('Falha ao cadastrar segmento.', array(
                'error' => $ex->getMessage(),
                'payload' => $data
            ));
            return false;
        }
    }

    public function update(string $uuid, array $data): bool
    {
        try {
            $Segment = $this->get($uuid);
            $Segment->name = $data['name'];
            $Segment->description = $data['description'];
            $Segment->save();
            return true;
        } catch (Exception $ex) {
            Log::error('Falha ao atualizar segmento.', array(
                'error' => $ex->getMessage(),
                'payload' => $data,
                'uuid' => $uuid
            ));
            return false;
        }
    }

    public function delete(string $uuid): bool
    {
        try {
            $Segment = $this->get($uuid);
            $Segment->delete();
            return true;
        } catch (Exception $ex) {
            Log::error('Falha ao atualizar segmento.', array(
                'error' => $ex->getMessage(),
                'uuid' => $uuid
            ));
            return false;
        }
    }
}
