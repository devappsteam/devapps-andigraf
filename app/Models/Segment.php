<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Segment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'description',
    ];

    public function categories()
    {
        return $this->hasMany(ProductCategory::class);
    }
}
