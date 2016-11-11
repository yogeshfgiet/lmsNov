<!-- Stored in resources/views/layouts/public.blade.php -->

@extends('layouts.public')

<!-- Page level CSS files -->
@section('header_styles')
{!! Minify::stylesheet(array(
    '/assets/css/pages/login2.css',
)) !!}
@endsection

<!-- Page level JS files -->
@section('footer_scripts')
{!! Minify::javascript(array(
    '/assets/vendors/validation/dist/js/bootstrapValidator.min.js',
    '/assets/js/validation.js',
    '/assets/js/script.js',
    '/assets/js/user/newmask.js',
)) !!}
@endsection

@section('content')
<div class="row vertical-offset-50 horizontal-offset-50">
    <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-5 col-md-offset-4 col-lg-4 col-lg-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">Sign Up for Last Minute
                    Showings
                </h3>
            </div>

            <div class="panel-body">
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong>
                    There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div id="dv_registrationConfirm"
                     class="@if (count($errors) > 0) hide @else show @endif
                             block-center text-green">
                    <div>
                        Are you a subscriber to the Multi-listing
                        service in your area?
                    </div>

                    <div class="height-30"></div>

                    <div class="col-md-6">
                        <select class="form-control" id="sel_serviceSubscriber">
                            <option value="1">Yes I am</option>
                            <option value="0">No I am not</option>
                        </select>
                    </div>

                    <div class="height-30"></div>

                    <div class="col-md-6">
                        <button class="btn btn-success btn-lg btn-responsive greenbgs"
                                onclick="showRegistration();">
                            Next >
                        </button>
                    </div>
                </div>

                <div id="dv_registration"
                     class="@if (count($errors) > 0) show @else hide @endif">
                    <form action="" autocomplete="on" method="post"
                          accept-charset="UTF-8" role="form" id="frm_registerForm">
                        {!! csrf_field() !!}
                        <fieldset>
                            <div class="form-group input-group">
                                <div class="input-group-addon">
                                    <i class="livicon" data-name="user"
                                       data-size="18" data-c="#000"
                                       data-hc="#000" data-loop="true"></i>
                                </div>
                                {!! Form::text(
                                    'first_name',
                                    null,
                                    [
                                        'class'=>'form-control',
                                        'placeholder'=>'First Name'
                                    ]
                                ) !!}
                            </div>

                            <div class="form-group input-group">
                                <div class="input-group-addon">
                                    <i class="livicon" data-name="user"
                                       data-size="18" data-c="#000"
                                       data-hc="#000" data-loop="true"></i>
                                </div>
                                {!! Form::text(
                                    'last_name',
                                    null,
                                    [
                                        'class'=>'form-control',
                                        'placeholder'=>'Last Name'
                                    ]
                                ) !!}
                            </div>

                            <div class="form-group input-group">
                                <div class="input-group-addon">
                                    <i class="livicon" data-name="info"
                                       data-size="18" data-c="#000"
                                       data-hc="#000" data-loop="true"></i>
                                </div>
                                {!! Form::select(
                                    'state',
                                    $states,
                                    '6',
                                    ['class' => 'form-control']
                                ) !!}
                            </div>
                            <div class=" form-group  col-sm-12 " style=" padding: 0;margin-bottom: 1px !important;">
                            <div class="form-group input-group col-sm-12 " style="float:left">
                                <div class="input-group-addon">
                                    <i class="livicon" data-name="cellphone"
                                       data-size="18" data-c="#000"
                                       data-hc="#000" data-loop="true"></i>
                                </div>
                                {!! Form::text(
                                    'phone_number',
                                    null,
                                    [
                                        'class'=>'form-control',
                                        'id'=>'phone',
                                    ]
                                ) !!}
                                   
                            </div>
                     
                            
                            

                         </div>
                            <div class="form-group input-group">
                                <div class="input-group-addon">
                                    <i class="livicon" data-name="info"
                                       data-size="18" data-c="#000"
                                       data-hc="#000" data-loop="true"></i>
                                </div>
                                {!! Form::text(
                                    'license_number',
                                    null,
                                    [
                                        'class'=>'form-control',
                                        'placeholder'=>'Brokers License'
                                    ]
                                ) !!}
                            </div>


                            <div class="form-group input-group">
                                <div class="input-group-addon">
                                    <i class="livicon" data-name="info"
                                       data-size="18" data-c="#000"
                                       data-hc="#000" data-loop="true"></i>
                                </div>
                                {!! Form::text(
                                    'brokerage_firm_name',
                                    null,
                                    [
                                        'class'=>'form-control',
                                        'placeholder'=>'Brokerage Firm'
                                    ]
                                ) !!}
                            </div>

                            <div class="form-group input-group">
                                <div class="input-group-addon">
                                    <i class="livicon" data-name="at"
                                       data-size="18" data-c="#000"
                                       data-hc="#000" data-loop="true"></i>
                                </div>
                                {!! Form::text(
                                    'email',
                                    null,
                                    [
                                        'class'=>'form-control',
                                        'placeholder'=>'Email Address'
                                    ]
                                ) !!}
                            </div>

                            <div class="form-group input-group greenbgs">
                                <div class="input-group-addon">
                                    <i class="livicon" data-name="key"
                                       data-size="18" data-c="#000"
                                       data-hc="#000" data-loop="true"></i>
                                </div>
                                {!! Form::password(
                                    'password',
                                    [
                                        'class'=>'form-control',
                                        'placeholder'=>'Password',
                                        'autocomplete'=>'off'
                                    ]
                                ) !!}
                            </div>

                            <div class="form-group input-group">
                                <div class="input-group-addon">
                                    <i class="livicon" data-name="key"
                                       data-size="18" data-c="#000"
                                       data-hc="#000" data-loop="true"></i>
                                </div>
                                {!! Form::password(
                                    'password_confirmation',
                                    [
                                        'class'=>'form-control',
                                        'placeholder'=>'Confirm Password',
                                        'autocomplete'=>'off'
                                    ]
                                ) !!}

                            </div>
                             <small class="" style="" data-bv-validator="" data-bv-validator-for="">Note:Password needs to be a min of 8 characters.
</small>
                            <div class="form-group text-right">
                                Notification Preference :
                                <label>
                                    {!! Form::radio(
                                        'notification_preference',
                                        1,
                                        null,
                                        ['class' => 'minimal']
                                    ) !!} text
                                </label>
                                <label>
                                    {!! Form::radio(
                                        'notification_preference',
                                        0,
                                        null,
                                        ['class' => 'minimal']
                                    ) !!} email
                                </label>
                                <label>
                                    {!! Form::radio(
                                        'notification_preference',
                                        2,
                                        1,
                                        ['class' => 'minimal']
                                    ) !!} both
                                </label>
                            </div>

                            <div class="form-group text-right terms-field">
                                {!! Form::checkbox(
                                    'terms',
                                    null,
                                    null,
                                    ['class' => 'minimal']
                                ) !!}
                                <a href="/terms" target="_blank">Terms and Conditions</a>
                            </div>

                            {!! Form::submit(
                                'Register',
                                ['class'=>'btn btn-lg btn-primary btn-block newsublit       ']
                            ) !!}
                        </fieldset>
                    </form>
                </div>

                <div id="dv_registrationFailure" class="hide">
                    <div>
                        Sorry you MUST be subscribed to the multi-listing
                        service in your area to sign up for Last Minute showings.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

