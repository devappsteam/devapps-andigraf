<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'segment_id',
        'uuid',
        'name',
        'description',
    ];


    /**
     * Relationship between Product and Category Class
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function segment()
    {
        return $this->belongsTo(Segment::class);
    }
}
