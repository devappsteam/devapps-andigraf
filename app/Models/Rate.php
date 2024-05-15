<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'award_id',
        'uuid',
        'min',
        'max',
        'price',
    ];

    public function award()
    {
        return $this->belongsTo(Award::class);
    }
}
