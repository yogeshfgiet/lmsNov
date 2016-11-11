<?php namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use App\Models\ShowingAgent;
use App\Models\PostingAgent;
use App\Models\AuthorizeNet;
use Illuminate\Support\Facades\Input;

class BillingController extends Controller {

    /*
      |--------------------------------------------------------------------------
      | Billing Controller
      |--------------------------------------------------------------------------
      |
      | This controller will have all the billing related functionality
      | It will store the billing, make payments
      |
     */

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // constructor
    }

    /**
     * Show the billing info page
     * @return View for billing info
     */
    public function info()
    {
        //If user status not zero then page should go to edit billing info page
        if ('0' !== auth()->user()->user_type)
        {
            return redirect('home');
        }

        return view('user.billing.info');
    }

    /**
     * Save user's more information form data like
     * user_type, profile_photo, personal_bio, card info, bank info
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Void
     */
    public function saveInfo(Request $request)
    {
        $userBillingInfo = Input::get();
        $userType = $userBillingInfo['user_type'];
        $agentTypes = config('custom.agent_types');

        // check input validation
        switch ($userType)
        {
            case $agentTypes['posting']:
                $validator = $this->cardValidator($request->all());
                break;
            case $agentTypes['showing']:
                $validator = $this->bankValidator($request->all());
                break;
            case $agentTypes['both_posting_showing']:
                $validator = $this->validator($request->all());
                break;
        }

        if ($validator->fails())
        {

            $this->throwValidationException($request, $validator);
        }

        $loggedUserInfo = auth()->user();
        $userId = $loggedUserInfo->id;

        //Save the users info to Authorize.Net
        $authNetResponse =
            (new AuthorizeNet())->createCustomerProfile($loggedUserInfo,
                $userType, $userBillingInfo);

        //If the information is validated by Authorize.Net
        if (TRUE === $authNetResponse['status'])
        {
            $userBillingInfo['authorize_info'] = $authNetResponse;

            // update user's data for the current user
            (new User())->saveUserDetails($userId, $userBillingInfo);

            switch ($userType)
            {
                case $agentTypes['posting']:
                    // update posting agent data for the current user
                    (new PostingAgent())->saveAgentDetails($userId,
                        $userBillingInfo);
                    break;

                case $agentTypes['showing']:
                    // update showing agent data for the current user
                    (new ShowingAgent())->saveAgentDetails($userId,
                        $userBillingInfo);
                    break;

                case $agentTypes['both_posting_showing']:
                    // update both showing and posting agent data for current user
                    (new PostingAgent())->saveAgentDetails($userId,
                        $userBillingInfo);
                    (new ShowingAgent())->saveAgentDetails($userId,
                        $userBillingInfo);
                    break;
            }

            // send success message to the view after succefully saving user info
            \Session::flash('flash_success_message',
                'Information has been saved successfully!!');

            return redirect('home');
        }
        else
        {
           // dd( $authNetResponse['error_message']);
            // send success message to the view after succefully saving user info
            \Session::flash('flash_error_message',
                $authNetResponse['error_message']);

            return redirect('/billing-info');
        }
    }

    // @formatter:off

    /**
     * Get a validator for an incoming user's more info request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function cardValidator(array $data)
    {
        return Validator::make($data, [
            'card_full_name' => 'required',
            'card_number' => 'required|numeric',
            'cvv_number' => 'required|numeric',
            'profile_photo' => 'mimes:png,jpeg,jpg,gif']);
    }

    /**
     * Get a validator for an incoming user's more info request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function bankValidator(array $data)
    {
        return Validator::make($data, [
            'bank_name' => 'required',
            'account_name' => 'required',
            'routing_number' => 'required|numeric',
            'account_number' => 'required|numeric',
            'profile_photo' => 'mimes:png,jpeg,jpg,gif']);
    }

    /**
     * Get a validator for an incoming user's more info request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'card_number' => 'required|numeric',
            'cvv_number' => 'required|numeric',
            'card_full_name' => 'required',
            'account_number' => 'required|numeric',
            'routing_number' => 'required|numeric',
            'profile_photo' => 'mimes:png,jpeg,jpg,gif']);
    }
    // @formatter:on

    /**
     * Method to get user's billing or card info according to
     * the selected user type
     * @return View user/billinginfo.blade.php
     */
    public function getBillingInfo($utype = NULL)
    {
        $userId = auth()->user()->id;
        $billingInfo = (new User())->getBillingInfo($userId);
        //If user type set
        if (isset($utype) && (0 < $utype))
        {
            $billingInfo->user_type = $utype;
        }

        return view('user.billing.billinginfo',
            ['billingInfo' => (array)$billingInfo]);
    }

    /**
     * Edit user's payment profile as bank account and credit card info
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Void
     */
    public function editPaymentProfile(Request $request)
    {
        $paymentProfileInfo = Input::get();

        $profileType = $paymentProfileInfo['profile_type'];
        $agentTypes = config('custom.agent_types');

        // check input validation
        switch ($profileType)
        {

            case $agentTypes['posting']:
            
                $validator = $this->cardValidator($paymentProfileInfo);
                break;
            case $agentTypes['showing']:
                $validator = $this->bankValidator($paymentProfileInfo);
                break;
            default:
                // send success message to the view after succefully saving user info
                \Session::flash('flash_error_message', 'Invalid input');
                
                return "false";
                //return redirect('edit-profile');
                // return view('user.billing.billinginfo',
                //     ['billingInfo' => $paymentProfileInfo]);
        }

        //checking validation
        if ($validator->fails())
        {
            //return 'false';
            return $validator->messages()->toJson();
            //$this->throwValidationException($request, $validator);
        }

        $userInfo = auth()->user();
        $userId = $userInfo->id;
        $authorizeModel = new AuthorizeNet();
        $userModel = new User();

        // check input validation
        switch ($profileType)
        {
            case $agentTypes['posting']:
                $pastProfileInfo = $userModel->getCreditCardInfo($userId);
                //Function to update credit card
                $authNetResponse =
                    $authorizeModel->updateCustomerCreditCardProfile($pastProfileInfo,
                        $paymentProfileInfo);
                break;
            case $agentTypes['showing']:
                $pastProfileInfo = $userModel->getBankAccountInfo($userId);
                //Function to update credit card
                $authNetResponse =
                    $authorizeModel->updateCustomerBankAccountProfile($pastProfileInfo,
                        $paymentProfileInfo);
                break;
        }

        //If the information is validated by Authorize.Net
        if (TRUE === $authNetResponse['status'])
        {
            $paymentProfileInfo['authorize_info'] = $authNetResponse;

            // check input validation
            switch ($profileType)
            {

                case $agentTypes['posting']:
                    // update showing agent data for the current user
                    (new PostingAgent())->saveAgentDetails($userId,
                        $paymentProfileInfo);
                    break;
                case $agentTypes['showing']:
                    // update showing agent data for the current user

                    (new ShowingAgent())->saveAgentDetails($userId,
                        $paymentProfileInfo);
                    break;
            }
            // send success message to the view after succefully saving user info
            // \Session::flash('flash_success_message',
            //     'Information has been saved successfully!!');
        }
        else
        {
            // send error message to the view after credit card iformation wrong succefully saving user info
           
            $return_data['msg'] = $authNetResponse['error_message']; 
            return json_encode($return_data);
            // \Session::flash('flash_error_message',
            //     $authNetResponse['error_message']);
        }

       
        return "true";
       // return redirect('edit-profile');
        // return redirect('/edit-billing-info/' .
        //     $paymentProfileInfo['user_type']);
    }

    /**
     * Edit user's agent type
     *
     * @param  nothing
     *
     * @return Void
     */
    public function upgradeAgentType()
    {

        $agentInfo = Input::get();

        $currAgentType =
            isset($agentInfo['user_type']) ? $agentInfo['user_type'] : '';
        $agentTypes = config('custom.agent_types');
        $userModel = new User();
        $userInfo = auth()->user();

        $profileExistStatus = FALSE;
        //If user type set
        if ((0 < $currAgentType))
        {
            $userId = auth()->user()->id;
            $billingInfo = (array)$userModel->getBillingInfo($userId);

            if (0 < $billingInfo['auth_net_customer_id'])
            {
                switch ($currAgentType)
                {
                    case $agentTypes['posting']:
                        //check if the payment info are set
                        if (isset($billingInfo['auth_net_card_payment_id']) &&
                            0 < $billingInfo['auth_net_card_payment_id']
                        )
                        {
                            $profileExistStatus = TRUE;
                        }
                        break;
                    case $agentTypes['showing']:
                        //check if the payment info are set
                        if (isset($billingInfo['auth_net_bank_account_id']) &&
                            0 < $billingInfo['auth_net_bank_account_id']
                        )
                        {
                            $profileExistStatus = TRUE;
                        }
                        break;
                    case $agentTypes['both_posting_showing']:
                       
                        //check if the payment info are set
                        if ((isset($billingInfo['auth_net_bank_account_id']) &&
                                0 < $billingInfo['auth_net_bank_account_id']) &&
                            (isset($billingInfo['auth_net_card_payment_id']) &&
                                0 < $billingInfo['auth_net_card_payment_id'])
                        )
                        {

                            $profileExistStatus = TRUE;
                        }
                         if ($billingInfo['auth_net_card_payment_id'] == null){

                                    $error ="Credit Card information is missed .Please try again.";
                         }
                         if ($billingInfo['auth_net_bank_account_id'] == null){

                                    $error ="Bank Account information is missed .Please try again.";
                         }
                            

                }
            }
        }

        //If required payment profile exists
        if (TRUE === $profileExistStatus)
        {
            $userModel->saveUserType($userInfo->id, $agentInfo);
            // send success message to the view after succefully saving user info
            \Session::flash('flash_success_message',
                'Information has been saved successfully!!');
            //update user type
            $userInfo->user_type = $agentInfo['user_type'];
        }
        else
        {
            // send Error message to the view when error occured  saving user info
            \Session::flash('flash_error_message', $error);
        }
          return redirect('edit-profile');
        //return redirect('/edit-billing-info/' . $userInfo->user_type);
    }
}
