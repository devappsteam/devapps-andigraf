<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EnrollmentNote extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'enrollment_id',
        'note',
        'type',
    ];

    /**
     * Relationship between EnrollmentNote and Enrollment Class
     */
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}
