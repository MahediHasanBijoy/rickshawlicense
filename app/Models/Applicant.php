<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Applicant extends Model
{

    protected static function booted()
    {
        static::creating(function ($application) {
           
            $prefix = now()->format('Y') . '-';
            $lastapplication = self::where('application_number', 'like', $prefix . '%')->orderByDesc('application_number')->first();
            $number = $lastapplication
                ? ((int)substr($lastapplication->application_number, -4)) + 1
                : 1;
            $application->application_number = $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
            $application->applicaton_date = now()->format('Y-m-d');
        });
    }
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

     public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
