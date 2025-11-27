<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">

    <title>Rickshaw License</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap-datepicker.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="{{ asset('js/jquery/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap/bootstrap-datepicker.js') }}"></script>
    <style>
        .navbar-brand img {
            height: 60px;   /* Adjust logo size */
        }
        @media (max-width: 420px) {
            nav h5 {
                font-size: 30px !important;
            }
            .navbar-brand img {
                height: 45px!important;   /* Adjust logo size */
            }
        }
    </style>
</head>   
<body class="bg-warning bg-opacity-10">
    <nav class="navbar navbar-light bg-success shadow-sm py-2">
        <div class="container position-relative d-flex align-items-center">
        
        <!-- Logo (left) -->
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height:60px;">
        </a>

        <!-- Centered Heading -->
        <h5 class="m-0 fw-bold text-white position-absolute top-50 start-50 translate-middle w-100 text-center"
            style="font-size:40px;">
            ঢাকা ক্যান্টনমেন্ট বোর্ড
        </h5>
    </div>
    </nav>
    <div class="container mt-2">
        @yield('main_content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    
    
</body>
</html>