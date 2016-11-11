<!-- Stored in resources/views/user/moreinfo.blade.php -->
@extends('layouts.dashboard')

<!-- Page level CSS files -->
@section('header_styles')
{!! Minify::stylesheet(array(
    '/assets/vendors/wizard/jquery-steps/css/wizard.css',
    '/assets/vendors/wizard/jquery-steps/css/jquery.steps.css',
)) !!}
@endsection

<!-- Page level JS files -->
@section('footer_scripts')
{!! Minify::javascript(array(
    '/assets/vendors/wizard/jquery-steps/js/jquery.validate.min.js',
    '/assets/vendors/wizard/jquery-steps/js/additional-methods.min.js',
    '/assets/vendors/wizard/jquery-steps/js/wizard.js',
    '/assets/vendors/wizard/jquery-steps/js/jquery.steps.js',
    '/assets/vendors/wizard/jquery-steps/js/form_wizard.js',

    '/assets/js/script.js',
)) !!}
@endsection

@section('section-content')
<div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10
            col-md-offset-1 col-lg-10 col-lg-offset-1">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="livicon" data-name="edit" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>
                Complete Your Registration
            </h3>
        </div>

        <div class="panel-body">
            @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissable">
                    <button class="close" aria-hidden="true"
                            data-dismiss="alert" type="button">×</button>
                    <strong>Whoops!</strong> There were some problems with
                    your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div id="dv_moreInfo" class="text-green">
                {!! Form::open(
                    array(
                        'novalidate' => 'novalidate',
                        'files' => true,
                        'method' => 'POST',
                        'id' => 'frm_moreInfoForm',
                        'class' => 'form-wizard',
                    ))
                !!}

                {!! csrf_field() !!}

                <h1 class="hidden-xs">Profile Information</h1>
                <section>
                    <h2 class="hidden">&nbsp;</h2>
                    <div class="col-xs-12 col-sm-12 col-md-12 form-group">
                        {!! Form::label(
                            'user_type',
                            'Would You Like to Be a Showing Agent, Posting Agent or Both?',
                            ['class' => 'margin-bottom-0']
                        )!!}
                        {!! Form::select(
                            'user_type',
                            array(
                                3 => 'Both',
                                2 => 'Showing Agent',
                                1 => 'Posting Agent'
                            ),
                            3,
                            [
                                'class' => 'form-control',
                                'onchange' => 'changeUserTypeBilling
                                (\'more-info\')'
                            ]
                        ) !!}
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 form-group">
                        {!! Form::label(
                            'profile_photo',
                            'Upload a photo (Optional)',
                            ['class' => 'margin-bottom-0']
                        )!!}
                        {!! Form::file('profile_photo') !!}
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 form-group">
                        {!! Form::label(
                            'personal_bio',
                            'Personal Bio (Optional)',
                            ['class' => 'margin-bottom-0']
                        )!!}
                        {!! Form::textarea(
                            'personal_bio',
                            null,
                            array('class' => 'form-control', 'rows' => '2')
                        ) !!}
                    </div>
                    <p>(*) Mandatory</p>
                </section>

                <h1 class="hidden-xs">Billing Information</h1>
                <section>
                    <h2 class="hidden">&nbsp;</h2>

                    <div id="accordion" class="panel-group">
                        <div class="panel panel-default" id="dv_bankInfoLnk">
                            <div class="panel-heading text_bg">
                                <h4 class="panel-title">
                                    <a href="#collapseOne" data-parent="#accordion"
                                       data-toggle="collapse">
                                        <span class="glyphicon glyphicon-minus"></span>
                                        <span>
                                            Bank Information
                                        </span>
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse in"
                                 id="collapseOne">
                                <div id="dv_bankInfo" class="panel-body">
                                    <div class="form-group col-xs-12 col-sm-6
                            col-md-6">
                                        {!! Form::label(
                                            'bank_name',
                                            'Bank Name *',
                                            ['class' => 'margin-bottom-0']
                                        )!!}
                                        {!! Form::text(
                                            'bank_name',
                                            null,
                                            ['class' => 'form-control required']
                                        ) !!}
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-6
                            col-md-6">
                                        {!! Form::label(
                                            'account_name',
                                            'Account Name *',
                                            ['class' => 'margin-bottom-0']
                                        )!!}
                                        {!! Form::text(
                                            'account_name',
                                            null,
                                            ['class' => 'form-control required']
                                        ) !!}
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-6
                            col-md-6">
                                        {!! Form::label(
                                            'routing_number',
                                            'Routing Number *',
                                            ['class' => 'margin-bottom-0']
                                        )!!}
                                        {!! Form::text(
                                            'routing_number',
                                            null,
                                            ['class' => 'form-control required']
                                        ) !!}
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-6
                            col-md-6">
                                        {!! Form::label(
                                            'account_number',
                                            'Bank Account Number *',
                                            ['class' => 'margin-bottom-0']
                                        )!!}
                                        {!! Form::text(
                                            'account_number',
                                            null,
                                            ['class' => 'form-control required']
                                        ) !!}
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-6
                            col-md-6">
                                        {!! Form::label(
                                            'account_type',
                                            'Account Type *',
                                            ['class' => 'margin-bottom-0']
                                        )!!}
                                        {!! Form::select(
                                            'account_type',
                                            array(
                                                0 => 'Savings',
                                                1 => 'Checking',
                                                2 => 'Business Checking',
                                            ),
                                            0,
                                            ['class' => 'form-control required']
                                        ) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default" id="dv_cardInfoLnk">
                            <div class="panel-heading text_bg">
                                <h4 class="panel-title">
                                    <a href="#collapseTwo"
                                       data-parent="#accordion"
                                       data-toggle="collapse">
                                        <span class=" glyphicon glyphicon-plus"></span>
                                        <span>
                                            Card Information
                                        </span>
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse"
                                 id="collapseTwo">
                                <div id="dv_cardInfo" class="panel-body">
                                    <div class="form-group col-xs-12 col-sm-6
                        col-md-6">
                                        {!! Form::label(
                                            'card_full_name',
                                            'Name on Card *',
                                            ['class' => 'margin-bottom-0']
                                        )!!}
                                        {!! Form::text(
                                            'card_full_name',
                                            null,
                                            ['class' => 'form-control required']
                                        ) !!}
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-6
                        col-md-6">
                                        {!! Form::label(
                                            'card_number',
                                            'Credit Card Number *',
                                            ['class' => 'margin-bottom-0']
                                        )!!}
                                        {!! Form::text(
                                            'card_number',
                                            null,
                                            ['class' => 'form-control required']
                                        ) !!}
                                    </div>

                                    <div class="col-xs-12 col-sm-6 col-md-6
                        form-group">
                                        {!! Form::label(
                                            'expiry_month',
                                            'Expiry Month *',
                                            ['class' => 'margin-bottom-0']
                                        )!!}
                                        {!! Form::selectMonth(
                                            'expiry_month',
                                            null,
                                            ['class' => 'form-control required']
                                        ) !!}
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6
                        form-group">
                                        {!! Form::label(
                                            'expiry_year',
                                            'Expiry Year *',
                                            ['class' => 'margin-bottom-0']
                                        )!!}

                                        <?php $currentYear = date('Y'); ?>

                                        {!! Form::selectRange(
                                            'expiry_year',
                                            $currentYear,
                                            $currentYear + 20,
                                            null,
                                            ['class' => 'form-control required']
                                        ) !!}
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-6
                        col-md-6">
                                        {!! Form::label(
                                            'cvv_number',
                                            'CVV *',
                                            ['class' => 'margin-bottom-0']
                                        )!!}
                                        {!! Form::text(
                                            'cvv_number',
                                            null,
                                            ['class' => 'form-control required']
                                        ) !!}
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <p>(*) Mandatory</p>
                </section>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
