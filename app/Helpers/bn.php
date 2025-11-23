<?php

function bn_number($number)
{
    $en = ['0','1','2','3','4','5','6','7','8','9'];
    $bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];

    return str_replace($en, $bn, $number);
}