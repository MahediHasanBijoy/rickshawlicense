<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Applicant extends Model
{

    protected $fillable = [
        'area_id', 'category_id',
        'applicant_name', 'guardian_name',
        'present_address', 'permanent_address',
        'nid_no', 'email', 'phone',
        'bank_name', 'pay_order_no', 'amount', 'order_date',
        'applicant_image', 'signature_image', 'nid_image', 'py_order_image',
    ];
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
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
