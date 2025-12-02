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
         $bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯','জানুয়ারি','ফেব্রুয়ারি','মার্চ','এপ্রিল','মে','জুন','জুলাই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর'];
         $en = ['0','1','2','3','4','5','6','7','8','9','January','February','March','April','May','June','July','August','September','October','November','December'];
        return str_replace($bn, $en, $number);
    }

    public static function en2bn($number)
    {
        $en = ['0','1','2','3','4','5','6','7','8','9','January','February','March','April','May','June','July','August','September','October','November','December'];
        $bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯','জানুয়ারি','ফেব্রুয়ারি','মার্চ','এপ্রিল','মে','জুন','জুলাই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর'];
        

        return str_replace($en, $bn, $number);
    }

    public static function compress($file, $path, $quality = 50)
    {
        $extension = strtolower($file->getClientOriginalExtension());

        $filename = time() . '_' . uniqid() . '.jpg';
        $fullPath = storage_path('app/public/' . $path . '/' . $filename);

        if ($extension === 'jpg' || $extension === 'jpeg') {
            $image = imagecreatefromjpeg($file);
        } elseif ($extension === 'png') {
            $image = imagecreatefrompng($file);
            imagepalettetotruecolor($image);
        } else {
            // PDF or unsupported → store original
            return $file->store($path, 'public');
        }

        imagejpeg($image, $fullPath, $quality);
        imagedestroy($image);

        return $path . '/' . $filename;
    }
}

