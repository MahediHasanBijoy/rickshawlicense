<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use function Symfony\Component\Clock\now;

class Payment extends Model
{
    protected static function booted()
    {
        static::creating(function ($payment) {
            if ($payment->fee_paid==='yes' && $payment->fee > 0) {
                $settings=ApplicationSetting::latest()->first();
                $applicant = Applicant::query()->where('id',$payment->applicant_id)->first();
                $prefix = 'INV-' . now()->format('Y') . '-';
                $lastpayment = self::where('invoice_no', 'like', $prefix . '%')->orderByDesc('invoice_no')->first();
                $number = $lastpayment
                    ? ((int)substr($lastpayment->invoice_no , -4)) + 1
                    : 1;
                $payment->invoice_no  = $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
                $payment->fee_date = now()->format('Y-m-d');
                $payment->yearly_fee =$applicant->category->category_slug=='special' ? 0 : $applicant->amount;
                $payment->security_payable = $settings->security_fee ?? 0;
                $payment->security_refundable = $settings->security_fee_refund ?? 0;
                $payment->yearly_fee_date = $applicant->order_date;
                $payment->fee_paid='paid';
                $payment->created_by = auth()->id();
                $payment->payment_date = now()->format('Y-m-d');
            }else{
               return false;
            }

        });

        static::created(function($payment){
            $applicant = Applicant::find($payment->applicant_id);
            $category = Category::find($applicant->category_id);
            if ($applicant &&  $applicant->status == 'pending' && $payment->fee_paid =='paid') {
                $applicant->status = $category->category_slug=='special' ? 'selected' : 'confirmed';
                $applicant->confirm_date = now()->format('Y-m-d');
                $applicant->confirmed_by  = auth()->id();
                $applicant->save();
                // $payment->fee_paid='paid';
                $payment->total_paid=($payment->fee_paid=='paid'  ? $payment->fee : 0 ) + $payment->security_fee + $payment->yearly_fee;
                $payment->saveQuietly();
            }
        });

        static::updated(function ($payment) {
            $payment->updated_by = auth()->id();
            $applicant = Applicant::query()->where('id',$payment->applicant_id)->first();
            $category = $applicant->category;
            if ($applicant &&  $applicant->status == 'pending' && $payment->fee_paid ==='yes') {
                $applicant->status = 'confirmed';
                $applicant->confirm_date = now()->format('Y-m-d');
                $applicant->confirmed_by  = auth()->id();
                $applicant->save();
                $payment->fee_paid='paid';
                $payment->fee_date = now()->format('Y-m-d');
                $payment->total_paid=($payment->fee_paid=='paid' ? $payment->fee : 0 ) + 
                $payment->getOriginal('security_fee') + $payment->getOriginal('yearly_fee');
                $payment->created_by = auth()->id();
                $payment->payment_date = now()->format('Y-m-d');
                $payment->saveQuietly();
            }
            if ($applicant &&  ($applicant->status == 'confirmed' || $applicant->status == 'selected' || $applicant->status == 'unselected') && $payment->fee_paid ==='no') {
                $applicant->status = 'pending';
                $applicant->confirm_date = null;
                $applicant->confirmed_by  = null;
                $applicant->save();
                $payment->deleteQuietly();
                // $payment->total_paid=0;
                // // $payment->fee_paid=='paid'  ? $payment->fee : 0 + 
                // // $payment->getOriginal('security_fee') + $payment->getOriginal('yearly_fee');
                // $payment->fee_date = now()->format('Y-m-d');
                // $payment->created_by = null;
                // // $payment->payment_date = null;
                // $payment->saveQuietly();
            }
            //Security update and calculation

           if ($applicant &&  $applicant->status == 'selected' && $payment->security_paid==='yes') {
                $payment->security_fee_by = auth()->id();
                $payment->security_fee_date = now()->format('Y-m-d');
                $payment->security_fee = $payment->security_payable;
                $payment->security_paid='paid';

                $yearly_fee=$category->category_slug=='special' ? $applicant->amount : $payment->getOriginal('yearly_fee');
                $payment->total_paid=($payment->security_paid=='paid'  ? $payment->security_fee : 0) + 
                $payment->getOriginal('fee') + $yearly_fee;
                $payment->yearly_fee=$category->category_slug=='special' ? $applicant->amount : $payment->getOriginal('yearly_fee');

                $payment->saveQuietly();
                 $applicant->status = 'approved';
                 $applicant->approved_by  = auth()->id();
                 $applicant->save();
            }
            if ($applicant &&  $applicant->status == 'approved' && $payment->security_paid==='no') {
                $payment->security_fee_by = null;
                $payment->security_fee_date = null;
                $payment->security_fee = 0;
                $payment->security_paid='no';

                $payment->total_paid=($payment->security_paid=='paid'  ? $payment->security_fee : 0) + 
                $payment->getOriginal('fee') + 
                ($category->category_slug=='special' ? 0 : $payment->getOriginal('yearly_fee'));
                $payment->yearly_fee=$category->category_slug=='special' ? 0 : $payment->getOriginal('yearly_fee');

                $payment->saveQuietly();
                $applicant->status = 'selected';
                $applicant->approved_by  = null;
                $applicant->save();
            }

            //yearly fee management
            if($applicant->status==='unselected' && $payment->is_yearly_fee_refund){
                $payment->yearly_fee_refund_date = now()->format('Y-m-d');
                $payment->yearly_fee_refund = $payment->yearly_fee;
                $payment->yearly_fee=0;

                $payment->total_paid=($payment->is_yearly_fee_refund==true  ? $payment->yearly_fee : 0) + 
                $payment->getOriginal('fee') + $payment->getOriginal('security_fee');

                $payment->yearly_fee_refund_by = auth()->id();
                $payment->saveQuietly();
                // $applicant->status = 'refunded';
                // $applicant->save();
            }
            if($applicant->status==='unselected' && !$payment->is_yearly_fee_refund){
                $payment->yearly_fee_refund_date = null;
                $payment->yearly_fee=$payment->yearly_fee_refund;
                $payment->yearly_fee_refund = 0;

                $payment->total_paid=($payment->is_yearly_fee_refund==false  ? $payment->yearly_fee : 0) + 
                $payment->getOriginal('fee') + $payment->getOriginal('security_fee');

                $payment->yearly_fee_refund_by = null;
                $payment->is_yearly_fee_refund=false;
                $payment->saveQuietly();
                $applicant->status = 'confirmed';
                $applicant->save();
            }
            if($applicant && $applicant->status==='approved' && $payment->is_security_refund){
                $payment->security_fee_refund=$payment->security_refundable;
                $payment->security_fee=$payment->security_fee-$payment->security_refundable;
                $payment->security_fee_refund_date=now()->format('Y-m-d');
                $payment->security_fee_refund_by =auth()->id();
                 $payment->saveQuietly();
            }

            if($applicant && $applicant->status==='approved' && !$payment->is_security_refund){
                $payment->security_fee=$payment->security_fee+$payment->security_fee_refund;
                $payment->security_fee_refund=0;
                $payment->security_fee_refund_date=null;
                $payment->security_fee_refund_by =null;
                $payment->saveQuietly();
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

    public function securityFeeRefundBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'security_fee_refund_by');
    }
    
    public function yearlyFeeRefundBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'yearly_fee_refund_by');
    }

}
