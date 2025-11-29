@extends('layouts.report_layout')
@php
    use App\Helpers\Helper;
@endphp
@Section('title')
    <title>আবেদন রিপোর্ট</title>
@endSection
@Section('main_content')
    <div class="text-center">
        <img src="{{ asset('images/logo.png') }}" alt="" srcset="">
        <h4>ঢাকা ক্যান্টনমেন্ট বোর্ড</h4>
        <h6> আবেদন রিপোর্ট</h6>
        @if ($year)
        <h6 class="text-decoration-underline">{{  Helper::en2bn($year) . 'ইং'}}</h6>
            
        @endif
        @if ($area)
            <h6 class="text-decoration-underline">এরিয়াঃ {{ $area }}</h6>
        @endif
        @if ($category)
            <h6 class="text-decoration-underline">ক্যাটাগরিঃ {{ $category }}</h6>
        @endif
        @if ($application_status)
            <h6 class="text-decoration-underline">স্ট্যাটাসঃ {{ $application_status }}</h6>
        @endif

    </div>
    <div>
        <table class="table table-striped table-bordered mt-4">
            <thead>
                <tr>
                    <th>ক্রমিক নং</th>
                    <th>আবেদনকারীর নাম</th>
                    <th>এলাকা</th>
                    <th>ক্যাটাগরি</th>
                    <th>আবেদনের তারিখ</th>
                    <th>স্ট্যাটাস</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applicants as $key => $applicant)
                    <tr>
                        <td>{{ Helper::en2bn($key + 1) }}</td>
                        <td>{{ $applicant->applicant_name }}</td>
                        <td>{{ $applicant->area->area_name }}</td>
                        <td>{{ $applicant->category->category_name }}</td>
                        
                        <td>{{ Helper::en2bn(date('d-m-Y', strtotime($applicant->applicaton_date))) }}</td>
                        <td>{{$applicant->status }}</td>
                    </tr>
                @endforeach
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