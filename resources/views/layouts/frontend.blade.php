<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">

    <title>Rickshaw License</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        .navbar-brand img {
            height: 70px;   /* Adjust logo size */
        }
    </style>
</head>   
<body class="bg-warning bg-opacity-10">
    <nav class="navbar navbar-light bg-success shadow-sm py-2">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
            </a>
            <div class="mx-auto text-center">
                <h5 class="m-0 fw-bold" style="font-size:45px; color:white">ঢাকা ক্যান্টনমেন্ট বোর্ড</h5>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        @yield('main_content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script>
</body>
</html>