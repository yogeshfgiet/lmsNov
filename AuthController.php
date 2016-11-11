<?php namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\State;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {

    /*
      |--------------------------------------------------------------------------
      | Registration & Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users, as well as the
      | authentication of existing users. By default, this controller uses
      | a simple trait to add these behaviors. Why don't you explore it?
      |
     */

use AuthenticatesAndRegistersUsers,
    ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {


        return Validator::make($data,
            [
                'first_name' => 'required|max:45',
                'last_name' => 'required|max:45',
                'state' => 'required',
                'phone_number' => 'required|max:20',
                'license_number' => 'required',
                'brokerage_firm_name' => 'required|max:45',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|confirmed|min:6',
                'terms' => 'required'
            ]
        );
    }

    /**
     * Method to get all state list for USA country (for now)
     * and send to registration page.
     *
     * @param  void
     * @return data into auth/register view page
     */
    public function getRegister()
    {
        $states = (new State())->getAllStatesByCountryId();
        return view('auth.register', ['states'=>$states]);
    }

    /**
     * Method to register the user with proper validation.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function postRegister(Request $request)
    {



        $validator = $this->validator($request->all());
        $getParams = Input::get();


        if ($validator->fails())
        {
            $this->throwValidationException(
                $request, $validator
            );
        }

        // unique random activation code
        $activationCode = str_random(60) . $getParams['email'];

        // create the user
        User::create([
            'first_name' => $getParams['first_name'],
            'last_name' => $getParams['last_name'],
            'state_id' => $getParams['state'],
            'phone_number' => $getParams['phone_number'],
            'license_number' => $getParams['license_number'],
            'brokerage_firm_name' => $getParams['brokerage_firm_name'],
            'notification_preference' => $getParams['notification_preference'],
            'email' => $getParams['email'],
            'password' => bcrypt($getParams['password']),
            'remember_token' => $getParams['_token'],
            'activation_code' => $activationCode
        ]);

        // user data to send through registration email
        $userData = array(
            'name' => $getParams['first_name'] . ' ' . $getParams['last_name'],
            'activationCode' => $activationCode
        );


        // send the email to the registered user
      

  
        $sent = Mail::send('emails.register', $userData, function($message) use ($getParams)
        {

           $data = $message->to($getParams['email']) ->subject('Verify your email address');
     
        });


        // send success message to the view after succefully sending the email
        \Session::flash('flash_success_message',
            'Thanks for signing up! Please check your email for verifying your account.');

        return redirect('auth/login');
    }

    /**
     * Action method to confirm the account.
     *
     * @param  String $activationCode
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function confirmAccount($activationCode)
    {
        if (!$activationCode)
        {
            throw new InvalidConfirmationCodeException;
        }

        // get the user as per the activation code
        $user = User::whereActivationCode($activationCode)->first();

        if (!$user)
        {
            throw new InvalidConfirmationCodeException;
        }

        // change the user status to active and make the activation_code as null
        $user->status = 1;
        $user->activation_code = null;
        $user->save();

        // send the success message to the user after account verification
        \Session::flash('flash_success_message',
            'You have successfully verified your account.');

        return redirect('auth/login');
    }

}
