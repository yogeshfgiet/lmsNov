<!-- Stored in resources/views/layouts/partial/nav.blade.php -->

<nav class="navbar navbar-default container">
    <div class="navbar-header">
        <button style="display:none;" type="button" class="navbar-toggle collapsed"
                data-toggle="collapse" data-target="#collapse">
            <span>
                <a href="#">
                    <i class="livicon" data-name="responsive-menu"
                       data-size="25" data-loop="true" data-c="#757b87"
                       data-hc="#ccc"></i>
                </a>
            </span>
        </button>
        <a class="navbar-brand img-responsive" href="/">
            @if(empty(Request::segments()))
                <img src="{{ asset ('assets/img/logo.png')}}" class="logo_position">
            @else
                <img src="{{ asset ('assets/img/lms.png')}}" class="lms_position">
            @endif
        </a>
    </div>

    <div class="collapse navbar-collapse" id="collapse">
        <ul class="nav navbar-nav navbar-right">
            @if(Auth::check())
                <li {!! (Request::is('home') ? 'class="active"' : '')
                        !!}>
                    <a href="{{ URL::to('home') }}"> Home</a>
                </li>
            @else
                <li {!! (Request::is('/') ? 'class="active"' : '')
                        !!}>
                    <a href="{{ URL::to('/') }}"> Home</a>
                </li>
            @endif


            <li {!! (Request::is('instruction') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('instruction') }}">How it works</a>
            </li>
            <li {!! (Request::is('about') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('about') }}">About</a>
            </li>

            @if(!Auth::check())
                <li {!! (Request::is('auth/register') ? 'class="active"' : '') !!}>
                    <a href="{{ URL::to('auth/register') }}">SignUp</a>
                </li>
            @endif

            <li {!! (Request::is('contact') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('contact') }}">Contact</a>
            </li>

            @if(Auth::check())
                <li {!! (Request::is('auth/logout') ? 'class="active"' : '') !!}>
                    <a href="{{ URL::to('auth/logout') }}">Logout</a>
                </li>
                  <?php
                
                   $imgSrc = url('uploads/user/' . Auth::user()->profile_photo);
       
                     $tooltip = ucwords( Auth::user()->first_name);
            
                    ?>
                <li >
                   <div class="logStatus"> 
                    <div class="shortName">
                        <div>
                    {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                </div>
                    </div>
                    <div class="shrtpic"> 
                        @if(Auth::user()->profile_photo)
                        <img   {!! ($imgSrc) ? "src='$imgSrc'" : "data-src='holder.js/35x35/#fff:#000'" !!} width="35" class="img-circle img-responsive pull-left" height="35" alt="Image">
                    @else
                    <div  width="35" class="img-circle img-responsive pull-left" height="35"  data-toggle="tooltip" title=" <?php echo $tooltip ;?>"><i  width="35" height="35"   class="fa fa-user fa-2x" aria-hidden="true"></i></div>
                      
      
                     @endif           
                   </div>

                </li>
            @else
                <li {!! (Request::is('auth/login') ? 'class="active"' : '') !!}>
                    <a href="{{ URL::to('auth/login') }}">Login</a>
                </li>
            @endif
        </ul>
    </div>
</nav>