<!-- Stored in resources/views/layouts/public.blade.php -->

@extends('layouts.public')

<!-- Page level JS files -->
@section('footer_scripts')
{!! Minify::javascript(array(
    '/assets/vendors/validation/dist/js/bootstrapValidator.min.js',
    '/assets/js/validation.js',
    '/assets/js/script.js',
)) !!}
@endsection

@section('content')
<div class="row vertical-offset-50 horizontal-offset-100">
    <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3  col-md-5
    col-md-offset-4 col-lg-4 col-lg-offset-4">

        <!-- flash error/success message section -->
        @include('layouts.partial.flashmessage')

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">Account Login</h3>
            </div>

            <div class="panel-body">
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="" autocomplete="on" method="post" accept-charset="UTF-8" role="form"
                      id="frm_loginForm">
                    {!! csrf_field() !!}
                    <fieldset>
                        <div class="form-group input-group">
                            <div class="input-group-addon">
                                <i class="livicon" data-name="at" data-size="18" data-c="#000" data-hc="#000" data-loop="true"></i>
                            </div>
                            <input class="form-control" placeholder="E-mail" name="email" type="text" />
                        </div>
                        <div class="form-group input-group">
                            <div class="input-group-addon">
                                <i class="livicon" data-name="key" data-size="18" data-c="#000" data-hc="#000" data-loop="true"></i>
                            </div>
                            <input class="form-control" placeholder="Password" name="password" type="password" value="" />
                        </div>
                        <div class="form-group">
                            <label>
                                <input name="remember" type="checkbox" value="Remember Me" class="minimal-blue">
                                Remember Me
                            </label>
                            <label class="pull-right">
                                <a class="text-green"
                                   href="/password/email">Forgot Password?</a>
                            </label>
                        </div>
                        <button type="submit" class="btn btn-lg btn-block
                        greenbgs">Login</button>
                        <div class="form-group text-center">
                            <label>
                                Don't have an account?<br>
                                <a class="text-green" href="/auth/register">
                                    Create one </a>
                            </label>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
