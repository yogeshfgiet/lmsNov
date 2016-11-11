<!-- Stored in resources/views/user/moreinfo.blade.php -->
@extends('layouts.dashboard')

<!-- Page level JS files -->
@section('footer_scripts')
{!! Minify::javascript([
    '/assets/vendors/validation/dist/js/bootstrapValidator.min.js',
    '/assets/js/validation.js',
    '/assets/js/script.js',
]) !!}
@endsection
<!-- Page level JS files -->

@section('section-content')
<div class="row">
    <div class="col-lg-12">
        <div id="dv_userProfile" class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="livicon" data-name="edit" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>
                    Edit Credit Card/Bank Account Information
                </h3>
            </div>
            @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissable">
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                    <strong>Whoops!</strong><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <br>
            {!! Form::open(
                [
                    'novalidate' => 'novalidate',
                    'files' => TRUE,
                    'method' => 'POST',
                    'class' => 'form-horizontal col-lg-12',
                    'autocomplete' => 'off',
                    'url' => 'upgrade-agent',
                    'id' => 'frm_agentTypeForm',
                ])
            !!}
            <fieldset>
                <div class="form-group">
                    {!! Form::label(
                        'user_type',
                        'Select Agent Type',
                        ['class' => 'col-md-3 control-label']
                    )!!}

                    <div class="col-md-6">
                        {!! Form::select(
                            'user_type',
                            [
                                3 => 'Both Showing and Posting',
                                2 => 'Showing Agent',
                                1 => 'Posting Agent'
                            ], $billingInfo['user_type'],
                            ['class' => 'form-control',
                             'onchange' => 'changeUserType
                             (\'profile-info\')']
                        )!!}
                    </div>
                </div>
            </fieldset>
            {!! Form::close() !!}
            <div class="panel-body">
                <!-- Panel-group Start -->
                <div class="panel-group" id="accordion">
                    <div id="dv_bankInfo">
                        <!-- Panel Panel-default Start -->
                        <div class="panel panel-default">
                            <!-- Panel-heading Start -->
                            <div class="panel-heading text_bg">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                        <span class=" glyphicon glyphicon-plus
                                        success"></span>
                                        <span class="success">Edit
                                            Bank Account Information</span></a>
                                </h4>
                            </div>
                            <!-- //Panel-heading End -->
                            <!-- Collapseone Start -->
                            <div id="collapseOne" class="panel-collapse collapse">
                                <div class="panel-body">
                                    {!! Form::open(
                                        [
                                            'novalidate' => 'novalidate',
                                            'files' => TRUE,
                                            'method' => 'POST',
                                            'url' => 'edit-payment-profile',
                                            'class' => 'form-horizontal col-lg-12',
                                            'autocomplete' => 'off',
                                            'id' => 'frm_bankAccountEdit',
                                        ])
                                    !!}
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="profile_type"
                                           value="{!! config('custom.agent_types.showing') !!}"/>
                                    {!! Form::hidden(
                                            'user_type',
                                            $billingInfo['user_type'],
                                            ['class' => 'user-types']
                                        )!!}
                                    <fieldset>
                                    <div class="form-group">
                                        {!! Form::label(
                                            'bank_name',
                                            'Bank Name*',
                                            ['class' => 'col-md-3 control-label']
                                        )!!}

                                        <div class="col-md-6">
                                            {!! Form::text(
                                                'bank_name',
                                                isset($billingInfo['bank_name']) ? $billingInfo['bank_name'] : '',
                                                ['class' => 'form-control']
                                            )!!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label(
                                            'account_name',
                                            'Bank Account Name*',
                                            ['class' => 'col-md-3 control-label']
                                        )!!}

                                        <div class="col-md-6">
                                            {!! Form::text(
                                                'account_name',
                                                isset($billingInfo['account_name']) ? $billingInfo['account_name'] : '',
                                                ['class' => 'form-control']
                                            )!!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label(
                                            'routing_number',
                                            'Routing Number*',
                                            ['class' => 'col-md-3 control-label']
                                        )!!}

                                        <div class="col-md-6">
                                            {!! Form::text(
                                                'routing_number',
                                                isset($billingInfo['routing_number']) ? $billingInfo['routing_number'] : '',
                                                ['class' => 'form-control']
                                            )!!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label(
                                            'account_number',
                                            'Account Number*',
                                            ['class' => 'col-md-3 control-label']
                                        )!!}

                                        <div class="col-md-6">
                                            {!! Form::text(
                                                'account_number',
                                                isset($billingInfo['account_number']) ? $billingInfo['account_number'] : '',
                                                ['class' => 'form-control']
                                            )!!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label(
                                            'account_type',
                                            'Account Type*',
                                            ['class' => 'col-md-3 control-label']
                                        )!!}
                                        <div class="col-md-6">
                                        {!! Form::select(
                                            'account_type',
                                            [
                                                0 => 'Savings',
                                                1 => 'Checking',
                                                2 => 'Business Checking'
                                            ], isset($billingInfo['account_type']) ? $billingInfo['account_type'] : '',
                                            ['class' => 'form-control']
                                        )!!}
                                        </div>
                                    </div>

                                    <div class="form-group text-center">
                                        {!! Form::submit(
                                            'Save',
                                            ['class'=>'btn btn-md btn-primary']
                                        )!!}
                                    </div>
                                </fieldset>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    <!-- Collapseone End -->
                    </div>
                    <br>
                    <div id="dv_cardInfo">
                        <!-- Panel Panel-default Start -->
                        <div class="panel panel-default">
                            <!-- Panel-heading Start -->
                            <div class="panel-heading text_bg">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse"
                                       data-parent="#accordion"
                                       href="#collapseTwo">
                                        <span class=" glyphicon glyphicon-plus
                                        success"></span>
                                        <span class="success">Edit
                                            Credit Card Information</span></a>
                                </h4>
                            </div>
                            <!-- //Panel-heading End -->
                            <div id="collapseTwo" class="panel-collapse
                            collapse">
                                <div class="panel-body">

                                    {!! Form::open(
                                        [
                                            'novalidate' => 'novalidate',
                                            'files' => TRUE,
                                            'method' => 'POST',
                                            'url' => 'edit-payment-profile',
                                            'class' => 'form-horizontal col-lg-12',
                                            'autocomplete' => 'off',
                                            'id' => 'frm_creditCardEdit',
                                        ])
                                    !!}
                                    <input type="hidden" name="profile_type"
                                           value="{!! config('custom.agent_types.posting') !!}" />
                                    {!! Form::hidden(
                                            'user_type',
                                            $billingInfo['user_type'],
                                            ['class' => 'user-types']
                                        )!!}
                                    <fieldset>

                                    @if (isset($billingInfo['card_number']) && ('' != $billingInfo['card_number']))
                                        <div class="form-group">
                                            {!! Form::label(
                                                'card_number_used',
                                                'Credit Card Used:',
                                                ['class' => 'col-md-3 control-label']
                                            )!!}

                                            <div class="col-md-6">
                                                <a class="col-md-3 control-label"> XXXX{!!
                                            $billingInfo['card_number'] or ''  !!}</a>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        {!! Form::label(
                                            'card_full_name',
                                            'Card Full Name*',
                                            ['class' => 'col-md-3 control-label']
                                        )!!}
                                        <div class="col-md-6">
                                            {!! Form::text(
                                                'card_full_name',
                                                isset($billingInfo['card_full_name']) ? $billingInfo['card_full_name'] : '',
                                                ['class' => 'form-control']
                                            )!!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label(
                                            'card_number',
                                            'Card Number*',
                                            ['class' => 'col-md-3 control-label']
                                        )!!}

                                        <div class="col-md-6">
                                            {!! Form::text(
                                                'card_number',
                                                '',
                                                ['class' => 'form-control']
                                            )!!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label(
                                            'expiry_month',
                                            'Expiry Month*',
                                            ['class' => 'col-md-3 control-label']
                                        )!!}

                                        <div class="col-md-6">
                                            {!! Form::selectMonth(
                                                'expiry_month',
                                                isset($billingInfo['expiry_month']) ? $billingInfo['expiry_month'] : '',
                                                ['class' => 'form-control']
                                            ) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label(
                                            'expiry_year',
                                            'Expiry Year*',
                                            ['class' => 'col-md-3 control-label']
                                        )!!}

                                        <div class="col-md-6">
                                            <?php $currentYear = date('Y'); ?>

                                            {!! Form::selectRange(
                                                'expiry_year',
                                                $currentYear,
                                                $currentYear + 20,
                                                isset($billingInfo['expiry_year']) ? $billingInfo['expiry_year'] : $currentYear,
                                                ['class' => 'form-control']
                                            ) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label(
                                            'cvv_number',
                                            'CVV Number*',
                                            ['class' => 'col-md-3 control-label']
                                        )!!}
                                        <div class="col-md-6">
                                            {!! Form::text(
                                                'cvv_number',
                                                '',
                                                ['class' => 'form-control']
                                            )!!}
                                        </div>
                                    </div>

                                    <div class="form-group text-center">
                                        {!! Form::submit(
                                            'Save',
                                            ['class'=>'btn btn-md btn-primary']
                                        )!!}
                                    </div>
                                    </fieldset>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                            <!-- //Panle-group End -->
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button class="btn btn-md btn-primary"
                            onclick="$('#frm_agentTypeForm').submit()">Upgrade
                        Agent Type</button>
                    <a href="/home"><button class="btn btn-md
                    btn-danger">Cancel</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection