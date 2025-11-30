<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <title>রশিদ - প্রিন্ট</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">
    <style>
        @page {
            size: A4;
            margin: 15mm;
        }

        body {
            font-family: 'Kalpurush', 'SolaimanLipi', Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #000;
            background: #fff;
        }

        .print-container {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 15mm;
            background: white;
            position: relative;
        }

        .header-info {
            text-align: left;
            font-size: 10pt;
            margin-bottom: 10px;
            line-height: 1.3;
            position:absolute;
        }

        .form-header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }

        .form-header h4 {
            font-size: 16pt;
            font-weight: bold;
            margin: 5px 0;
        }

        .form-header h5 {
            font-size: 14pt;
            font-weight: 600;
            margin: 3px 0;
        }

        .form-header p {
            font-size: 11pt;
            margin: 2px 0;
        }

        .info-row {
            display: flex;
            margin-bottom: 12px;
            align-items: baseline;
            page-break-inside: avoid;
        }

        .info-label {
            min-width: 100px;
            font-weight: 600;
            flex-shrink: 0;
        }

        .info-value {
            flex: 1;
            border-bottom: 1px dotted #333;
            min-height: 22px;
            padding: 2px 5px;
        }

        .section-title {
            font-weight: bold;
            font-size: 12pt;
            margin: 25px 0 15px 0;
            padding: 8px;
            background: #f0f0f0;
            border-left: 4px solid #333;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            page-break-inside: auto;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        .data-table th {
            background-color: #e9ecef;
            font-weight: bold;
            text-align: center;
            font-size: 11pt;
        }

        .data-table td {
            font-size: 10pt;
        }

        .data-table tr {
            page-break-inside: avoid;
        }

        .photo-box {
            width: 120px;
            height: 140px;
            border: 2px solid #000;
            display: inline-block;
            text-align: center;
            line-height: 140px;
            background: #f8f9fa;
            position: absolute;
            top: 15mm;
            right: 20mm;
        }

        .photo-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }

        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
        }

        .signature-box {
            text-align: center;
        }

        .signature-line {
            width: 200px;
            border-top: 1px solid #000;
            margin-top: 60px;
            display: inline-block;
        }

        .declaration {
            margin-top: 25px;
            padding: 15px;
            border: 1px solid #ddd;
            background: #f8f9fa;
            font-size: 10pt;
            page-break-inside: avoid;
        }
        .header-qr{
            margin-bottom: 10px;
            line-height: 1.3;
            position: absolute;
            right:50px;
        }
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            
            .print-container {
                width: 100%;
                margin: 0;
                padding: 10mm;
            }

            .no-print {
                display: none !important;
            }

            @page {
                margin: 0;
            }

            .page-break {
                page-break-after: always;
            }
        }

        @media screen {
            .print-container {
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
                margin: 20px auto;
            }
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        @media print {
            .section-title, .data-table th {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                background: #f0f0f0 !important;
                -webkit-print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body>
    <div class="print-container">
        <!-- Photo Box (Top Right) -->
        <!-- <div class="photo-box no-print" style="line-height: normal; padding: 5px;">
            {{-- Uncomment and use when you have the image --}}
            @if($applicant->applicant_image)
                <img src="{{ asset('storage/' . $applicant->applicant_image) }}" alt="Photo">
            @else 
                <small style="display: block; margin-top: 50px;">ছবি</small>
            @endif
        </div> -->

        <!-- Header Information -->
        <div class="header-info">
            <img src="{{ asset('images/logo.png') }}" alt="Photo" style="max-height:70px;">
        </div>

        <!-- QR code Image -->
        <div class="header-qr">
            <img src="{{ $qrImage }}" alt="QR code" style="max-height:70px;">
        </div>

        <!-- Form Header -->
        <div class="form-header">
            <h4>ক্যান্টনমেন্ট বোর্ড</h4>
            <h5>ঢাকা ক্যান্টনমেন্ট, ঢাকা</h5>
            <p>রশিদ কপি</p>
        </div>

        

        <!-- Application Number and Date -->
        <div class="info-row">
            <span class="info-label">আবেদন নম্বর:</span>
            <span class="info-value">
                {{ bn_number($applicant->application_number) ?? '' }} 
            </span>
            <span class="info-label">আবেদনের তারিখ:</span>
            <span class="info-value">
                 {{ bn_number(\Carbon\Carbon::parse($applicant->created_at)->format('d/m/Y')) }} (দিন/মাস/বছর) 
            </span>
        </div>

        <!-- Section 1: Personal Information -->
        {{-- <div class="section-title">০১. ব্যক্তিগত তথ্য (Personal Information)</div> --}}
        <div class="info-row">
            <span class="info-label">আবেদনকারীর নাম:</span>
            <span class="info-value">
                {{ $applicant->applicant_name ?? '' }} 
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">বর্তমান ঠিকানা:</span>
            <span class="info-value">
                {{ $applicant->present_address ?? '' }} 
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">মোবাইল:</span>
            <span class="info-value">
                {{ $applicant->phone ? bn_number($applicant->phone) : '' }} 
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">রুট:</span>
            <span class="info-value">
                {{ $applicant->area->area_name ?? '' }} 
            </span>
        </div>

        <div class="info-row">
            <span class="info-label">ক্যাটাগরি:</span>
            <span class="info-value">
                 {{ $applicant->category->category_name ?? '' }} 
            </span>
        </div>
        @if ($applicant->license_number)
        <div class="info-row">
            <span class="info-label">লাইসেন্স নাম্বার:</span>
            <span class="info-value">
                {{ bn_number($applicant->license_number)  }} 
            </span>
            <span class="info-label" style="min-width: 50px;margin-left: 50px;">মেয়াদ:</span>
            <span class="info-value">
                {{ bn_number($applicant->expire_date)  }} ইং
            </span>
        </div>
        @endif


        

        {{-- <div class="info-row">
            <span class="info-label">পিতা/স্বামীর নাম:</span>
            <span class="info-value">
                {{ $applicant->guardian_name ?? '' }}
            </span>
        </div>

        

        <div class="info-row">
            <span class="info-label">স্থায়ী ঠিকানা:</span>
            <span class="info-value">
                {{ $applicant->permanent_address ?? '' }} 
            </span>
        </div>

        <div class="info-row">
            <span class="info-label">এন আইডি নং:</span>
            <span class="info-value">
                {{ $applicant->nid_no ? bn_number($applicant->nid_no): '' }} 
            </span>
        </div>

        <div class="info-row">
            <span class="info-label">ইমেইল:</span>
            <span class="info-value">
                {{ $applicant->email ?? '' }}
            </span>
        </div> --}}

        

        <!-- Section 2: Pay Order Information -->
        <div class="section-title">০১. পে অর্ডারের বিবরন (Pay Order Information)</div>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 25%;">ব্যাংকের নাম</th>
                    <th style="width: 25%;">পে অর্ডার নং</th>
                    <th style="width: 25%;">তারিখ</th>
                    <th style="width: 25%;">পরিমান</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">
                         {{ $applicant->bank_name ?? '' }} 
                        
                    </td>
                    <td class="text-center">
                         {{ $applicant->pay_order_no ?? '' }}
                    </td>
                    <td class="text-center">{{ $applicant->order_date ? bn_number(\Carbon\Carbon::parse($applicant->order_date)->format('d/m/Y')) : '' }}</td>
                    <td class="text-center">
                         {{ bn_number($applicant->amount) ?? '' }}/= 
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="section-title">০২. আবেদন ফি প্রদানের বিবরন (Application Fee Information)</div>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 25%;">ব্যাংকের নাম</th>
                    <th style="width: 25%;">রশিদ নং</th>
                    <th style="width: 25%;">তারিখ</th>
                    <th style="width: 25%;">পরিমান</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">
                          অফিস
                        
                    </td>
                    <td class="text-center">
                         {{ $applicant->payment->invoice_no ?? '' }}
                    </td>
                    <td class="text-center">{{ $applicant->order_date ? bn_number(\Carbon\Carbon::parse($applicant->payment->fee_date )->format('d/m/Y')) : '' }}</td>
                    <td class="text-center">
                         {{ bn_number($applicant->payment->fee ?? '') }} /=
                    </td>
                </tr>
            </tbody>
        </table>
        @if ($applicant->payment->security_fee > 0)
        <div class="section-title">০৩. সিকিউরিটি ফি প্রদানের বিবরন (Security Fee Information)</div>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 25%;">ব্যাংকের নাম</th>
                    <th style="width: 25%;">রশিদ নং</th>
                    <th style="width: 25%;">তারিখ</th>
                    <th style="width: 25%;">পরিমান</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">
                          অফিস
                        
                    </td>
                    <td class="text-center">
                         {{ $applicant->payment->invoice_no ?? '' }}
                    </td>
                    <td class="text-center">{{ $applicant->payment->security_fee_date ? bn_number(\Carbon\Carbon::parse($applicant->payment->security_fee_date )->format('d/m/Y')) : '' }}</td>
                    <td class="text-center">
                         {{ bn_number($applicant->payment->security_fee ?? '') }} /=
                    </td>
                </tr>
            </tbody>
        </table>
        @endif
        @if($applicant->payment->is_yearly_fee_refund || $applicant->payment->is_security_refund)
        <div class="section-title">০৪. জামানত ফেরতের  বিবরন (Refund Information)</div>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 25%;">বিষয়</th>
                    <th style="width: 25%;">রশিদ নং</th>
                    <th style="width: 25%;">তারিখ</th>
                    <th style="width: 25%;">পরিমান</th>
                </tr>
            </thead>
            <tbody>
                @if ($applicant->payment->is_security_refund)
                <tr>
                    <td class="text-center">
                        সিকিউরিটি ফি ফেরত  
                    </td>
                    <td class="text-center">
                         {{ $applicant->payment->invoice_no ?? '' }}
                    </td>
                    <td class="text-center">{{ $applicant->payment->security_fee_refund_date ? bn_number(\Carbon\Carbon::parse($applicant->payment->security_fee_refund_date )->format('d/m/Y')) : '' }}</td>
                    <td class="text-center">
                         {{ bn_number($applicant->payment->security_fee_refund ?? '') }} /=
                    </td>
                </tr>
                @elseif ( $applicant->payment->is_yearly_fee_refund)
                <tr>
                    <td class="text-center">
                        বার্ষিক ফি ফেরত  
                    </td>
                    <td class="text-center">
                         {{ $applicant->payment->invoice_no ?? '' }}
                    </td>
                    <td class="text-center">{{ $applicant->payment->yearly_fee_refund_date ? bn_number(\Carbon\Carbon::parse($applicant->payment->yearly_fee_refund_date )->format('d/m/Y')) : '' }}</td>
                    <td class="text-center">
                         {{ bn_number($applicant->payment->yearly_fee_refund ?? '') }} /=
                    </td>
                </tr>
                @endif
                
            </tbody>
        </table>

@endif
        {{-- <div class="info-row">
            <span class="info-label">পরিশোধের তারিখ:</span>
            <span class="info-value">
                {{ $applicant->order_date ? bn_number(\Carbon\Carbon::parse($applicant->order_date)->format('d/m/Y')) : '' }}
            </span>
        </div> --}}

        <!-- Declaration Section -->
        {{-- <div class="declaration">
            <p><strong>ঘোষণা:</strong></p>
            <p style="margin-top: 10px;">
                আমি এই মর্মে ঘোষণা করছি যে, উপরোক্ত সকল তথ্য সঠিক এবং সত্য। কোন তথ্য মিথ্যা প্রমাণিত হলে 
                আমার আবেদন বাতিল করা যাবে এবং আমি এর জন্য দায়ী থাকব।
            </p>
        </div> --}}

        <!-- Signature Section -->
        <!-- <div class="signature-section">
            <div class="signature-box">
                <div>
                    {{-- @if($applicant->signature_image)
                        <img src="{{ asset('storage/' . $applicant->signature_image) }}" style="max-width: 150px; max-height: 50px;">
                    @endif --}}
                </div>
                <div class="signature-line"></div>
                <div style="margin-top: 10px;">আবেদনকারীর স্বাক্ষর</div>
                <div style="font-size: 9pt; margin-top: 5px;">
                    তারিখ: {{ '___/___/______' }}
                </div>
            </div>

            <div class="signature-box">
                <div class="signature-line"></div>
                <div style="margin-top: 10px;">কর্তৃপক্ষের স্বাক্ষর</div>
                <div style="font-size: 9pt; margin-top: 5px;">
                    তারিখ: {{ '___/___/______' }}
                </div>
            </div>
        </div> -->
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