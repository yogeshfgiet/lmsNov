<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        {!! Minify::javascript(array(
            'https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js',
            'https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js',
        )) !!}
        <![endif]-->
        <title>
            @section('title')
            Welcome to Last Minute Showings
            @show
        </title>

        <script>
            var BASE_URL = "{{ Config::get('app.url') }}";
        </script>

        {!! Minify::stylesheet(array(
            '/assets/css/bootstrap.min.css',
            '/assets/css/custom.css',
            '/assets/css/styles.css',
            '/assets/css/responsive.css',
        )) !!}

        <!--page level css-->
        @yield('header_styles')
        <!--end of page level css-->
    </head>

    <body>
        <!-- Header Start -->
        <header>
            <!-- Icon Section Start -->
            @include('layouts.partial.info')
            <!-- //Icon Section End -->

            <!-- Nav bar Start -->
            @include('layouts.partial.nav')
            <!-- Nav bar End -->

            <!-- breadcrumbs section -->
            @if(!empty(Request::segments()))
                @include('layouts.partial.breadcrumbs')
            @endif
        </header>
        <!-- //Header End -->

        <div>
            <!-- Content -->
            @yield('content')
        </div>

        @include('layouts.partial.footer')

        <div class="copyright">
            <div class="container">
                <p>Copyright &copy; Last Minute Showings, 2015</p>
            </div>
        </div>
        <a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top" data-toggle="tooltip" data-placement="left">
            <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
        </a>

        {!! Minify::javascript(array(
            '/assets/js/jquery-1.11.1.min.js',
            '/assets/js/bootstrap.min.js',
            '/assets/vendors/livicons/minified/raphael-min.js',
            '/assets/vendors/livicons/minified/livicons-1.4.min.js',
        )) !!}

        <!--global js end-->

        <!-- begin page level js -->
        @yield('footer_scripts')
        <!-- end page level js -->
    </body>

</html>
