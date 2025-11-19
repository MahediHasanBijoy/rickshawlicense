<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected static function booted()
    {
        static::creating(function ($payment) {
            $applicant = Applicant::find($payment->applicant_id);
            $prefix = 'INV-' . now()->format('Y') . '-';
            $lastpayment = self::where('invoice_no', 'like', $prefix . '%')->orderByDesc('invoice_no')->first();
            $number = $lastpayment
                ? ((int)substr($lastpayment->invoice_no , -4)) + 1
                : 1;
            $payment->invoice_no  = $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
            $payment->fee_date = now()->format('Y-m-d');
            $payment->yearly_fee = $applicant->amount;
            $payment->yearly_fee_date = $applicant->order_date;
            $payment->created_by = auth()->id();
            $payment->payment_date = now()->format('Y-m-d');

        });

        static::saved(function ($payment) {
            $payment->updated_by = auth()->id();
            $applicant = Applicant::find($payment->applicant_id);
            if ($applicant &&  $applicant->status == 'pending') {
                $applicant->status = 'confirmed';
                $applicant->confirmed_by  = auth()->id();
                $applicant->save();
            }
           if ($applicant &&  $applicant->status == 'selected') {
                $payment->security_fee_by = auth()->id();
                $payment->security_fee_date = now()->format('Y-m-d');
                
                 $applicant->status = 'approved';
                 $applicant->approved_by  = auth()->id();
                 $applicant->save();
            }
        });
    }
    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function securityFeeBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'security_fee_by');
    }   

}
