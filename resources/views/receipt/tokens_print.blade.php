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
<body>
    <div class="container-fluid p-4 page-size">
        <div class="row row-cols-3 g-3">
            <!-- loop starts here -->
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0001</div>
                </div>
            </div>
            <!-- loop ends here. remove rest blocks below. -->
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0002</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0003</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0004</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0002</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0003</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0004</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0002</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0003</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0004</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0002</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0003</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0004</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0002</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0003</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0004</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0002</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0003</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0004</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0002</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0003</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0004</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0002</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0003</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0004</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0002</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0003</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0004</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0002</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0003</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0004</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0002</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0003</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0004</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0002</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0003</div>
                </div>
            </div>
            <div class="col">
                <div class="token-box d-flex align-items-center justify-content-center p-3">
                    <div class="token-number">2025-0004</div>
                </div>
            </div>
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