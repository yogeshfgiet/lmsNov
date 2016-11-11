Hi {{$showingDetails[0]['sa_first_name']}},
<br><br>
Your showing has been approved. Please login to LMS application and check details.
<br><br>
<b>Posting Agent Details:</b><br>
Name: {{$showingDetails[0]['pa_first_name'] . ' '.
$showingDetails[0]['pa_last_name']}}<br>
Email: {{$showingDetails[0]['pa_email']}}<br>
Phone: {{$showingDetails[0]['pa_phone_number']}}<br><br>
<b>Client Details:</b><br>
Name: {{$showingDetails[0]['customer_name']}}<br>
Email: {{$showingDetails[0]['customer_email']}}<br>
Phone: {{$showingDetails[0]['customer_phone_number']}}<br><br>
Date of showing: {{date("m-d-Y",
strtotime($showingDetails[0]['post_date']))}}<br>
Earliest start time: {{date("m-d-Y H:i:s",
strtotime($showingDetails[0]['start_time']))}}<br>
Latest start time: {{date("m-d-Y H:i:s",
strtotime($showingDetails[0]['end_time']))}}<br><br>
<b>House Details:</b><br>
@foreach ($showingDetails as $showing)
House address: {{$showing['address']}}<br>
MLS Numbers: {{$showing['MLS_number']}}<br>
Amount Being Paid: {{$showing['list_price']}}<br>
<br>
@endforeach
Additional Comments: {{$showingDetails[0]['comments']}}
<br><br>
Thanks,<br>
Team LMS