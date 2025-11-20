<?php

namespace App\Helpers;

class Helper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function bn2en($number)
    {
        $bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
        $en = ['0','1','2','3','4','5','6','7','8','9'];

        return str_replace($bn, $en, $number);
    }

    public static function en2bn($number)
    {
        $en = ['0','1','2','3','4','5','6','7','8','9'];
        $bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
        

        return str_replace($en, $bn, $number);
    }
}

