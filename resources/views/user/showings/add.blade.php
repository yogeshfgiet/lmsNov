@extends('layouts.dashboard')

<!-- Page level CSS files -->
@section('header_styles')
{!! Minify::stylesheet(array(
'/assets/css/jquery.ui.theme.css',
'/assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css',
)) !!}
@endsection
<!-- Page level CSS files -->

<!-- Page level JS files -->
@section('footer_scripts')
{!! Minify::javascript(array(
'/assets/js/jquery.ui.min.js',
'/assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js',
'/assets/vendors/validation/dist/js/bootstrapValidator.min.js',
'/assets/js/jquery.validate.js',
'/assets/js/validation.js',
'/assets/js/user/showings.js',
'/assets/js/user/newmask.js',


)) !!}
@endsection
<!-- Page level JS files -->

@section('section-content')
<style>
.error{
    color:#a94442;
}
</style>
<div class="row">
    <div class="col-lg-8 col-md-offset-2">
        <div id="dv_postShowing" class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="livicon" data-name="edit" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>
                    Add Showing
                </h3>
            </div>

            <div class="panel-body">
                @if (isset($errors) && (count($errors) > 0))
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
                'method' => 'POST',
                'class' => 'form-horizontal col-lg-12',
                'autocomplete' => 'off',
                'id' => 'frm_postShowingForm',
                ))
                !!}

                {!! csrf_field() !!}
                <fieldset>
                    <div class="form-group">
                        {!! Form::label(
                        'post_date',
                        'Date of Showing',
                        ['class' => 'col-md-4 control-label']
                        )!!}

                        <div class="col-md-8">
                            {!! Form::text(
                            'post_date',
                            null,
                            ['class' => 'form-control date-picker cpointer',
                            'placeholder' => 'Date of Showing',
                            'readonly' => true
                            ]
                            )!!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label(
                        'start_time',
                        'Earliest Start Time',
                        ['class' => 'col-md-4 control-label']
                        )!!}

                        <div class="col-md-8">
                            {!! Form::text(
                            'start_time',
                            null,
                            ['class' => 'form-control date-time-picker cpointer',
                            'placeholder' => 'Earliest Start Time',
                            'readonly' => true
                            ]
                            )!!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label(
                        'end_time',
                        'Latest Start Time',
                        ['class' => 'col-md-4 control-label']
                        )!!}

                        <div class="col-md-8">
                            {!! Form::text(
                            'end_time',
                            null,
                            ['class' => 'form-control date-time-picker cpointer',
                            'placeholder' => 'Latest Start Time',
                            'readonly' => true
                            ]
                            )!!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label(
                        'customer_name',
                        'Customer Name',
                        ['class' => 'col-md-4 control-label']
                        )!!}

                        <div class="col-md-8">
                            {!! Form::text(
                            'customer_name',
                            null,
                            ['class' => 'form-control',
                            'placeholder' => 'Customer Name']
                            )!!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label(
                        'customer_email',
                        'Customer Email',
                        ['class' => 'col-md-4 control-label']
                        )!!}

                        <div class="col-md-8">
                            {!! Form::text(
                            'customer_email',
                            null,
                            ['class' => 'form-control',
                            'placeholder' => 'Customer Email']
                            )!!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label(
                        'customer_phone_number',
                        'Customer Phone',
                        ['class' => 'col-md-4 control-label']
                        )!!}

                        <div class="col-md-8">

                          <input id="phone" class="form-control  "  type="tel" name="customer_phone_number" value=""  required>
                           
                        </div>
                       
                    </div>



                    <div class="form-group">
                        {!! Form::label(
                        'comments',
                        'Additional Comments',
                        ['class' => 'col-md-4 control-label']
                        )!!}

                        <div class="col-md-8">
                            {!! Form::textarea(
                            'comments',
                            null,
                            ['class' => 'form-control',
                            'placeholder' => 'Additional Comments',
                            'rows' => 2]
                            )!!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label(
                        'additional_fee',
                        'Additional Fee You Will Pay',
                        ['class' => 'col-md-6 control-label']
                        )!!}
                        <div style=" padding: 7px 0 0; width: 0;" class="col-md-1 ">$</div>
                        <div class="col-md-5" style="padding-left:13px">
                            {!! Form::text(
                            'additional_fee',
                            null,
                            ['class' => 'form-control ',
                            'style'=>'width:122%']
                            )!!}
                        </div>
                    </div>



                    <div class="form-group">
                        {!! Form::label(
                        'house_count',
                        'Number of Houses',
                        ['class' => 'col-md-6 control-label']
                        )!!}

                        <div class="col-md-6">
                            {!! Form::selectRange(
                            'house_count',
                            1,
                            $maxNoOfHouses,
                            1,
                            ['class' => 'form-control',
                            'onchange' => 'changeHouseCount()']
                            )!!}
                        </div>
                    </div>

                    <div class="form-group" id="dv_houseDetails">
                        <div class="panel-group" id="dv_accordionCat">
                            <div class="panel panel-default panel-faq"
                                 id="dv_houseDetails1">
                                <div class="panel-heading">
                                    <a data-toggle="collapse"
                                       data-parent="#dv_accordionCat" href="#dv_houseCount1">
                                        <h4 class="panel-title">
                                            House Details <span
                                                class="sp_houseCount">1</span>
                                            <span class="pull-right"></span>
                                        </h4>
                                    </a>
                                </div>
                                <div id="dv_houseCount1" class="panel-collapse
                                     collapse newvalidation">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            {!! Form::textarea(
                                            'address[]',
                                            null,
                                            ['class' => 'form-control address',
                                            'placeholder' => 'Address',
                                            'rows' => 2]
                                            )!!}
                                        </div>
                                        <!-- Change By Sandeep -->
                                
                                        
                                        

                                        <div class="form-group">
                                            {!! Form::input('text',
                                            'unit_number[]',
                                            null,
                                            ['class' => 'form-control unit_number',
                                            'placeholder' => 'Unit number'
                                           ]
                                            )!!}
                                        </div>
                                           <div class="form-group">
                                            {!! Form::select(
                                            'state[]',
                                            $states, 6,
                                            ['class' => 'form-control state','placeholder' => 'State']
                                            )!!}
                                        </div>
                                        <div class="form-group">
                                            {!! Form::text(
                                            'city[]',
                                            null,
                                            ['class' => 'form-control city',
                                            'placeholder' => 'City'
                                            ]
                                            )!!}
                                        </div>


                                     

                                        <div class="form-group">
                                            {!! Form::text(
                                            'zip[]',
                                            null,
                                            ['class' => 'form-control zip',
                                            'placeholder' => 'Zip'
                                            ]
                                            )!!}
                                        </div>


                                        <!-- End By Sandeep -->

                                        <div class="form-group">
                                            {!! Form::text(
                                            'MLS_number[]',
                                            null,
                                            ['class' => 'form-control MLS_number',
                                            'placeholder' => 'MLS #']
                                            )!!}
                                        </div>

                                        <div class="form-group">
                                            {!! Form::text(
                                            'list_price[]',
                                            '$20',
                                            ['class' => 'form-control
                                            showing-list-price list_price',
                                            'placeholder' => 'List price',
                                             'readonly' => '1']
                                            )!!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="hid_houseCount"
                               id="hid_houseCount" value="1">
                    </div>

                    <div class="form-group text-green" id="dv_paymentDetails">
                        <div class="panel-body pull-right">
                            <dl class="dl-horizontal">
                                <dt>Total</dt>
                                <dd id="dd_totalPayment">$30</dd>
                            </dl>

                            <dl class="dl-horizontal">
                                <dt>Amount you will pay agent</dt>
                                <dd id="dd_agentPayment">
                                    $20
                                </dd>
                                <dt>Amount you pay LMS</dt>
                                <dd id="dd_lmsPayment">$15</dd>
                            </dl>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        {!! Form::submit(
                        'Save Info',
                        ['class'=>'btn btn-lg btn-primary']
                        )!!}
                    </div>
                </fieldset>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
