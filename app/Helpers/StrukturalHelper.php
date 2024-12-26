<?php

namespace App\Helpers;

use App\Models\Struktural;

class StrukturalHelper
{
    public static function getIdByStrukturalById($id)
    {
        $struktural = Struktural::where('id_struktural', $id)->first();
        return $struktural ? $struktural->id_struktural : null;
    }
}
