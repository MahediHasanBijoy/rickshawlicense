@extends('layouts.report_layout')
@php
    use App\Helpers\Helper;
@endphp
@Section('title')
    <title>ক্যাটাগরি ভিত্তিক আবেদন রিপোর্ট</title>
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
        

    </div>
    
    <div>
        <table class="table table-striped table-bordered mt-4">
            <thead>
                <tr>
                    <th>ক্রমিক নং</th>
                    <th>ক্যাটাগরির নাম</th>
                    <th>বিচারাধীন</th>
                    <th>নিশ্চিত</th>
                    <th>নির্বাচিত</th>
                    <th>অনুমোদিত</th>
                    <th>বাতিল</th>
                    <th>মোট আবেদন</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applicants as $key => $applicant)
                    <tr>
                        <td>{{ Helper::en2bn($key + 1) }}</td>
                        <td>{{ $applicant->category_name }}</td>
                        <td>{{ Helper::en2bn($applicant->pending_count) }}</td>
                        <td>{{ Helper::en2bn($applicant->confirmed_count) }}</td>
                        <td>{{ Helper::en2bn($applicant->selected_count) }}</td>
                        <td>{{ Helper::en2bn($applicant->approved_count) }}</td>
                        <td>{{ Helper::en2bn($applicant->rejected_count)}}</td>
                        <td>{{ Helper::en2bn($applicant->total_count)}}</td>
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