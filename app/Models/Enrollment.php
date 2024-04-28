<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enrollment extends Model
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
        'payment_type',
        'status',
    ];

    /**
     * Relationship between Enrollment and Award Class
     */
    public function award()
    {
        return $this->belongsTo(Award::class);
    }

    /**
     * Relationship between Enrollment and Associate Class
     */
    public function associate()
    {
        return $this->belongsTo(Associate::class);
    }

    /**
     * Relationship between Enrollment and Category Class
     */
    public function notes()
    {
        return $this->hasMany(EnrollmentNote::class);
    }

    /**
     * Relationship between Enrollment and Product Class
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
