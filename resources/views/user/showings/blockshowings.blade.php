
@extends('layouts.dashboard')

<!-- Page level CSS files -->
@section('header_styles')
{!! Minify::stylesheet(array(
  '/assets/css/jquery.ui.theme.css',
  '/assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css',
  '/assets/css/star-rating.min.css',

  )) !!}
  @endsection
  <!-- Page level CSS files -->

  <!-- Page level JS files -->
  @section('footer_scripts')
  {!! Minify::javascript(array(
  '/assets/js/star-rating.min.js',
  '/assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js',
  '/assets/vendors/validation/dist/js/bootstrapValidator.min.js',
  '/assets/js/validation.js',

  '/assets/js/user/showings.js',

  )) !!}
  @endsection
  <!-- Page level JS files -->

  @section('section-content')

  <!-- Modal -->
  <?php  $statusKey = array('0'=>'No','1'=>'Yes','2'=>'May Be');
  ?>
  <div id="myModalBlockPost" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Block payment</h4>
        </div>
        <div class="modal-body">

         {!! Form::open(
         array(
         'novalidate' => 'novalidate',
         'method' => 'POST',
         'url' => '',
         'class' => 'form-horizontal',
         'width' => '100%',
         'autocomplete' => 'off',
         'id' => 'frm_feedbackForm',
         ))
         !!}


         <fieldset>


           {!! Form::hidden(
           'showing_id',
           $showing->id,
           array('id'=>'showing_id','class' => 'form-control', 'rows' => '4' )
           ) !!}
           <div class="form-group">
            {!! Form::label(
            'comments',
            'Comments ',
            ['class' => 'col-md-4 control-label']
            )!!}

            <div class="col-md-6">
              {!! Form::textarea(
              'feedback_comment',
              null,
              array('class' => 'form-control feedback', 'rows' => '4' )
              ) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label(
            'comments',
            ' ',
            ['class' => 'col-md-4 control-label']
            )!!}

            <div id="errmsg" class="col-md-6">

            </div>
          </div>
        </fieldset>
        {!! Form::close() !!}


      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" data-loading-text="Saving..." type="button"
        onclick="submitBlockComment(this)">Submit</button>
      </div>

    </div>

  </div>
</div>


<!-- error Dilog -->

<div id="myModalerrorBlock" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Block payment</h4>
      </div>
      <div class="modal-body">



        <fieldset>

         <p>You have no permission</p>

       </fieldset>

     </div>

   </div>

 </div>
</div>

<!-- Review Model -->
<div id="myModalReviewPost" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Review the showing agent</h4>
      </div>
      <div class="modal-body">

       {!! Form::open(
       array(
       'novalidate' => 'novalidate',
       'method' => 'POST',
       'url' => '',
       'class' => 'form-horizontal',
       'width' => '100%',
       'autocomplete' => 'off',
       'id' => 'frm_feedbackForm',
       ))
       !!}


       <fieldset>


         {!! Form::hidden(
         'showing_id',
         $showing->id,
         array('id'=>'newshowing_id','class' => 'form-control', 'rows' => '4' )
         ) !!}


         <div class="form-group">
          <label for="input-1" class="col-md-4 control-label">Rating</label>

          <div id="nwerating" class="col-md-6">
            <input type="hidden" id="input-1" name="input-1" value="4.3" class="rating-loading">
            <input style="font-size:19px !important;" id="input-1" name="input-1" class="rating rating-loading" data-min="0" data-max="5" data-step="1">
          </div>
        </div>






        <div class="form-group">
          {!! Form::label(
          'comments',
          'Comments ',
          ['class' => 'col-md-4 control-label']
          )!!}

          <div class="col-md-6">
            {!! Form::textarea(
            'feedback_comment',
            null,
            array('class' => 'form-control revfeedback', 'rows' => '4' )
            ) !!}
          </div>
        </div>
        <div class="form-group">
          {!! Form::label(
          'comments',
          ' ',
          ['class' => 'col-md-4 control-label']
          )!!}

          <div id="errmesssg" class="col-md-6">

          </div>
        </div>


      </fieldset>
      {!! Form::close() !!}


    </div>
    <div class="modal-footer">
      <button class="btn btn-primary" data-loading-text="Saving..." type="button"
      onclick="submitReviewComment(this)">Submit</button>
    </div>

  </div>

</div>
</div>

<!--  -->

<div class="row">
  <div class="col-lg-8 col-md-offset-2">
    <div id="dv_postShowing" class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title">
          <i class="livicon" data-name="edit" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>
          Showing
        </h3>
      </div>


      <div class="panel-body">
        <fieldset>


         <div class="form-group">
          {!! Form::label(
          'post_date',
          'Date of showing',
          ['class' => 'col-md-3 control-label']
          )!!}

          <div class="col-md-8">


           {!! Form::label(
           'post_date',
           $showing->post_date,
           ['class' => 'col-md-8 control-label']
           )!!}

         </div>
       </div>
       <div class="form-group">
        {!! Form::label(
        'post_date',
        'Customer Name',
        ['class' => 'col-md-3 control-label']
        )!!}
        <div class="col-md-8">
         {!! Form::label(
         'post_date',
         $showing->customer_name,
         ['class' => 'col-md-8 control-label']
         )!!}
       </div>
     </div>
     <div class="form-group">
      {!! Form::label(
      'post_date',
      'Customer Email',
      ['class' => 'col-md-3 control-label']
      )!!}
      <div class="col-md-8">
       {!! Form::label(
       'Customer Email',
       $showing->customer_email,
       ['class' => 'col-md-8 control-label']
       )!!}
     </div>
   </div>
   <div class="form-group">
    {!! Form::label(
    'post_date',
    'Phone Number',
    ['class' => 'col-md-3 control-label']
    )!!}
    <div class="col-md-8">
     {!! Form::label(
     '',
     $showing->customer_phone_number,
     ['class' => 'col-md-8 control-label']
     )!!}
   </div >
 </div>





 <div class="form-group">
  {!! Form::label(
  'post_date',
  'Additional Fee',
  ['class' => 'col-md-3 control-label']
  )!!}
  <div class="col-md-8">
   {!! Form::label(
   '',
   $showing->additional_fee,
   ['class' => 'col-md-8 control-label']
   )!!}
 </div>
</div>

<div class="form-group">
  {!! Form::label(
  'post_date',
  'Comment',
  ['class' => 'col-md-3 control-label']
  )!!}
  <div class="col-md-8">
   {!! Form::label(
   '',
   $showing->comments,
   ['class' => 'col-md-8 control-label']
   )!!}
 </div >
</div>


</fieldset>

<hr>
<p><b>Feedback submitted by showing agent:</b></p>

<div class="form-group">
  {!! Form::label(
  'post_date',
  ' Did the client show up',
  ['class' => 'col-md-7 control-label']
  )!!}
  <div class="col-md-5">
   {!! Form::label(
   '',
   $statusKey[$ufr->client_show_up],
   ['class' => 'col-md-8 control-label']
   )!!}
 </div >
</div>





<div class="form-group">
  {!! Form::label(
  '',
  ' Does the client want to submit an offer',
  ['class' => 'col-md-7 control-label']
  )!!}
  <div class="col-md-5">
   {!! Form::label(
   '',
   $statusKey[$ufr->client_submit_offer],
   ['class' => 'col-md-8 control-label']
   )!!}
 </div>
</div>
<div class="form-group">
  {!! Form::label(
  '',
  'Does the client have further questions',
  ['class' => 'col-md-7 control-label']
  )!!}
  <div class="col-md-5">
   {!! Form::label(
   '',
   $statusKey[$ufr->client_question],
   ['class' => 'col-md-8 control-label']
   )!!}
 </div>
</div>

<div class="form-group">
  {!! Form::label(
  '',
  'Comments',
  ['class' => 'col-md-7 control-label']
  )!!}
  <div class="col-md-5">
   {!! Form::label(
   '',
   $ufr->feedback_comment,
   ['class' => 'col-md-8 control-label']
   )!!}
 </div>
</div>








<?php
$expiry_date = date('Y-m-d H:i:s',strtotime($showing->updated_at) + 3600*10);
?>

<br> <br> <br>
<div class="form-group text-center">
 @if ($expiry_date > date('Y-m-d H:i:s') ) 

 {!! Form::submit(
 'Block payment',
 ['class'=>'btn btn-lg btn-primary' , 'onclick'=>"blockShowing()"]
 )!!}


 @else


 
 {{ \Session::flash('flash_error_message',
 'You have no permission!!')}}
 @endif


 {!! Form::submit(
 'Review the showing agent',
 ['class'=>'btn btn-lg btn-primary','onclick'=>"reviewShowing()"]
 )!!}

</div>

</div>


</div>
</div>
</div>


@endsection