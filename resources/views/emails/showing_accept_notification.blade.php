Hello {{$receiverDetails['0']['0']->pa_first_name}},
<br /><br />
Your showing has been accepted. Please check details by login into LMS.
<br /><br />

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
		 date('m-d-Y h:i A', strtotime($receiverDetails['0']['0']->start_time)),
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
		date('m-d-Y  h:i A', strtotime($receiverDetails['0']['0']->expiration_time)),
		
		['class' => 'col-md-7 control-label']
		)!!}


	</div>
</div><br>




<?php $count= 1;?>
@foreach ($receiverDetails['0'] as $housedetail)

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
		$receiverDetails['0']['0']->sa_first_name. ' ' .$receiverDetails['0']['0']->sa_last_name,
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
		$receiverDetails['0']['0']->sa_phone_number,
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
		$receiverDetails['0']['0']->sa_email,
		['class' => 'col-md-7 control-label']
		)!!}


	</div>


</div>



<br /><br />
Thanks,<br />
Team LMS
