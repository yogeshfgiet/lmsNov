Hello {{ $receiverDetails['data']['0']->pa_first_name }},
<?php  $statusKey = array('0'=>'No','1'=>'Yes','2'=>'May Be');
?>


<br/><br/>
Your showing has been completed. Please login to LMS application and check details.
<br/><br/><br/>



<div>

<b>Showing details:</b><br><br>
<div>

    <div class="form-group">
        {!! Form::label(
        'Showing Start Date',
        'Start date',
        ['class' => 'col-md-5 control-label']
        )!!}

        :


        {!! Form::label(
        'post_date',
        date('m-d-Y h:i A',strtotime($receiverDetails['data']['0']->start_time)),
        
        ['class' => 'col-md-4 control-label']
        )!!}

    </div><br>


    <div class="form-group">
        {!! Form::label(
        'Showing end date',
        'End Date',
        ['class' => 'col-md-5 control-label']
        )!!}

        :


        {!! Form::label(
        'post_date',
        date('m-d-Y h:i A',strtotime($receiverDetails['data']['0']->expiration_time)),
        
        ['class' => 'col-md-7 control-label']
        )!!}


    </div>
</div><br>




<?php $count= 1;?>

@foreach($receiverDetails['data'] as $housedetail)


<b>House details{!!$count!!}:</b><br><br>
<div> 
    <div class="form-group">
        {!! Form::label(
        'Showing Address',
        'Address',
        ['class' => 'col-md-5 control-label']
        )!!} :




        {!! Form::label(
        'post_date',
        $housedetail->address,
        ['class' => 'col-md-7 control-label']
        )!!}


    </div><br>
    <div class="form-group">
        {!! Form::label(
        '',
        'City',
        ['class' => 'col-md-5 control-label']
        )!!} :




        {!! Form::label(
        'post_date',
        $housedetail->city,
        ['class' => 'col-md-7 control-label']
        )!!}


    </div><br>
    <div class="form-group">
        {!! Form::label(
        'feedback_comment',
        'State',
        ['class' => 'col-md-5 control-label']
        )!!} :




        {!! Form::label(
        'post_date',
        $states[$housedetail->state],
        ['class' => 'col-md-7 control-label']
        )!!}


    </div><br>
    <div class="form-group">
        {!! Form::label(
        'feedback_comment',
        'Country',
        ['class' => 'col-md-5 control-label']
        )!!} :




        {!! Form::label(
        'post_date',
        'USA',
        ['class' => 'col-md-7 control-label']
        )!!}


    </div>

</div><br>
<?php $count++;?>

@endforeach

</div>   
<b>Showing agent details:</b>   <br><br>    
<div>
    <div class="form-group">
        {!! Form::label(
        'feedback_comment',
        'Name',
        ['class' => 'col-md-5 control-label']
        )!!} :


        {!! Form::label(
        'post_date',
        $receiverDetails['data']['0']->sa_first_name,
        ['class' => 'col-md-7 control-label']
        )!!}


    </div>  <br>  
    <div class="form-group">
        {!! Form::label(
        'feedback_comment',
        'Phone number',
        ['class' => 'col-md-5 control-label']
        )!!} :


        {!! Form::label(
        'post_date',
        $receiverDetails['data']['0']->sa_phone_number,
        ['class' => 'col-md-7 control-label']
        )!!}


    </div>  <br>  
    <div class="form-group">
        {!! Form::label(
        'feedback_comment',
        'Email',
        ['class' => 'col-md-5 control-label']
        )!!} :


        {!! Form::label(
        'post_date',
        $receiverDetails['data']['0']->sa_email,
        ['class' => 'col-md-7 control-label']
        )!!}


    </div>


</div>
<br>
<b>Feedback submitted by showing agent:</b>
<br>
<br>
 <div>

                 <div class="form-group">
                        {!! Form::label(
                            'Client show up',
                        ' 1. Did the client show up',
                            ['class' => 'col-md-5 control-label']
                        )!!}

                       :
                     
                            
                             {!! Form::label(
                      		'post_date',
                           $statusKey[$receiverDetails['feed']['client_show_up']],
                            ['class' => 'col-md-4 control-label']
                        )!!}
                      
                   

                    </div><br>


                      <div class="form-group">
                        {!! Form::label(
                            'submit_offer',
                            '2. Does the client want to submit an offer',
                            ['class' => 'col-md-5 control-label']
                        )!!}

                        :
                     
                            
                             {!! Form::label(
                            'post_date',
                          $statusKey[$receiverDetails['feed']['client_submit_offer']],
                            ['class' => 'col-md-7 control-label']
                        )!!}
                      
                       
                         </div><br>

                      <div class="form-group">
                        {!! Form::label(
                            'further_questions',
                            '3. Does the client have further questions',
                            ['class' => 'col-md-5 control-label']
                        )!!}
                        :
                        
                     
                            
                             {!! Form::label(
                            'post_date',
                             $statusKey[ $receiverDetails['feed']['client_question']],
                            ['class' => 'col-md-7 control-label']
                        )!!} 
                      
                        
                         </div><br>

                       <div class="form-group">
                        {!! Form::label(
                            'feedback_comment',
                            '4. Comments',
                            ['class' => 'col-md-5 control-label']
                        )!!} :

                        
                     
                            
                             {!! Form::label(
                            'post_date',
                              $receiverDetails['feed']['feedback_comment'],
                            ['class' => 'col-md-7 control-label']
                        )!!}
                      
                       
                         </div>
                         <br>
                         <br>

                         <div class="modal-footer">
           <a href="{{ URL::to('showings/blockshowings/'.$receiverDetails['data']['0']->id )}}" class="btn btn-default">Block Payment</a>
       | <a href="{{ URL::to('showings/blockshowings/'.$receiverDetails['data']['0']->id) }}" class="btn btn-default">Review the showing agent</a>
        </div>
        




</div>


<br>
<!-- <a href="">{{ URL::to('showings/') }}</a> -->
Thanks,<br />
Team LMS
