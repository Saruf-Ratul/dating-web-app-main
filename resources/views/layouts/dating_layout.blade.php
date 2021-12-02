<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="A simple Dating Web Apps" content="">
    <meta name="author" content="">
    <title>Dating Web Apps</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('image/love.png') }}" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.9.0/sweetalert2.min.css"
        integrity="sha512-N2ad26UcOSDt+8tFePJA4cGTIBB1b+BwD0MnoB8c8stF+jwGLz6qnePWgiX2cTdicpZwlHfp9jKHE34juWK+hg=="
        crossorigin="anonymous" />
    <link href="{{ url('css/main.css') }}" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body id="page-top">

    @include('layouts.navbar')
    @yield('content')
    @include('layouts.footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.9.0/sweetalert2.min.js"
        integrity="sha512-C0wzinZtT2X5TEoYb0qSgINlic/4CpzOc/VyLkbeH+H2Lu0syeBSATi5ZLhC/PMYk0NQ8SFhe3uWbf74onsR3A=="
        crossorigin="anonymous"></script>
    <script src="{{ url('js/scrolling-nav.js') }}"></script>
    <script src="{{ url('js/custom_script.js') }}"></script>
    @include('sweetalert::alert')
</body>

</html>
