<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'award_id',
        'associate_id',
        'product_category_id',
        'name',
        'client',
        'conclude',
        'special_features',
        'substrate',
        'note',
    ];

    /**
     * Relationship between Product and Award Class
     */
    public function award()
    {
        return $this->belongsTo(Award::class);
    }

    /**
     * Relationship between Product and Associate Class
     */
    public function associate()
    {
        return $this->belongsTo(Associate::class);
    }

    /**
     * Relationship between Product and Category Class
     */
    public function categories()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }

    /**
     * Relationship between Print Processes and Product Class
     */
    public function print_processes()
    {
        return $this->belongsToMany(PrintProcess::class);
    }

    /**
     * Relationship between Enrollment and Product Class
     */
    public function enrollment()
    {
        return $this->belongsToMany(Enrollment::class);
    }
}
