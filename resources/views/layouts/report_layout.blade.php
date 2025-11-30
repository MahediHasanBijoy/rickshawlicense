<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">

    @yield('title')

    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap-datepicker.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="{{ asset('js/jquery/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap/bootstrap-datepicker.js') }}"></script>
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
    </style>
</head>   
<body class="print-container">
    
    <div class="mt-4">
        @yield('main_content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    
    
</body>
</html>