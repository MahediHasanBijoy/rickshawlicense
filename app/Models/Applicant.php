<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

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
            $application->applicant_year = now()->year;
        });
        // static::created(function($application){
        //         $settings=ApplicationSetting::latest()->first();
        //         // $applicant = Applicant::find($payment->applicant_id);
        //         $prefix = 'INV-' . now()->format('Y') . '-';
        //         $lastpayment = Payment::where('invoice_no', 'like', $prefix . '%')->orderByDesc('invoice_no')->first();
        //         $number = $lastpayment
        //             ? ((int)substr($lastpayment->invoice_no , -4)) + 1
        //             : 1;
        //      $application->payment()->create([
        //         'invoice_no'         => $prefix . str_pad($number, 4, '0', STR_PAD_LEFT),
        //         'fee'               =>$settings->application_fee,
        //         'yearly_fee'         => $application->amount ?? 0,
        //         'security_payable'   => $settings->security_fee ?? 0,
        //         'security_refundable'=> $settings->security_fee_refund ?? 0,
        //         'yearly_fee_date'    => $application->order_date,
        //         // 'fee_date' => now()->format('Y-m-d'),
        //         // 'fee_paid' => 'paid',
        //         // 'created_by' => auth()->id(),
        //          'payment_date' => now()->format('Y-m-d'),
        //     ]);

        // });

         static::updated(function ($application) {

            if ($application->isDirty('status') && $application->status === 'approved') {

                $area = Area::find($application->area_id);
                $digits = strlen($area->end_number);

                // ===== LICENSE NUMBER GENERATION =====
                $last = self::where('area_id', $area->id)
                    ->whereNotNull('license_number')
                    ->max(DB::raw("CAST(license_number AS UNSIGNED)"));

                $next = $last ? $last + 1 : $area->start_number;
                $licenseNumber = str_pad($next, $digits, '0', STR_PAD_LEFT);

                // ===== EXPIRE DATE LOGIC =====
                $currentYear = now()->year;
                $currentMonth = now()->month;

                if ($currentMonth == 1) {
                    // January → expire this year
                    $expireYear = $currentYear;
                } else {
                    // February to December → expire next year
                    $expireYear = $currentYear + 1;
                }

                $expireDate = $expireYear . '-12-31';

                // SAVE
                $application->updateQuietly([
                    'license_number' => $licenseNumber,
                    'expire_date'    => $expireDate,
                ]);
            }
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
