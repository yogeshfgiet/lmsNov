<!-- Stored in resources/views/user/moreinfo.blade.php -->

@extends('layouts.dashboard')

<!-- Page level JS files -->
@section('footer_scripts')
{!! Minify::javascript(array(
    '/assets/vendors/validation/dist/js/bootstrapValidator.min.js',
    '/assets/js/loader/jquery.loader.min.js',
    '/assets/js/validation.js',
    '/assets/js/script.js',
    '/assets/js/user/newmask.js',
    )) !!}
    @endsection

 
    <!-- Page level JS files -->

    @section('section-content')
    <style>
    .loader {
        background: rgba(11, 10, 66, 0.1) url("/assets/img/loading1.gif") no-repeat scroll 50% 50% !important;
    }
    </style>
    <div class="row">
        <div class="col-lg-12">
            <div id="dv_userProfile" class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="livicon" data-name="edit" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>
                        Edit Profile Information
                    </h3>
                </div>


                <div class="panel-body">
                    @if (count($errors) > 0)
                    <div class="alert alert-danger alert-dismissable">
                        <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    {!! Form::open(
                    array(
                    'novalidate' => 'novalidate',
                    'files' => true,
                    'method' => 'POST',
                    'class' => 'form-horizontal col-lg-9',
                    'autocomplete' => 'off',
                    'id' => 'frm_profileInfoForm',
                    ))
                    !!}

                    {!! csrf_field() !!}
                    <fieldset>



                        <div class="form-group">
                            {!! Form::label(
                            'first_name',
                            'First Name*',
                            ['class' => 'col-md-3 control-label']
                            )!!}

                            <div class="col-md-6">
                                {!! Form::text(
                                'first_name',
                                Auth::user()->first_name,
                                ['class' => 'form-control']
                                )!!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label(
                            'last_name',
                            'Last Name*',
                            ['class' => 'col-md-3 control-label']
                            )!!}

                            <div class="col-md-6">
                                {!! Form::text(
                                'last_name',
                                Auth::user()->last_name,
                                ['class' => 'form-control']
                                )!!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label(
                            'state',
                            'State',
                            ['class' => 'col-md-3 control-label']
                            )!!}

                            <div class="col-md-6">
                                {!! Form::select(
                                'state',
                                $states,
                                Auth::user()->state_id,
                                ['class' => 'form-control']
                                )!!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label(
                            'phone_number',
                            'Phone Number*',
                            ['class' => 'col-md-3 control-label']
                            )!!}

                            <div s class="col-xs-6">
                                {!! Form::text(
                                'phone_number',
                                Auth::user()->phone_number ,
                                ['class' => 'form-control','id'=>"phone"]
                                )!!}
                            </div>
                            
                            



                        </div>



                        <div class="form-group">
                            {!! Form::label(
                            'license_number',
                            'License Number*',
                            ['class' => 'col-md-3 control-label']
                            )!!}

                            <div class="col-md-6">
                                {!! Form::text(
                                'license_number',
                                Auth::user()->license_number,
                                ['class' => 'form-control']
                                )!!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label(
                            'brokerage_firm_name',
                            'Firm Name*',
                            ['class' => 'col-md-3 control-label']
                            )!!}

                            <div class="col-md-6">
                                {!! Form::text(
                                'brokerage_firm_name',
                                Auth::user()->brokerage_firm_name,
                                ['class' => 'form-control']
                                )!!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label(
                            'notification_preference',
                            'Notification Preference',
                            ['class' => 'col-md-3 control-label']
                            )!!}

                            <div class="col-md-6">
                                <label class="padding-right-30">
                                    {!! Form::radio(
                                    'notification_preference',
                                    1,
                                    (1 == Auth::user()->notification_preference) ? 1 : null,
                                    array('class' => 'minimal')
                                    ) !!} text
                                </label>
                                <label class="padding-right-30">
                                    {!! Form::radio(
                                    'notification_preference',
                                    0,
                                    (0 == Auth::user()->notification_preference) ? 1 : null,
                                    array('class' => 'minimal')
                                    ) !!} email
                                </label>
                                <label class="padding-right-30">
                                    {!! Form::radio(
                                    'notification_preference',
                                    2,
                                    (2 == Auth::user()->notification_preference) ? 1 : null,
                                    array('class' => 'minimal')
                                    ) !!} both
                                </label>
                            </div>
                        </div>

                        <div class="form-group">

                           <label for="first_name" class="col-md-3 control-label">User Type</label>

                           <?php $userType =  Auth::user()->user_type?>
                           <div class="col-md-6">
                            @if($userType == 1)

                            <p style="padding-top: 8px;font-weight: bold;">Posting agent</p>


                            @elseif($userType == 2)

                            <p style="padding-top: 8px;font-weight: bold;">Showing agent</p>
                            

                            @else

                            <p style="padding-top: 8px;font-weight: bold;">Both</p>
                            
                            @endif 


                        </div>
                    </div>


                    <div class="form-group">
                        {!! Form::label(
                        'personal_bio',
                        'Personal Bio',
                        ['class' => 'col-md-3 control-label']
                        )!!}

                        <div class="col-md-6">
                            {!! Form::textarea(
                            'personal_bio',
                            Auth::user()->personal_bio,
                            ['class' => 'form-control', 'rows' => '2']
                            )!!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label(
                        'email',
                        'Email*',
                        ['class' => 'col-md-3 control-label']
                        )!!}

                        <div class="col-md-6">
                            {!! Form::text(
                            'email',
                            Auth::user()->email,
                            ['class' => 'form-control']
                            )!!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label(
                        'password',
                        'Password',
                        ['class' => 'col-md-3 control-label']
                        )!!}

                        <div class="col-md-6">
                            {!! Form::password(
                            'password',
                            ['class'=>'form-control', 'autocomplete'=>'off']
                            )!!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label(
                        'password_confirmation',
                        'Confirm Password',
                        ['class' => 'col-md-3 control-label']
                        )!!}

                        <div class="col-md-6">
                            {!! Form::password(
                            'password_confirmation',
                            ['class'=>'form-control']
                            )!!}
                        </div>
                    </div>






                    <div class="form-group text-center">
                        {!! Form::submit(
                        'Save Info',
                        ['class'=>'btn btn-lg btn-primary ']
                        )!!}
                    </div>
                </fieldset>

                {!! Form::close() !!}



                <iframe src='{{ url("change-image") }}' frameborder="0" id='ifr_changeProfileImg'></iframe>



                <!-- New chnage for show user type yogi -->

                <div class="row">
                    <div class="col-lg-12   ">
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
                        'class' => 'form-horizontal col-lg-9',
                        'autocomplete' => 'off',
                        'url' => 'upgrade-agent',
                        'id' => 'frm_agentTypeForm',

                        ])
                        !!}
                        <?php $userType =  Auth::user()->user_type?>
                        @if($userType == 2 || $userType == 1 )

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
                                    1 => 'Posting Agent',
                                    2 => 'Showing Agent',
                                    3 => 'Both Showing and Posting'

                                    ], $billingInfo['user_type'],
                                    ['class' => 'form-control',
                                    'onchange' => 'changeUserType
                                    (\'profile-info\')']
                                    )!!}
                                </div>
                            </div>
                        </fieldset>
                        @endif
                        {!! Form::close() !!}
                        <div class="panel-body">
                            <!-- Panel-group Start -->
                            <div class="panel-group col-lg-8" id="accordion" style="  margin-left: 2%;">
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
                                                    <div id="loading" class="panel-body">
                                                        {!! Form::open(
                                                        [
                                                        'novalidate' => 'novalidate',
                                                        'files' => TRUE,
                                                        'method' => '',
                                                        'url' => '',
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
                                                            <div style="display:none" class="alert alert-danger alert-dismissable form-group text-center" id="msgDiv"></div>
                                                            <div style="display:none" class="alert alert-success alert-dismissable form-group text-center" id="SmsgDiv"></div>
                                                              
                                                        
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
                                                                <div style="display:none" class="alert alert-danger alert-dismissable form-group text-center" id="NmsgDiv"></div>
                                                                 <div style="display:none" class="alert alert-success alert-dismissable form-group text-center" id="NSmsgDiv"></div>
                                                            </fieldset>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </div>
                                                    <!-- //Panle-group End -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center col-lg-9">
                                            <button class="btn btn-md btn-primary nbtn"
                                            onclick="$('#frm_agentTypeForm').submit()" disabled="true">Upgrade
                                            Agent Type</button>
                                                   <!--  <a href="/home"><button class="btn btn-md
                                                   btn-danger">Cancel</button></a> -->
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>


                           </div>

                           <!-- End new change  -->













                       </div>
                   </div>
               </div>
           </div>
           @endsection
