@extends('layouts.public')

<!-- Page level JS files -->
@section('footer_scripts')
{!! Minify::javascript(array(
    '/assets/vendors/validation/dist/js/bootstrapValidator.min.js',
    '/assets/js/validation.js',
)) !!}
@endsection

@section('content')
<div class="row vertical-offset-100 horizontal-offset-100">
    <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3  col-md-5 col-md-offset-4 col-lg-4 col-lg-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">Forgot Password?</h3>
            </div>

            <div class="panel-body">
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="" autocomplete="on" method="post" accept-charset="UTF-8" role="form">
                    {!! csrf_field() !!}
                    <fieldset>
                        <div class="form-group input-group">
                            <div class="input-group-addon">
                                <i class="livicon" data-name="at" data-size="18" data-c="#000" data-hc="#000" data-loop="true"></i>
                            </div>
                            <input class="form-control" placeholder="E-mail" name="email" type="text" />
                        </div>
                        <button type="submit" class="btn btn-lg btn-primary btn-block">Send Password Reset Link</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>
                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="/password/email">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label class="col-md-4 control-label">E-Mail Address</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
