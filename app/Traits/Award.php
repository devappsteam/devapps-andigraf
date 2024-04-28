<?php

namespace App\Traits;

use App\Models\Award as ModelsAward;

trait Award
{
    static function active()
    {
        $award = ModelsAward::select('id')->where('status', 'enable')->first();
        if ($award) {
            return $award->id;
        }
        return null;
    }
}
