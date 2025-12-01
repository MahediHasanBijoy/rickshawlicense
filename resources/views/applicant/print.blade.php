<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <title>আবেদনপত্র - প্রিন্ট</title>
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
            position: relative; /* for watermark */
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 15mm;
            background: white;
            position: relative;
        }
        /* for watermark */
        .print-container::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50%; /* Adjust size as needed */
            height: 50%; /* Adjust size as needed */
            background-image: url('{{ asset("images/rickshaw.png") }}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            opacity: 0.1; /* Adjust transparency (0.1 = 10% visible) */
            z-index: 0;
            pointer-events: none;
        }
        .print-container > * {
            position: relative;
            z-index: 1;
        }
        @media print {
            .print-container::before {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
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
            min-width: 180px;
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
            <p>রিক্সার লাইসেন্সের জন্য আবেদন পত্র</p>
        </div>

        

        <!-- Application Number and Date -->
        <div class="info-row">
            <span class="info-label">আবেদন নম্বর:</span>
            <span class="info-value">
                {{ bn_number($applicant->application_number) ?? '' }} 
            </span>
        </div>

        <div class="info-row">
            <span class="info-label">আবেদনের তারিখ:</span>
            <span class="info-value">
                 {{ bn_number(\Carbon\Carbon::parse($applicant->created_at)->format('d/m/Y')) }} (দিন/মাস/বছর) 
            </span>
        </div>

        <!-- Section 1: Personal Information -->
        <div class="section-title">০১. ব্যক্তিগত তথ্য (Personal Information)</div>

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

        <div class="info-row">
            <span class="info-label">আবেদনকারীর নাম:</span>
            <span class="info-value">
                {{ $applicant->applicant_name ?? '' }} 
            </span>
        </div>

        <div class="info-row">
            <span class="info-label">পিতা/স্বামীর নাম:</span>
            <span class="info-value">
                {{ $applicant->guardian_name ?? '' }}
            </span>
        </div>

        <div class="info-row">
            <span class="info-label">বর্তমান ঠিকানা:</span>
            <span class="info-value">
                {{ $applicant->present_address ?? '' }} 
            </span>
        </div>

        <div class="info-row">
            <span class="info-label">স্থায়ী ঠিকানা:</span>
            <span class="info-value">
                {{ $applicant->permanent_address ?? '' }} 
            </span>
        </div>

        <div class="info-row">
            <span class="info-label">এন আইডি/জন্মনিবন্ধন নং:</span>
            <span class="info-value">
                {{ $applicant->nid_no ? bn_number($applicant->nid_no): '' }} 
            </span>
        </div>

        <div class="info-row">
            <span class="info-label">ইমেইল:</span>
            <span class="info-value">
                {{ $applicant->email ?? '' }}
            </span>
        </div>

        <div class="info-row">
            <span class="info-label">মোবাইল:</span>
            <span class="info-value">
                {{ $applicant->phone ? bn_number($applicant->phone) : '' }} 
            </span>
        </div>

        <!-- Section 2: Pay Order Information -->
        <div class="section-title">০২. পে অর্ডারের বিবরণ (Pay Order Information)</div>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 33%;">ব্যাংকের নাম</th>
                    <th style="width: 33%;">পে অর্ডার নং</th>
                    <th style="width: 34%;">পরিমান</th>
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
                    <td class="text-center">
                         {{ bn_number($applicant->amount ?? '') }}/=
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="info-row">
            <span class="info-label">পরিশোধের তারিখ:</span>
            <span class="info-value">
                {{ $applicant->order_date ? bn_number(\Carbon\Carbon::parse($applicant->order_date)->format('d/m/Y')) : '' }}
            </span>
        </div>

        <!-- Declaration Section -->
        <div class="declaration">
            <p><strong>ঘোষণা:</strong></p>
            <p style="margin-top: 10px;">
                আমি এই মর্মে ঘোষণা করছি যে, উপরোক্ত সকল তথ্য সঠিক এবং সত্য। কোন তথ্য মিথ্যা প্রমাণিত হলে 
                আমার আবেদন বাতিল করা যাবে এবং আমি এর জন্য দায়ী থাকব।
            </p>
        </div>

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