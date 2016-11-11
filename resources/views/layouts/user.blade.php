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
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <!-- global css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="{{ asset('assets/vendors/font-awesome-4.2.0/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/styles/black.css') }}" rel="stylesheet" type="text/css" id="colorscheme" />
        <link href="{{ asset('assets/css/panel.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/css/metisMenu.css') }}" rel="stylesheet" type="text/css"/>

        <link href="{{ asset('assets/vendors/iCheck/skins/all.css') }}" rel="stylesheet" />

        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.colReorder.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.scroller.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
        <link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css">

        <!-- end of global css -->
        <!--page level css -->
        <link rel="stylesheet" href="{{ asset('assets/css/only_dashboard.css') }}" />
        <link href="{{ asset('assets/vendors/modal/css/component.css') }}" rel="stylesheet" />

        <link href="{{ asset('assets/vendors/wizard/jquery-steps/css/wizard.css') }}" rel="stylesheet" >
        <link href="{{ asset('assets/vendors/wizard/jquery-steps/css/jquery.steps.css') }}" rel="stylesheet" >

        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/styles.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
        <!--end of page level css-->

        <script>
            var BASE_URL = "{{ Config::get('app.url') }}";
        </script>
    </head>

    <body class="skin-josh" data-backdrop="static" aria-hidden="true">
        <div class="loader"></div>

        <header class="header">
            <a class="img-responsive logo" href="/">
                <img src="{{ asset ('assets/img/lms.png')}}"
                     class="lms_position" alt="Logo">
            </a>
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <div>
                    <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                        <div class="responsive_nav"></div>
                    </a>
                </div>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <?php $imgSrc = ''; ?>

                                @if(Auth::user()->profile_photo)
                                <?php

                                $imgSrc = url('uploads/user/' . Auth::user()->profile_photo);
                                ?>
                                @endif

                                <img {!! ($imgSrc) ? "src='$imgSrc'" : "data-src='holder.js/35x35/#fff:#000'" !!} width="35" class="img-circle img-responsive pull-left" height="35" alt="pic">
                                    <div class="riot">
                                    <div>
                                        @if( Auth::check() )
                                        {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                                        @endif
                                        <span>
                                            <i class="caret"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img {!! ($imgSrc) ? "src='$imgSrc'" : "data-src='holder.js/90x90/#fff:#000'" !!} class="img-responsive img-circle" alt="User Image">
                                        <p class="topprofiletext">
                                        @if( Auth::check() )
                                        {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                                        @endif
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li>
                                    <a href="{!! url('edit-profile') !!}">
                                        <i class="livicon" data-name="user" data-s="18"></i>
                                        My Profile
                                    </a>
                                </li>
                                <li role="presentation"></li>
                                <li>
                                    <a href="{!! url('edit-billing-info') !!}">
                                        <i class="livicon" data-name="gears" data-s="18"></i>
                                        Account Settings
                                    </a>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-right">
                                        <a href="auth/logout">
                                            <i class="livicon" data-name="sign-out" data-s="18"></i>
                                            Logout
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <div id="dv_contentSection">
            <div class="wrapper row-offcanvas row-offcanvas-left">
                <!-- Left side column. contains the logo and sidebar -->
                <aside class="left-side sidebar-offcanvas">
                    <section class="sidebar ">
                        <div class="page-sidebar  sidebar-nav">
                            <div class="clearfix"></div>
                            <!-- BEGIN SIDEBAR MENU -->
                            <ul id="menu" class="page-sidebar-menu">
                                <li {!! (Request::is('/home') ? 'class="active"' : '') !!}>
                                    <a href="/home">
                                        <i class="livicon" data-name="home" data-size="18" data-c="#418BCA" data-hc="#418BCA" data-loop="true"></i>
                                        <span class="title">Dashboard</span>
                                    </a>
                                </li>

                                <li {!! (Request::is('/showings') ? 'class="active"' : '') !!}>
                                    <a href="/showings">
                                        <i class="livicon" data-name="eye-open" data-size="18" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i>
                                        <span class="title">View available showings</span>
                                        <span class="fa arrow"></span>
                                    </a>
                                </li>

                                <li {!! (Request::is('/showings/edit') ? 'class="active"' : '') !!}>
                                    <a href="/showings/edit">
                                        <i class="livicon" data-name="pencil" data-size="18" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i>
                                        <span class="title">Post or edit a showing</span>
                                        <span class="fa arrow"></span>
                                    </a>
                                </li>

                                <li {!! (Request::is('/current-showing') ? 'class="active"' : '') !!}>
                                    <a href="#">
                                        <i class="livicon" data-name="eye-open" data-size="18" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i>
                                        <span class="title">View current showings</span>
                                        <span class="fa arrow"></span>
                                    </a>
                                </li>

                                <li {!! (Request::is('/past-showings') ? 'class="active"' : '') !!}>
                                    <a href="#">
                                        <i class="livicon" data-name="eye-open" data-size="18" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i>
                                        <span class="title">View past showings</span>
                                        <span class="fa arrow"></span>
                                    </a>
                                </li>

                                <li {!! (Request::is('edit-profile') ? 'class="active"' : '') !!}>
                                    <a href="{{ URL::to('edit-profile') }}">
                                        <i class="livicon" data-name="pencil" data-size="18" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i>
                                        <span class="title">Edit profile</span>
                                        <span class="fa arrow"></span>
                                    </a>
                                </li>

                                <li {!! (Request::is('edit-billing-info') ? 'class="active"' : '') !!}>
                                    <a href="{{ URL::to('edit-billing-info') }}">
                                        <i class="livicon" data-name="pencil" data-size="18" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i>
                                        <span class="title">Update billing and/or bank account information</span>
                                        <span class="fa arrow"></span>
                                    </a>
                                </li>

                                <li {!! (Request::is('/edit-account') ? 'class="active"' : '') !!}>
                                    <a href="#">
                                        <i class="livicon" data-name="trash" data-size="18" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i>
                                        <span class="title">Cancel account</span>
                                        <span class="fa arrow"></span>
                                    </a>
                                </li>
                            </ul>
                            <!-- END SIDEBAR MENU -->
                        </div>
                    </section>
                    <!-- /.sidebar -->
                </aside>
                <!-- Right side column. Contains the navbar and content of the page -->
                <aside class="right-side">
                    <!-- Main content -->
                    <section class="content-header">
                        <h1>Welcome to Dashboard</h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <a href="#">
                                    <i class="livicon" data-name="home" data-size="16" data-color="#333" data-hovercolor="#333"></i>
                                    Home
                                </a>
                            </li>
                        </ol>
                    </section>
                    <section class="content">
                        <!-- flash error/success message section -->
                        @include('layouts.partial.flashmessage')

                        <!-- Section Content -->
                        @yield('section-content')
                    </section>
                </aside>
                <!-- right-side -->
            </div>
            <a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top" data-toggle="tooltip" data-placement="left">
                <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
            </a>
        </div>

        <div id="dv_viewShowings"></div>

        <!-- global js -->
        <script src="{{ asset('assets/js/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>

        <!--livicons-->
        <script src="{{ asset('assets/vendors/livicons/minified/raphael-min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/livicons/minified/livicons-1.4.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/josh.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
        <script type="text/javascript" src="{{ asset('assets/vendors/datatables/dataTables.colReorder.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/vendors/datatables/dataTables.bootstrap.js') }}"></script>
        <script src="{{ asset('assets/vendors/holder-master/holder.js') }}" type="text/javascript"></script>
        <!-- end of global js -->

        <!-- begining of page level js -->
        <script src="{{ asset('assets/vendors/modal/js/classie.js') }}"></script>
        <script src="{{ asset('assets/vendors/modal/js/modalEffects.js') }}"></script>

        <script src="{{ asset('assets/vendors/iCheck/icheck.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/iCheck/demo/js/custom.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/validation/dist/js/bootstrapValidator.min.js')}}" type="text/javascript" ></script>

        <script type="text/javascript" src="{{ asset('assets/vendors/wizard/jquery-steps/js/jquery.validate.min.js') }}"></script>
        <script  src="{{ asset('assets/vendors/wizard/jquery-steps/js/additional-methods.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/wizard/jquery-steps/js/wizard.js') }}"></script>
        <script src="{{ asset('assets/vendors/wizard/jquery-steps/js/jquery.steps.js') }}"></script>
        <script src="{{ asset('assets/vendors/wizard/jquery-steps/js/form_wizard.js') }}"></script>

        <script type="text/javascript" src="{{ asset('assets/js/validation.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/script.js') }}"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        <script type="text/javascript" src="{{ asset('assets/js/user/showings.js') }}"></script>
        <!-- end of page level js -->
    </body>
</html>
