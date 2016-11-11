@extends('layouts.dashboard')

<!-- Page level CSS files -->
@section('header_styles')
{!! Minify::stylesheet(array(
    '/assets/vendors/datatables/css/dataTables.colReorder.min.css',
    '/assets/vendors/datatables/css/dataTables.scroller.min.css',
    '/assets/vendors/datatables/css/dataTables.bootstrap.css',
    '/assets/css/pages/tables.css',
)) !!}
@endsection

<!-- Page level JS files -->
@section('footer_scripts')
{!! Minify::javascript(array(

    
)) !!}
@endsection

@section('section-content')


<div class="row">
    <div class="col-lg-12">
        <div class="tabbable-panel">
            <div class="tabbable-line">
               
                <div class="tab-content">
                 <!--    <div class="tab-pane active" id="tab_default_1">
                        <br />
                        <div id="showings_map"></div>
                        <br />
                    </div> -->
                    <div class="tab-pane active" id="tab_default_2">
                        <br />
                        <div id="dv_registration" class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="livicon" data-name="edit" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>
                                    Email Template
                                </h3>
                            </div>

                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <ul>
                                            <?php 
                                            $t=(empty($t)) ? "1":$t;
                                            foreach($template as $v) { 

                                            $cls=($v->id==$t) ? "active_template":"";

                                            ?>
                                            <li><a class="<?php echo $cls;?>" href="?t=<?php echo base64_encode($v->id); ?>"><?php echo $v->dis_name; ?></a>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>

                                     <div class="col-md-8">

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
                                        'method' => 'POST',
                                        'class' => 'form-horizontal col-lg-12',
                                        'autocomplete' => 'on',
                                        'id' => 'tmp_postShowingForm',


                                        ))
                                        !!}

                                        {!! csrf_field() !!}



                                        <div class="form-group">
                                            {!! Form::label(
                                            'subject',
                                            'Subject',
                                            ['class' => 'col-md-4 control-label']
                                            )!!}
                                             {!! Form::hidden('id',  $model->id)!!}
                                            <div class="col-md-8">
                                                {!! Form::text(
                                                'subject',
                                                $model->subject,
                                                ['class' => 'form-control',
                                                'placeholder' => 'email subject',
                                                
                                                ]
                                                )!!}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            {!! Form::label(
                                            'content',
                                            'Body',
                                            ['class' => 'col-md-4 control-label']
                                            )!!}

                                            <div class="col-md-8">
                                                {!! Form::textarea('content',$model->content,['class'=>'form-control','rows' => 10, 'cols' => 50]) !!}
                                            </div>
                                        </div>

                                        <div class="alert alert-success alert-dismissable form-group" style="width:66%;margin-left: 228px;">
                                            Available variables start with '{{' please do not change these variables!!
                                        </div>


                                        <div class="form-group text-center">
                                            {!! Form::submit(
                                            'Save',
                                            ['class'=>'btn btn-lg btn-primary']
                                            )!!}
                                        </div>

                                         {!! Form::close() !!}
                                     </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
