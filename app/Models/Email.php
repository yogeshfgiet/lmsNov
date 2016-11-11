<?php namespace App\Models;

use App\Models\State;
use App\Models\EmailTemplate;
use Mail;

class Email {

    /*
      |--------------------------------------------------------------------------
      | Email Model
      |--------------------------------------------------------------------------
      |
      | This Model will create the functions and messages to send in email
      |
     */

    /**
     * Method that will notify posting agent about the showing has been
     * accepted
     *
     * @param array $receiverDetails array of showing info
     *
     * @return object query builder object
     */
    public function sendShowingAcceptNotification($receiverDetails)
    {

        $states = (new State())->getAllStatesByCountryId();
        //start old code for email
        /*
        Mail::send('emails.showing_accept_notification',
            ['receiverDetails' => $receiverDetails,'states'=>$states], function ($message) use ($receiverDetails)
            {
            $message->from('lms@da.com', 'LMS')
                ->subject('Showing Accepted');
            $message->to($receiverDetails['0']['0']->pa_email);
        });*/
        //end code for old email

        //start code of email according to template

$template = EmailTemplate::whereName('showing_selected_notification')->first();

$img_url=asset('assets/img/logo.png');

$start_time=date('m-d-Y h:i A', strtotime($receiverDetails['0']['0']->start_time));

$end_time=date('m-d-Y h:i A', strtotime($receiverDetails['0']['0']->expiration_time));

$post_date=date('m-d-Y h:i A', strtotime($receiverDetails['0']['0']->post_date));


$house_str='';
$j=1;
foreach ($receiverDetails['0'] as $housedetail)
{ 

   $house_detail='';
   $house_detail.="<b>House Details $j: </b><br/><br/>";
   $house_detail.="Address: ".$housedetail->address." <br/><br/>";
   $house_detail.="Unit: ".$housedetail->unit_number." <br/><br/>";
   $house_detail.="City: ".$housedetail->city." <br/><br/>";
   $house_detail.="Zip: ".$housedetail->zip." <br/><br/>";
   $house_detail.="State: ".$states[$housedetail->state]." <br/><br/>";
   $house_str.=$house_detail;
   $j++;

}

$srch_array = array(
    "{{posting_agent_first_name}}" => $receiverDetails['0']['0']->pa_first_name,
    "{{insert_showing_date}}" => $post_date,
    "{{link_to_lms_login}}" => url(),
    "{{date_of_showing}}" => $post_date,
    "{{start_time}}" => $start_time,
    "{{end_time}}" => $end_time,
    "{{logo_url}}" =>"<img style='width:175px' src='$img_url'>",
    "{{site_url}}" => $template->from_name,
    "{{from_email}}" => $template->from_email_id,
    "{{showing_agent_first_name}}"=>$receiverDetails['0']['0']->sa_first_name. ' ' .$receiverDetails['0']['0']->sa_last_name,
    "{{showing_agent_phone_number}}"=>$receiverDetails['0']['0']->sa_phone_number,
    "{{showing_agent_email}}"=>$receiverDetails['0']['0']->sa_email,

    "{{house_details}}"=>$house_str,

    );

$subject_array=array( 
    "{{insert_showing_date}}" => $post_date
    );

$email_values = EmailTemplate::getvalues($template, $srch_array,$subject_array);

       //dd($email_values->content);


Mail::send(['html'=>'emails.new_showing_accept_notification'],
    ['receiverDetails' => $email_values->content], function ($message) use
    ($receiverDetails,$email_values)
    {
        $message->from($email_values->from_email_id, $email_values->from_name)
        ->subject($email_values->subject);

        $message->to($receiverDetails['0']['0']->pa_email);
    });


}

    /**
     * Method that will notify posting agent about the showing has been
     * accepted
     *
     * @param array $receiverDetails array of showing info
     *
     * @return object query builder object
     */
    public function sendShowingCompleteNotification($receiverDetails)
    {



       $states = (new State())->getAllStatesByCountryId();
       Mail::send('emails.showing_complete_notification',
        ['receiverDetails' => $receiverDetails,'states'=>$states], function ($message) use
        ($receiverDetails)
        {
            $message->from('lms@da.com', 'LMS')
            ->subject('Showing Completed');

            $message->to($receiverDetails['data']['0']->pa_email);
        });
   }

    /**
     * Method that will notify showing agent about the showing has been
     * modified
     *
     * @param array $receiverDetails array of showing info
     * @param string edit type
     * @return object query builder object
     */
    public function sendShowingEditNotification($receiverDetails, $editType)
    {
        Mail::send('emails.showing_edit_notification',
            ['receiverDetails' => $receiverDetails,
            'editType' => $editType], function ($message) use
            ($receiverDetails)
            {
                $message->from('lms@da.com', 'LMS')
                ->subject('Showing Edited');

                $message->to($receiverDetails['email']);
            });
    }


    /**
     * Method that will notify showing agent about the showing has been
     * modified
     *
     * @param array $receiverDetails array of showing info
     * @param string edit type
     * @return object query builder object
     * method send email by using template
     */
    public function newShowingEditNotification($receiverDetails, $editType,$showing_info)
    {

        //email template code start here
        $template = EmailTemplate::whereName('send_showing_edit_notification')->first();

        $img_url=asset('assets/img/logo.png');
        


        $srch_array = array(
            "{{agent_first_name}}" => $receiverDetails['first_name'],
            "{{insert_showing_date}}" => $showing_info['post_date'],
            "{{link_to_lms_login}}" => url(),
            "{{date_of_showing}}" => $showing_info['post_date'],
            "{{start_time}}" => $showing_info['start_time'],
            "{{end_time}}" => $showing_info['end_time'],
            "{{logo_url}}" =>"<img  style='width:175px' src='$img_url'>",
            "{{site_url}}" => $template->from_name,
            "{{from_email}}" => $template->from_email_id,

            );

        $subject_array=array( 
            "{{Insert_showing_date}}" => $showing_info['post_date']
            );

        $email_values = EmailTemplate::getvalues($template, $srch_array,$subject_array);

       // dd($email_values->subject);


        Mail::send(['html'=>'emails.new_edit_notification'],
            ['receiverDetails' => $email_values->content], function ($message) use
            ($receiverDetails,$email_values)
            {
                $message->from($email_values->from_email_id, $email_values->from_name)
                ->subject($email_values->subject);

                $message->to($receiverDetails['email']);
            });
    }

    /**
     * Method that will notify posting agent about the showing has been
     * saved
     *
     * @param array $post_details array of showing info
     * @param object posting_agent_info_obj
     * @return object query builder object
     * method send email by using template
     */
    public function showingSaveNotification($post_details,$posting_agent_info_obj)
    {

        //email template code start here
        $template = EmailTemplate::whereName('save_showing_email')->first();

        $img_url=asset('assets/img/logo.png');
        
        $postDate = date('Y-m-d', strtotime($post_details['post_date']));
        $start_time=$postDate . " ". date('H:i:s', strtotime($post_details['start_time']));
        $end_time=$postDate . " ". date('H:i:s', strtotime($post_details['end_time']));


        //fetch house details
        $addressDetails = $post_details['address'];
        $addressUnitnumber = $post_details['unit_number'];
        $addressCity = $post_details['city'];
        $addressState= $post_details['state'];
        $addressZip = $post_details['zip'];

        $house_str='';
        $j=1;
        for ($i = 0; $i < $post_details['house_count']; $i++)
        { 

           $house_detail='';
           $house_detail.="<b>House Details $j: </b><br/>";
           $house_detail.="Address: ".$addressDetails[$i]." <br/>";
           $house_detail.="Unit: ".$addressUnitnumber[$i]." <br/>";
           $house_detail.="City: ".$addressCity[$i]." <br/>";
           $house_detail.="Zip: ".$addressZip[$i]." <br/>";
           $house_detail.="State: ".$addressState[$i]." <br/>";
           $house_str.=$house_detail;
           $j++;

       }

       $srch_array = array(
        "{{agent_first_name}}" => $posting_agent_info_obj->first_name,
        "{{insert_showing_date}}" => $postDate,
        "{{link_to_lms_login}}" => url(),
        "{{date_of_showing}}" => $postDate,
        "{{start_time}}" => $start_time,
        "{{end_time}}" => $end_time,
        "{{logo_url}}" =>"<img style='width:175px' src='$img_url'>",
        "{{site_url}}" => $template->from_name,
        "{{from_email}}" => $template->from_email_id,
        "{{house_details}}" =>$house_str

        );

       $subject_array=array( 
        "{{insert_showing_date}}" => $postDate
        );

       $email_values = EmailTemplate::getvalues($template, $srch_array,$subject_array);

       // dd($posting_agent_info_obj->email);


       Mail::send(['html'=>'emails.showing_save_notification'],
        ['receiverDetails' => $email_values->content], function ($message) use
        ($posting_agent_info_obj,$email_values)
        {
            $message->from($email_values->from_email_id, $email_values->from_name)
            ->subject($email_values->subject);

            $message->to($posting_agent_info_obj->email);
        });
   }


    /**
    * Method that notify to showing agent to approve there accepted showing   
    * @param array $receiverDetails array of showing info
     * @param string edit type
     * @return object query builder object
    */


    public function sendShowingApproveNotification($receiverDetails)
    {


        $states = (new State())->getAllStatesByCountryId();
        $template = EmailTemplate::whereName('send_showing_approved_notification')->first();
        $img_url=asset('assets/img/logo.png');
        

        $house_str='';
        $j=1;
        foreach ($receiverDetails['showingData'] as $housedetail)
        { 

           $house_detail='';
           $house_detail.="<b>House Details $j: </b><br/><br/>";
           $house_detail.="Address: ".$housedetail->address." <br/><br/>";
           $house_detail.="Unit: ".$housedetail->unit_number." <br/><br/>";
           $house_detail.="City: ".$housedetail->city." <br/><br/>";
           $house_detail.="Zip: ".$housedetail->zip." <br/><br/>";
           $house_detail.="State: ".$states[$housedetail->state]." <br/><br/>";
           $house_detail.="MLS#: ".$housedetail->MLS_number." <br/>";

           $house_str.=$house_detail;
           $j++;


       }


       $srch_array = array(
        "{{agent_first_name}}" => $receiverDetails['data']->first_name,
        "{{insert_showing_date}}" => date('d-m-Y', strtotime($receiverDetails['showingData']['0']->post_date)),
        "{{link_to_lms_login}}" => url(),
        "{{date_of_showing}}" => date('d-m-Y ', strtotime($receiverDetails['showingData']['0']->post_date)),
        "{{start_time}}" => date('h:i A ', strtotime($receiverDetails['showingData']['0']->start_time)),
        "{{end_time}}" =>  date('h:i A', strtotime($receiverDetails['showingData']['0']->end_time)),
        "{{logo_url}}" =>"<img style='width:175px' src='$img_url'>",
        "{{site_url}}" => $template->from_name,
        "{{from_email}}" => $template->from_email_id,
        "{{customer_name}}"=>$receiverDetails['showingData']['0']->customer_name,
        "{{custome_email}}"=>$receiverDetails['showingData']['0']->customer_email,
        "{{customer_phone}}"=> $receiverDetails['showingData']['0']->customer_phone_number,
        "{{posting_agent_name}}"=>$receiverDetails['postingAgentData']['0']->first_name." ".$receiverDetails['postingAgentData']['0']->last_name,
        "{{posting_agent_phone}}"=>$receiverDetails['postingAgentData']['0']->phone_number,
        "{{posting_agent_email}}"=>$receiverDetails['postingAgentData']['0']->email,
        "{{house_details}}" =>$house_str,
        );
$subject_array=array( 
    "{{insert_showing_date}}" => date('d-m-Y', strtotime($receiverDetails['showingData']['0']->post_date))
    );

$email_values = EmailTemplate::getvalues($template, $srch_array,$subject_array);

Mail::send('emails.showing_approve_notification',
    ['receiverDetails' =>$email_values->content], function ($message) use
    ($receiverDetails,$email_values)
    {
        $message->from($email_values->from_email_id, $email_values->from_name)
        ->subject($email_values->subject);

        $message->to($receiverDetails['data']->email);
    });
}



      /**
    * Method that notify to showing agent to Rejaect  there accepted showing   
    * @param array $receiverDetails array of showing info
     * @param string edit type
     * @return object query builder object
    */

      public function sendShowingRejectNotification($receiverDetails)
      {

        $template = EmailTemplate::whereName('send_showing_declined_notification')->first();
        $img_url=asset('assets/img/logo.png');

        $srch_array = array(
            "{{agent_first_name}}" => $receiverDetails['showingAgentEmail']['0']->first_name,
            "{{insert_showing_date}}" => date('d-m-Y ', strtotime($receiverDetails['showingDetail']['0']->post_date)),
            "{{link_to_lms_login}}" => url(),
            "{{date_of_showing}}" => date('d-m-Y ', strtotime($receiverDetails['showingDetail']['0']->post_date)),
            "{{start_time}}" => date('h:i A ', strtotime($receiverDetails['showingDetail']['0']->start_time)),
            "{{end_time}}" =>  date('h:i A', strtotime($receiverDetails['showingDetail']['0']->end_time)),
            "{{logo_url}}" =>"<img style='width:175px' src='$img_url'>",
            "{{site_url}}" => $template->from_name,
            "{{from_email}}" => $template->from_email_id,

            );

        
        $subject_array=array( 
            "{{Insert_showing_date}}" => date('d-m-Y ', strtotime($receiverDetails['showingDetail']['0']->post_date))
            );

        $email_values = EmailTemplate::getvalues($template, $srch_array,$subject_array);
        
        Mail::send('emails.showing_reject_notification',
            ['receiverDetails' =>$email_values->content], function ($message) use
            ($receiverDetails,$email_values)
            {
                $message->from($email_values->from_email_id, $email_values->from_name)
                ->subject($email_values->subject);

                $message->to($receiverDetails['showingAgentEmail']['0']->email);

            });
    }



    /**
     * Method that will send the details of showing that the showing agent
     * accepted
     *
     *@param array $receiverDetails array of showing info
     *
     *@return object query builder object
     */
    public function sendAcceptedShowingDetails($showingDetails)
    {

        Mail::send('emails.accepted_showing_detail',
            ['showingDetails' => $showingDetails], function ($message) use
            ($showingDetails)
            {
                $message->from('lms@da.com', 'LMS')
                ->subject('Accepted Showing Details');
                $message->to($showingDetails[0]['sa_email']);
            });
    }
}
