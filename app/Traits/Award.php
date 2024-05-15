<?php

namespace App\Traits;

use App\Models\Award as ModelsAward;

trait Award
{
    static function active($return_id = true)
    {
        $award = ModelsAward::where('status', 'enable')->first();
        if ($return_id) {
            return $award->id;
        }
        return $award;
    }
}
