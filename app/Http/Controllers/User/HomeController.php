<?php namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use App\Models\State;
use App\Models\ShowingAgent;
use App\Models\PostingAgent;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller {

    /*
      |--------------------------------------------------------------------------
      | Home Controller
      |--------------------------------------------------------------------------
      |
      | This controller renders your application's "dashboard" for users that
      | are authenticated. Of course, you are free to change or remove the
      | controller as you wish. It is just here to get your app started!
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
     * Show the application dashboard to the user.
     *
     * @return View layouts/user.blade.php
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $userType = Auth::user()->user_type;
        $incompletedData = false;

        if ($userId && !$userType)
        {
            $incompletedData = true;
        }

        return view('user.home.dashboard', ['incompletedData' =>
            $incompletedData,'userType'=>$userType]);
    }

    /**
     * Get a validator for an incoming profile edit request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function profileValidator(array $data)
    {
        return Validator::make($data,
            [
                'first_name' => 'required|max:45',
                'last_name' => 'required|max:45',
                'state' => 'required',
                'phone_number' => 'required|regex:[[0-9]]',
                
                'license_number' => 'required',
                'brokerage_firm_name' => 'required|max:45',
                'email' => 'required|email|max:255|unique:users,id,{{Auth::user()->id}}',
                'password_confirmation' => 'required_with:password',
                'password' => 'confirmed',
            ]
        );
    }

    /**
     * Get a validator for an incoming billing info edit request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function billingInfoValidator(array $data)
    {
        return Validator::make($data,
            [
                'bank_name' => 'required',
                'account_name' => 'required',
                'routing_number' => 'required|numeric',
                'account_number' => 'required|numeric',
                'account_type' => 'required',
                'holder_type' => 'required',

                'card_full_name' => 'required',
                'card_number' => 'required|numeric',
                'expiry_month' => 'required',
                'expiry_year' => 'required',
                'cvv_number' => 'required|numeric',
            ]
        );
    }

    /**
     * Get user's profile data
     *
     * @return View user/profile.blade.php
     */
    public function getProfile()
    {
         $userId = auth()->user()->id;
        $billingInfo = (new User())->getBillingInfo($userId);
        //If user type set
        if (isset($utype) && (0 < $utype))
        {
            $billingInfo->user_type = $utype;
        }


        $states = (new State())->getAllStatesByCountryId();
        return view('user.home.profile', ['states' => $states,
                                     'incompletedData' => false,'billingInfo' => (array)$billingInfo]);
    }

    /**
     * Save user's profile data
     *
     * @param  \Illuminate\Http\Request $request
     * @return Void
     */
    public function postProfile(Request $request)
    {
       
        $validator = $this->profileValidator($request->all());
        $userId = Auth::user()->id;

        if ($validator->fails())
        {
            $this->throwValidationException(
                $request, $validator
            );
        }

        
        // update user's data for the current user
        (new User())->saveProfileDetails($userId);

        // send success message to the view after succefully saving user info
        \Session::flash('flash_success_message',
            'Profile has been edited successfully!!');

        return redirect('edit-profile');
    }

    /**
     * Show the change image view file inside an iframe
     *
     * @return View user/changeimage.blade.php
     */
    public function getProfileImage()
    {
        return view('user.home.changeimage');
    }

    /**
     * Save user's profile image temporarily in
     * public/uploads/user/tmp folder
     *
     * @return View user/changeimage.blade.php
     */
    public function postProfileImage()
    {
        $tmpImg = (new User())->changeProfileImage(1);
        return view('user.home.changeimage', ['tmpImg' => $tmpImg]);
    }

    /**
     * Save user's profile image
     * by replacing the image from temp folder to original folder
     * and then delete the image from temp folder
     *
     * @return View user/changeimage.blade.php
     */
    public function saveProfileImage()
    {
        (new User())->saveProfileImage();
        return view('user.home.changeimage', ['tmpImg' => '']);
    }

}
