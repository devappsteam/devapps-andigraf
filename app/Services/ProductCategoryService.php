<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductCategory;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductCategoryService
{

    public function list(int $perpage = 10)
    {
        return ProductCategory::paginate($perpage);
    }

    public function get(string $uuid)
    {
        try {
            if (!Str::isUuid($uuid)) {
                abort(404, 'Código enviado é inválido.');
            }

            if (!$productCategory = ProductCategory::where('uuid', $uuid)->first()) {
                abort(404, 'Registro não encontrado.');
            }
            return $productCategory;
        } catch (Exception $ex) {
            Log::error('Falha ao buscar categoria do produto.', array(
                'error' => $ex->getMessage(),
                'uuid' => $uuid
            ));
            return null;
        }
    }

    public function store(array $data): bool
    {
        try {
            $productCategory = new ProductCategory();
            $productCategory->uuid = Str::uuid()->toString();
            $productCategory->name = $data['name'];
            $productCategory->description = $data['description'];
            $productCategory->save();
            return true;
        } catch (Exception $ex) {
            Log::error('Falha ao cadastrar categoria do produto.', array(
                'error' => $ex->getMessage(),
                'payload' => $data
            ));
            return false;
        }
    }

    public function update(string $uuid, array $data): bool
    {
        try {
            $productCategory = $this->get($uuid);
            $productCategory->name = $data['name'];
            $productCategory->description = $data['description'];
            $productCategory->save();
            return true;
        } catch (Exception $ex) {
            Log::error('Falha ao atualizar categoria do produto.', array(
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
            $productCategory = $this->get($uuid);
            $productCategory->delete();
            return true;
        } catch (Exception $ex) {
            Log::error('Falha ao atualizar categoria do produto.', array(
                'error' => $ex->getMessage(),
                'uuid' => $uuid
            ));
            return false;
        }
    }
}
