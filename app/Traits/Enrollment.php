<?php

namespace App\Traits;

use App\Models\Enrollment as ModelsEnrollment;

trait Enrollment
{
    static function calcTotalPayment(ModelsEnrollment $enrollment): float
    {
        $total_products = $enrollment->products_count;
        $rates =  $enrollment->award->rates ?? collect();

        if ($rates->isEmpty()) {
            return 0;
        }

        $total = $rates->first(function ($item) use ($total_products) {
            return $total_products >= $item['min'] && $total_products <= $item['max'];
        })['price'] ?? null;

        if ($total === null) {
            $total = $rates->first()['price'] * $total_products ?? null;
        }

        return $total;
    }
}
