<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"/>
    <link rel="stylesheet" href="{{ Asset('css/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap">
    <title>@yield('title','WIL Allocation')</title>
    @stack('css') 
</head>
<body>
    @include('layout.nav')
    <div class="container content-width">
     
        
                    
        @if (session('error'))
        <p class="alert alert-danger">{{ session('error') }}</p>
        @endif

        @if (session('success'))
            <p class="alert alert-success">{{ session('success') }}</p>
        @endif

        @yield('content')

    </div>

    @include('layout.footer')


@stack('js')

</body>
</html>
