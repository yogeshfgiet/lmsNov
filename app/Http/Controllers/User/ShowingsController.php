<?php namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Showings;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Validator;
use App\Models\Email;
use App\Models\State;
use App\Models\RejectedShowing;
use App\Models\EmailTemplate;
use DB;
class ShowingsController extends Controller {

    /*
      |--------------------------------------------------------------------------
      | Showings Controller
      |--------------------------------------------------------------------------
      |
      | This controller renders application's showings functionality for users
      | that are authenticated.
      |
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->showingModel = new Showings();
    }

    /**
     * Get a validator for an incoming showing request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function showingValidator(array $data)
    {
        return Validator::make($data,
            [
            'post_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'customer_name' => 'required|max:255',
            'customer_email' => 'required|email|max:45',
            'customer_phone_number' => 'required|regex:[[0-9]]',
            'house_count' => 'required',
            'address'=>'required'
            ]
            );
    }

    /**
     * Show the available showings and valid showings for user.
     *
     * @return Response
     */
    public function index()
    {   $showings = $this->showingModel->getAllShowingsForMap(auth()->user()
        ->id);
    return view('user.showings.list',compact('showings'));
}

    /**
     * Show the available showings and valid showings for user.
     *
     * @return Response
     */
    public function listShowings()
    {
        //Collecting get params
        $getParams = Input::get();

        $showings = $this->showingModel
        ->getValidShowingsForUser(auth()->user()->id,
          $getParams);

        return response()->json($showings);
    }

    /**
     * Show the showings that user posted.
     *
     * @return View layouts/user.blade.php
     */
    public function myShowings()
    {
        $this->showingModel->getMyShowings(auth()->user()->id);
        return view('layouts.user');
    }

    /**
     * Functionality to add / edit new showing
     *
     * @params int id showingId id
     * @return View user/showings/add.blade.php
     */
    public function add()
    {
        //To make the showing houses count list
        $maxNoOfHouses = Config('custom.max_showing_houses');
        $searchCriteria = Config('custom.showings_search_criteria');
        $states = (new State())->getAllStatesByCountryId();

        return view('user.showings.add', compact('maxNoOfHouses',
            'searchCriteria','states'));
    }

    /**
     * Functionality to add / edit new showing
     *
     * @params \Illuminate\Http\Request $request
     * @return View user/showings/add.blade.php
     */
    public function save(Request $request)
    {
        
        $validator = $this->showingValidator($request->all());

        if ($validator->fails())
        {
            $this->throwValidationException(
                $request, $validator
                );
        }

        // update user's data for the current user
        $this->showingModel->saveShowingDetails(auth()->user());

        // send success message to the view after succefully saving user info
        \Session::flash('flash_success_message',
            'Showing has been added successfully!!');

        //To make the showing houses count list
        $maxNoOfHouses = Config('custom.max_showing_houses');
        $searchCriteria = Config('custom.showings_search_criteria');
        $states = (new State())->getAllStatesByCountryId();

        return view('user.showings.add', compact('maxNoOfHouses',
            'searchCriteria','states'));
    }

    /**
     * Functionality to view individual showing all details
     * like basic, customer details and house details
     *
     * @params \Illuminate\Http\Request $request
     * @return View user/showings/view.blade.php
     */
    public function view(Request $request)
    {

        $user =auth()->user()->id;
        $userType= DB::table('users')->where('id',$user)->pluck('user_type');

        $getDetails = [];
        $states = (new State())->getAllStatesByCountryId();

        if ($request->isMethod('post'))
        {
            $showingId = $request->only('id');

            if (!empty($showingId['id']))
            {
                $getDetails = $this->showingModel->getShowingDetails($showingId['id']);
            }
        }

        return view('user.showings.view', compact('getDetails', $getDetails,'states','userType'));
    }

    /**
     * Functionality to mark a showing as accepted by any user
     *
     * @params \Illuminate\Http\Request $request
     * @return json array
     */
    public function accept(Request $request)
    {



        $response = 0;
        if ($request->isMethod('post'))
        {
            $showingId = $request->only('id');

            if (!empty($showingId['id']))
            {

                $response = $this->showingModel->markShowingAccepted
                ($showingId['id'], auth()->user()->id);

                if($response) {
                    //getting posting agents information by showing id
                    $showingDetail = $this->showingModel->getCompleteShowingInfo
                    ($showingId['id']);

                    dd($showingDetail);

                    if(!empty($showingDetail)) {
                        $showingDetailPost[]=  $showingDetail;
                        //Functionality to send showing complete notification
                        (new Email())->sendShowingAcceptNotification(((array)$showingDetailPost));
                        //converting to entire object to array not rquire 
                       // $showingDetail = json_decode(json_encode($showingDetail), true);
                       // (new Email())->sendAcceptedShowingDetails(($showingDetail));
                    }
                }
            }
        }
        return json_encode((int) $response);
    }

    /**
     * Functionality to create view your showing page
     *
     * @return nothing
     */
    public function viewYourShowings()
    {
        //it will load only the listing view
        return view('user.showings.view_your');
    }

    /**
     * Show all showings and valid showings for user by the type
     * @param string type
     * @return ajax Response
     */
    public function listUsersShowings($type)
    {
        //Collecting get params
    
        $getParams = Input::get();
        $showings = $this->showingModel
        ->getUsersShowings(auth()->user()->id, $getParams, $type);

        return response()->json($showings);
    }


    /**
     * Functionality to show feedback form
     *
     * @param string type
     * @return ajax Response
     */
    public function feedbackForm()
    {
        //Collecting get params
        $getParams = Input::get();
        //fetching showing for $getParams
        //dd($getParams);
        $showing = DB::table('showings')->select('post_date', 'showing_progress')
        ->where('id',$getParams['id'])->first();
        //$showingDate = DB::table('showings')->where('id',$getParams['id'])->value('post_date');
        //$showing = DB::table('showings')->where('id',$getParams['id'])->value('showing_progress');

        if($showing && $showing->post_date > date('Y-m-d') ){
            return view('user.showings.feedback_error', compact('getParams', $getParams));
        }
        else if($showing && $showing->showing_progress > 3){

            return view('user.showings.feedbacke_error', compact('getParams', $getParams));
        }


        else{
            return view('user.showings.feedback', compact('getParams', $getParams));
        }
        
    }

    /**
     * add feedback and block showing
     *
     * @param string type
     * @return ajax Response
     */
    public function blockPost()
    {
        //Collecting get params
        $getParams = Input::get();
        //dd($getParams);
        if(isset($getParams["feedback"]) && isset($getParams["showing_id"])){

            $showing = DB::table('showings')->where('showing_progress',4)
            ->where('id',$getParams["showing_id"])
            ->where('user_id',auth()->user()->id)
            ->first();

            if($showing){
                DB::beginTransaction();
                $ret = DB::table('showings')
                ->where('id', $showing->id)
                ->update(['showing_progress' => 5]);

                

                $ret = DB::table('user_feedback_rating')
                ->where('showing_id', $showing->id)
                ->update(['block_comment' => $getParams["feedback"]]);

                if($ret){
                    DB::commit();
                    \Session::flash('flash_success_message','Showing blocked successfully!');
                    echo json_encode(array("status" => "success","msg" => "updated successfully!"));    
                    return;
                }
            }else{
                DB::rollback();
                echo json_encode(array("status" => "error","msg" => "showing not found"));
                return;    
            }
        }else{
            DB::rollback();
            echo json_encode(array("status" => "error","msg" => "params error"));
            return;

        }
        return;
        
    }


     /**
     * add review  for showing showing
     *
     * @param string type
     * @return ajax Response
     */
     public function reviewPost()
     {
        //Collecting get params
        $getParams = Input::get();
        //dd($getParams);

        if(isset($getParams["feedback"]) && isset($getParams["showing_id"])){

            $showing = DB::table('showings')->where('showing_progress',4)
            ->where('id',$getParams["showing_id"])
            ->where('user_id',auth()->user()->id)
            ->first();

            if($showing){
             DB::beginTransaction();
             $ret = DB::table('showings')
             ->where('id', $showing->id)
             ->update(['showing_progress' => 6]);


             $ret = DB::table('user_feedback_rating')
             ->where('showing_id', $showing->id)
             ->update(['rating_comment' => $getParams["feedback"],'rating_point'=>$getParams["rating"]]);

             if($ret){
              DB::commit();
              \Session::flash('flash_success_message','Add rating successfully!');
              echo json_encode(array("status" => "success","msg" => "updated successfully!"));
              return ;

          }
      }else{
        echo json_encode(array("status" => "error","msg" => "showing not found"));  
        return;  
    }
}else{
 DB::rollback();
 echo json_encode(array("status" => "error","msg" => "params error"));
 return;

}
return;

}



    /**
     * Functionality to send showing feedback
     *
     * @return ajax Response
     */
    public function feedback()
    {
        //Collecting get params
        $getParams = Input::get();
        DB::beginTransaction();
        $response = $this->showingModel->markShowingCompleted
        ($getParams['id'], auth()->user()->id);

        if($response)
        {
            //getting posting agents information by showing id
            $customerDetails = $this->showingModel->getPostingCustomerDetails
            ($getParams['id']);


            //
            $feedbackData = $getParams;

            $customerDetails = $this->showingModel->getPostingCustomerDetails($getParams['id']);

            $feedbackData['showing_id'] = $feedbackData['id'];
            $feedbackData['user_id'] = $customerDetails['0']->user_id;
            $feedbackData['showing_user_id'] = $customerDetails['0']->showing_user_id;
            
            unset($feedbackData['id']);
            unset($feedbackData['_token']);


            $showingDetail = $this->showingModel->getCompleteShowingInfo
            ($feedbackData['showing_id']);

              // $feedback[]=  $feedbackData;    
            //dd($feedbackData);
            DB::table('user_feedback_rating')->insert($feedbackData);
            if (!empty($customerDetails))
            {
                $feedback['feed'] = (array)$feedbackData;
                $feedback['data']=(array)$showingDetail;


                $details = array_merge($feedback);
                            //Functionality to send showing complete notification
                (new Email())->sendShowingCompleteNotification(($details));
                // send success message to the view after succefully saving user info
                DB::commit();
                \Session::flash('flash_success_message','Transaction complete. Money will be deposited in your bank account within 48 hours, barring any compliant lodged by the posting agent');
            }else{
                DB::rollback();
            }
        }

        return redirect('/showings/view-your');
    }

    /**
     * Functionality to edit posted showing
     *
     * @params int $id showingId
     * @return View user/showings/edit.blade.php
     */
    public function edit(Request $request, $id)
    {
        if ($request->isMethod('post'))
        {
            $postParams = $request->all();
            $validator = $this->showingValidator($postParams);

            if ($validator->fails())
            {
                $this->throwValidationException(
                    $request, $validator
                    );
            }
            // update showing information
            $this->showingModel->updateShowingDetails(auth()->user()->id, $postParams);
            // send success message to the view after succefully saving user info
            \Session::flash('flash_success_message',
                'Showing updated successfully!!');
        }

        //To make the showing houses count list
        $maxNoOfHouses = Config('custom.max_showing_houses');
        //Creating search criteria array
        $searchCriteria = Config('custom.showings_search_criteria');
        //get showing details
        $showings = $this->showingModel->getShowingWithHouses($id, auth()->user()->id);
        $states = (new State())->getAllStatesByCountryId();
        //If showings found go to edit screen else go to listing page
        if(0 < count($showings)) {
            return view('user.showings.edit', compact('maxNoOfHouses',
                'searchCriteria', 'showings','states'));
        } else {
            return redirect('showings/view-your');
        }
    }

    /**
     * Functionality to delete showings
     *
     * @params int $id showingId
     * @return View user/showings/edit.blade.php
     */
    public function delete($id)
    {
        $this->showingModel->deleteShowingWithHouses($id, auth()->user()->id);
        // send success message to the view after success
        \Session::flash('flash_success_message',
            'Showing deleted successfully!!');
        return redirect('showings/view-your');
    }


    public function showingBlock($id)
    {

       $user =auth()->user()->id;

       $showing = DB::table('showings')
        //->where('showing_progress',4)
       ->where('id',$id)
       ->where('user_id',$user )
       ->first();
       $ufr = DB::table('user_feedback_rating')
        //->where('showing_progress',4)
       ->where('showing_id',$id)
       ->first();

       if(empty($showing)){

         \Session::flash('flash_success_message',
            'You have no permission!!');
         return redirect('/home'); 

     }

     return view('user.showings.blockshowings', compact('showing','ufr'));

 }
        /*
            Show showing agent profile  data for approve 
        */

            public function showingAgentProfileData($id)
            {

                $showingUsers = DB::table('users')->where('id', '=',$id)->first();

                $states = (new State())->getAllStatesByCountryId();
                return view('user.showings.showing_agent_profile_data', compact('showingUsers','states'));

            }

            /*+

                Approve the showing agent by posting aget for accepted showing

            */

                public function showingAgentApprove($showing_id)
                {

                    $postingAgentId = DB::table('showings')->select('showing_user_id','user_id')
                    ->where('id', $showing_id)
                    ->get();


                    $agnetApprove= DB::table('showings')
                    ->where('id', $showing_id)
                    ->update(['showing_progress' => 2]);



                    $postingAgentdata = DB::table('users')->where('id',$postingAgentId['0']->user_id)->get();
                   // $showingAgentEmail = DB::table('users')->where('id',$postingAgentId['0']->showing_user_id)->pluck('email');

                    $showingAgentdata = DB::table('users')->select('email','first_name')
                    ->where('id',$postingAgentId['0']->showing_user_id)
                    ->first();

                    $showingsData = DB::table('showings AS s')
                    ->join('showing_houses AS sh', 's.id', '=', 'sh.showing_id')
                    ->select('s.*','sh.address','sh.city','sh.state','sh.zip','sh.unit_number','sh.MLS_number')
                    ->where('s.id', '=', $showing_id)
                    ->get();


                    $fullData = array();
                    $fullData['showingData'] = $showingsData;
                    $fullData['postingAgentData'] = $postingAgentdata;
                    $fullData['data'] = $showingAgentdata;
                    //$fullData['sAName'] = $showingAgentName;



                        //Functionality to send email to showing agent releted to showing information
                    (new Email())->sendShowingApproveNotification(((array)$fullData));
                        //converting to entire object to array

                    \Session::flash('flash_success_message',' Showing has been approved successfully. ');
                    return;


                }


            /*

              functionality to reject showing agent and send mail to showing rejected 

            */


              public function showingAgentReject($showing_id)
              {

                $AgentId = DB::table('showings')->select('showing_user_id','user_id')
                ->where('id', $showing_id)
                ->get();

                DB::beginTransaction();
            // functionality for update showing table when rejected
                $showingRejected= DB::table('showings')
                ->where('id', $showing_id)
                ->update(['showing_progress' => 0,'showing_user_id' => 0,]);

                if($showingRejected){
                  DB::commit();
                // Query For updte rejected showing table;
                  $updateRjectedTable=   DB::table('rejected_showings')->insert([
                    ['posting_agent_id' =>$AgentId['0']->user_id, 
                    'showing_id' =>$showing_id ,
                    'showing_agent_id' =>$AgentId['0']->showing_user_id,
                    'date' => date('Y-m-d H:i:s')]

                    ]);
              }
              else{
               DB::rollback();

           }

           $showingAgentEmail = DB::table('users')->select('email','first_name')
           ->where('id',$AgentId['0']->showing_user_id)
           ->get();

             $showingDetail = $this->showingModel->getCompleteShowingInfo
                    ($showing_id);
           $fullData = array();

           $fullData['showingAgentEmail'] = $showingAgentEmail;
            $fullData['showingDetail'] = $showingDetail;
            


                 //Functionality to send email to showing agent releted to showing information
           (new Email())->sendShowingRejectNotification(((array)$fullData));
                        //converting to entire object to array

           \Session::flash('flash_success_message','Showing has been rejected');
           return;


       }


       /*

        functionality to show rejected showing for showing agent.....

        */

        // public function rejectedShowingForAgent($id)
        // {


        //     $showingUser =auth()->user()->id;
        //     $AgentId = DB::table('rejected_showings')->select('showing_id','  posting_agent_id')
        //     ->where('id', $showing_id)
        //     ->get();

        //     $this->showingModel->getAllrejectedShowing($showingUser);
        //         //return view('user.showings.showing_agent_profile_data', compact('showingUsers','states'));

        // }


        public function viewShowingDataPopup(Request $request)
        {

            $user =auth()->user()->id;
            $userType= DB::table('users')->where('id',$user)->pluck('user_type');

            $getDetails = [];
            $states = (new State())->getAllStatesByCountryId();

            if ($request->isMethod('post'))
            {
                $showingId = $request->only('id');

                if (!empty($showingId['id']))
                {
                    $getDetails = $this->showingModel->getShowingDetails($showingId['id']);
                }
            }
           
            $AgentDetails = $this->showingModel->getCompleteSAgent($showingId['id']);

        
            return view('user.showings.view_user_data', compact('getDetails', $getDetails,'states','userType','AgentDetails',$AgentDetails));
            
        }

        public function viewShowingRejectedPopup(Request $request)
        {

            $user =auth()->user()->id;
            $userType= DB::table('users')->where('id',$user)->pluck('user_type');

            $getDetails = [];
            $states = (new State())->getAllStatesByCountryId();

            if ($request->isMethod('post'))
            {
                $showingId = $request->only('id');

                if (!empty($showingId['id']))
                {
                    $getDetails = $this->showingModel->getShowingDetails($showingId['id']);
                }
            }
           
            $AgentDetails = $this->showingModel->getCompleteSAgent($showingId['id']);
          
        
            return view('user.showings.view_rejected_showing_data', compact('getDetails', $getDetails,'states','userType','AgentDetails',$AgentDetails));
        }


          /**
     * Show the available showings and valid showings for user.
     *
     * @return Response
     */
    public function email_template(Request $request)
    {   
        $t = $request->only('t');
        $t=(!(empty($t['t']))) ?base64_decode($t['t']):null;

        $model=(!empty($t)) ? EmailTemplate::find($t): EmailTemplate::find(1);

        $template=EmailTemplate::all();

        if ($request->isMethod('post'))
        {   
            $postParams = $request->all();

            $validator = EmailTemplate::templateValidator($postParams);

            if ($validator->fails())
            {
                $this->throwValidationException($request, $validator);
            }
              

            $id=$postParams['id'];

            $emailTemplate = EmailTemplate::find($id);

            $emailTemplate->content = $postParams['content'];
            $emailTemplate->subject = $postParams['subject'];

            $emailTemplate->save();

             // send success message to the view after succefully saving user info
            \Session::flash('flash_success_message',
                'Email template updated successfully!!');

            return redirect( (!empty($id))?'email_template?t='.base64_encode($id):'email_template');

        }

        return view('user.showings.email_template',compact('template','model','t'));
        
    }


    }


