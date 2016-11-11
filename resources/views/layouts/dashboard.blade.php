<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>Last Minute Showings</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        {!! Minify::javascript(array(
            'https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js',
            'https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js',
        )) !!}
        <![endif]-->

        {!! Minify::stylesheet(array(
            '/assets/css/bootstrap.min.css',
            '/assets/css/custom.css',
            '/assets/vendors/font-awesome-4.2.0/css/font-awesome.min.css',
            '/assets/css/styles.css',
            '/assets/css/responsive.css'
        )) !!}

        <!--page level css-->
        @yield('header_styles')
        <!--end of page level css-->

        <script>
            var BASE_URL = "{{ url() }}/";
        </script>
    </head>

    <body class="skin-josh dashboard-section" data-backdrop="static" aria-hidden="true">
        <div class="loader"></div>

        <!-- Header Start -->
        <header>
            <!-- Icon Section Start -->
            @include('layouts.partial.info')
            <!-- //Icon Section End -->

            <!-- Nav bar Start -->
            @include('layouts.partial.nav')
            <!-- Nav bar End -->

            <!-- breadcrumbs section -->
            @if(in_array('home', Request::segments()))
                <div class="icon-section home-nav">
                    <div class="container text-center text-white">
                        <div class="col-md-6 panel-heading">
                            <h3 class="panel-title">
                                Showing Agent Tools
                            </h3>
                        </div>

                        <div class="col-md-6 panel-heading">
                            <h3 class="panel-title">
                                Posting Agent Tools
                            </h3>
                        </div>
                    </div>
                </div>
                
                    <?php $userType =  Auth::user()->user_type?>
                     <div div class="panel-body">
                    @if($userType == 1)

                    <a  style="cursor:text" class="btn btn-lg btn-block " href="#">
                        You are currently registered as a posting agent
                    </a>
                       
                    @elseif($userType == 2)
                       <a  style="cursor:text"class="btn btn-lg btn-block " href="#" >
                        You are currently registered as a showing agent
                    </a >
                       
                    @else
                      <a  style="cursor:text" class="btn btn-lg btn-block " href="#">
                      You are currently registered as a showing agent and a posting agent
                    </a>
                    @endif 


                    </div>
            @elseif(!empty(Request::segments()))
                @include('layouts.partial.breadcrumbs')
            @endif
        </header>
        <!-- //Header End -->

        <div class="container">
            <!-- Icon Section Start -->
            @include('layouts.partial.flashmessage')
            <!-- //Icon Section End -->

            <!-- Content -->
            @yield('section-content')
        </div>

        @include('layouts.partial.footer')

        <div id="dv_viewShowings" class="modal fade"></div>

        {!! Minify::javascript(array(
            '/assets/js/jquery-1.11.1.min.js',
            '/assets/js/jquery.ui.min.js',
            '/assets/js/bootstrap.min.js',
            '/assets/vendors/livicons/minified/raphael-min.js',
            '/assets/vendors/livicons/minified/livicons-1.4.min.js',
            '/assets/js/bootbox.min.js',
        )) !!}

        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>

        <!-- begin page level js -->
        @yield('footer_scripts')
        <!-- end of page level js -->
    </body>
</html>
