@extends('layouts.report_layout')
@php
    use App\Helpers\Helper;
@endphp
@Section('title')
    <title>সামারি রিপোর্ট</title>
@endSection
@php
    use Rakibhstu\Banglanumber\NumberToBangla;
    $numto = new NumberToBangla();
@endphp
@Section('main_content')
    <div class="text-center">
        <img src="{{ asset('images/logo.png') }}" alt="" srcset="">
        <h4>ঢাকা ক্যান্টনমেন্ট বোর্ড</h4>
        <h6> সামারি রিপোর্ট</h6>
        @if ($year)
        <h6 class="text-decoration-underline">বছরঃ {{  Helper::en2bn($year) . 'ইং'}}</h6>
            
        @endif
        @if ($area)
            <h6 class="text-decoration-underline">এরিয়াঃ {{ $area }}</h6>
        @endif
        @if ($category)
            <h6 class="text-decoration-underline">ক্যাটাগরিঃ {{ $category }}</h6>
        @endif

    </div>
    <div>
        <table class="table table-striped table-bordered mt-4">
            <thead>
                <tr class="text-center align-middle">
                    <th rowspan="2">ক্রমিক নং</th>
                    <th rowspan="2">আবেদন নং</th>
                    <th rowspan="2">নাম</th>
                    <th rowspan="2">আবেদন ফি</th>
                    <th colspan="2">বার্ষিক ফি</th>
                    <th colspan="2">সিকিউরিটি ফি</th>
                    <th rowspan="2">মোট</th>
                </tr>
                <tr class="text-center">
                    <th>জমা</th>
                    <th>ফেরত</th>

                    <th>জমা</th>
                    <th>ফেরত</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $key => $payment)
                    <tr class="text-center">
                        <td>{{ Helper::en2bn($key + 1) }}</td>
                        <td>{{ Helper::en2bn($payment->applicant->application_number )}}</td>
                        <td>{{ $payment->applicant->applicant_name }}</td>
                        <td>{{ $numto->bnCommaLakh($payment->fee) }}</td>

                        <td>{{ $numto->bnCommaLakh($payment->yearly_fee) }}</td>
                        <td>{{ $numto->bnCommaLakh($payment->yearly_fee_refund) }}</td>

                        <td>{{ $numto->bnCommaLakh($payment->security_fee) }}</td>
                        <td>{{ $numto->bnCommaLakh($payment->security_fee_refund) }}</td>
                        <td>{{ $numto->bnCommaLakh($payment->total_paid) }}</td>
                        
                        {{-- <td>{{ Helper::en2bn(date('d-m-Y', strtotime($applicant->applicaton_date))) }}</td>
                        <td>{{$applicant->status }}</td> --}}
                    </tr>
                @endforeach
                <tr class="text-center">
                    <td colspan="3">মোট</td>
                    <td>{{ $numto->bnCommaLakh($payments->sum('fee')) }}</td>
                    <td>{{ $numto->bnCommaLakh($payments->sum('yearly_fee')) }}</td>
                    <td>{{ $numto->bnCommaLakh($payments->sum('yearly_fee_refund')) }}</td>
                    <td>{{ $numto->bnCommaLakh($payments->sum('security_fee')) }}</td>
                    <td>{{ $numto->bnCommaLakh($payments->sum('security_fee_refund')) }}</td>
                    <td>{{ $numto->bnCommaLakh($payments->sum('total_paid')) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <script>
        window.print();
        window.onafterprint = function () {
                window.close();
            };
    </script>
@endSection