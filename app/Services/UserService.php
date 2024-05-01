<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserService
{

    public function list(int $perpage = 15)
    {
        return User::whereNull('associate_id')->paginate($perpage);
    }

    public function all()
    {
        return User::whereNull('associate_id')->all();
    }

    public function get(string $uuid)
    {
        try {
            if (!Str::isUuid($uuid)) {
                abort(404, 'Código enviado é inválido.');
            }

            if (!$user = User::where('uuid', $uuid)->first()) {
                abort(404, 'Registro não encontrado.');
            }
            return $user;
        } catch (Exception $ex) {
            Log::error('Falha ao buscar usuário.', array(
                'error' => $ex->getMessage(),
                'uuid' => $uuid
            ));
            return null;
        }
    }

    public function store(array $data): bool
    {
        try {
            $user = new User();
            $user->uuid = Str::uuid()->toString();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->save();
            return true;
        } catch (Exception $ex) {
            Log::error('Falha ao cadastrar usuário.', array(
                'error' => $ex->getMessage(),
                'payload' => $data
            ));
            return false;
        }
    }

    public function update(string $uuid, array $data): bool
    {
        try {
            $user = $this->get($uuid);
            $user->name = $data['name'];
            $user->email = $data['email'];
            if (isset($data['password']) && !empty($data['password'])) {
                $user->password = Hash::make($data['password']);
            }
            $user->save();
            return true;
        } catch (Exception $ex) {
            Log::error('Falha ao atualizar usuário.', array(
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
            $user = $this->get($uuid);
            $user->delete();
            return true;
        } catch (Exception $ex) {
            Log::error('Falha ao atualizar user.', array(
                'error' => $ex->getMessage(),
                'uuid' => $uuid
            ));
            return false;
        }
    }
}
