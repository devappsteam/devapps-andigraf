<?php

namespace App\Observers;

use App\Models\Enrollment;
use App\Traits\Enrollment as EnrollmentTrait;

class EnrollmentObserver
{
    public $afterCommit = true;


    public function saved(Enrollment $enrollment)
    {
        $enrollment->load('award.rates')->loadCount('products');
        $enrollment->total = EnrollmentTrait::calcTotalPayment($enrollment);
        $enrollment->saveQuietly();
    }
}
