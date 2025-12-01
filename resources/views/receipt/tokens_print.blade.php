<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <title>আবেদন নাম্বার - প্রিন্ট</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">
    <style>
        @media print {
            @page {
                size: A4 portrait;
                margin: 10mm;
            }
        }

        .token-box {
            border: 2px dashed #333;
            min-height: 120px;
            white-space: nowrap;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        .col {
            page-break-inside: avoid;
            break-inside: avoid;
        }
        .token-number {
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 2px;
            font-family: 'Courier New', monospace;
        }
        .page-size{
            width: 210mm;
            height: 297mm;
            margin: 0px;
        }
    </style>
</head>
@php
    use App\Helpers\Helper;
@endphp
<body>
    <div class="text-center mb-4">
        <img src="{{ asset('images/logo.png') }}" alt="" srcset="">
        <h4>ঢাকা ক্যান্টনমেন্ট বোর্ড</h4>
        <h6> লটারি টোকেন প্রিন্ট</h6>
        
        <h6 class="text-decoration-underline">বছরঃ {{  Helper::en2bn($year) . 'ইং'}}</h6>
        
        
            <h6 class="text-decoration-underline">ক্যাটাগরিঃ {{ $category ?? 'সকল ক্যাটাগরি' }}</h6>
        

    </div>
        <div class="row row-cols-3 g-3">
            <!-- loop starts here -->
            @foreach ($applicants as $applicant)

            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number text-center">
                        <p style="margin-bottom:0px;">{{ Helper::en2bn($applicant->application_number) }}</p>
                        <p style="margin-bottom:0px;letter-spacing: 0px;font-size:13px;font-weight:500;word-break: normal;overflow-wrap: anywhere;
    white-space: normal;">{{ $applicant->applicant_name }}</p>
                    </div>

                </div>
            </div>
            <!-- loop ends here. remove rest blocks below. -->
            @endforeach

        </div>
    </div>
    <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script>
    <script>
        window.print();
        window.onafterprint = function () {
                window.close();
            };
    </script>
</body>
</html>