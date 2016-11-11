<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

    /*
      |--------------------------------------------------------------------------
      | User Model
      |--------------------------------------------------------------------------
      |
      | This Model will have all the functionality related to user table
      | This uses the Eloquent ORM model and its methods
      |
     */

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'state_id',
        'auth_net_customer_id', 'phone_number', 'license_number',
        'brokerage_firm_name', 'email', 'password', 'country_id',
        'remember_token', 'activation_code', 'user_type',
        'notification_preference', 'profile_photo', 'personal_bio',
        'average_rating'];
    /**
     * The attributes excluded from the model's JSON form.
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Method to update user details if already present for the user.
     *
     * @param  int $userId     user Id
     * @param  array $userInfo user's information
     *
     * @return Void
     */
    public function saveUserDetails($userId, $userInfo)
    {
        $fileName = $this->changeProfileImage();

        // update user's data for the current user
        $userData = ['user_type' => $userInfo['user_type'],
            'auth_net_customer_id' => $userInfo['authorize_info']['auth_net_customer_id'],
            'profile_photo' => $fileName,
            'personal_bio' => $userInfo['personal_bio'],];

        $this::updateOrCreate(['id' => $userId], $userData);
    }

    /**
     * Method to save users type.
     *
     * @param  int $userId     user Id
     * @param  array $userInfo user's information
     *
     * @return Void
     */
    public function saveUserType($userId, $userInfo)
    {
        // update user's data for the current user
        $userData = ['user_type' => $userInfo['user_type'],];

        $this::updateOrCreate(['id' => $userId], $userData);
    }

    /**
     * Method to update user details if already present for the user.
     *
     * @param  int $userId user Id
     *
     * @return Void
     */
    public function saveProfileDetails($userId)
    {
        $getParams = Input::get();
    

  
        // update user's data for the current user
        $userData = ['first_name' => $getParams['first_name'],
            'last_name' => $getParams['last_name'],
            'state_id' => $getParams['state'],
            'phone_number' => $getParams['phone_number'],
            'license_number' => $getParams['license_number'],
            'brokerage_firm_name' => $getParams['brokerage_firm_name'],
            'email' => $getParams['email'],
            'personal_bio' => $getParams['personal_bio'],
            'notification_preference' => $getParams['notification_preference'],];

        if (!empty($getParams['password']))
        {
            $userData = array_add($userData, 'password',
                bcrypt($getParams['password']));
        }

        $this::where('id', '=', $userId)->update($userData);
    }

    /**
     * Method to change user's profile image in the filesystem.
     * @return String $fileName changed profile image file name
     */
    public function changeProfileImage($isChange = 0)
    {
        $fileName = '';
        if (!empty(Input::file('profile_photo')) &&
            Input::file('profile_photo')->isValid()
        )
        {
            if (empty(auth()->user()->profile_photo) && (0 === $isChange))
            {
                // upload path
                $destinationPath = public_path('uploads/user');

                // getting image extension
                $extension =
                    Input::file('profile_photo')->getClientOriginalExtension();

                // renaming image
                $fileName = rand(11111, 99999) . '.' . $extension;
            }
            else
            {
                if ($isChange)
                {
                    // upload path
                    $destinationPath = public_path('uploads/user/tmp');

                    if (empty(auth()->user()->profile_photo))
                    {
                        // getting image extension
                        $extension = Input::file('profile_photo')
                            ->getClientOriginalExtension();

                        // renaming image
                        $fileName = rand(11111, 99999) . '.' . $extension;
                    }
                    else
                    {
                        $fileName = auth()->user()->profile_photo;
                    }
                }
            }

            if (!File::exists($destinationPath))
            {
                // path does not exist
                File::makeDirectory($destinationPath, 0755, TRUE, TRUE);
            }

            // uploading file to a given path
            Input::file('profile_photo')->move($destinationPath, $fileName);
        }

        return $fileName;
    }

    /**
     * Method to save profile image from temporary location to
     * original upload file and then delete image from temp folder.
     */
    public function saveProfileImage()
    {
        $fileSystemObj = new Filesystem();

        $fileName = auth()->user()->profile_photo;
        if (empty($fileName))
        {
            $fileName = Input::get('img');

            auth()->user()->profile_photo = $fileName;
            $this::where('id', '=', auth()->user()->id)
                ->update(['profile_photo' => $fileName]);
        }

        // upload path
        $destinationPath = public_path('uploads/user/' . $fileName);

        // temp file path
        $tmpFilePath = public_path('uploads/user/tmp/' . $fileName);

        // uploading file to a given path
        $fileSystemObj->move($tmpFilePath, $destinationPath);

        // delete/unlink the file after moving to parent directory
        $fileSystemObj->delete($tmpFilePath);
    }

    /**
     * Method to get billing info as per saved user type.
     * If user_type is showing_agent, then retrieve card info.
     * If user_type is posting_agent, then retrieve bank info.
     * If user_type is both showing and posting agent, then retrieve bank and
     * card info both.
     * @return Array $billingInfo[0] user bank/card info
     */
    public function getBillingInfo($userId)
    {
        // credit card with bank info
        $billingInfo =
            DB::table('users AS u')->select(['user_type', 'card_full_name',
                'card_number', 'expiry_month', 'expiry_year', 'bank_name',
                'account_name', 'routing_number', 'account_number',
                'account_type', 'auth_net_customer_id',
                'auth_net_bank_account_id', 'auth_net_card_payment_id'])
                ->leftJoin('showing_agent_info AS sai', 'u.id', '=',
                    'sai.user_id')
                ->leftJoin('posting_agent_info AS pai', 'u.id', '=',
                    'pai.user_id')->where('pai.user_id', '=', $userId)
                 -> orwhere('sai.user_id', '=', $userId)->get();

        return $billingInfo[0];
    }

    /**
     * Method to get historical saved bank account information.
     *
     * @param $userId
     *
     * @return Array $accountInfo[0] user bank/card info
     */
    public function getBankAccountInfo($userId)
    {
        // credit card with bank info
        $accountInfo = DB::table('users AS u')->select(['user_type',
            'auth_net_customer_id', 'sai.id AS saiId',
            'auth_net_bank_account_id'])
            ->leftJoin('showing_agent_info AS sai', 'u.id', '=', 'sai.user_id')
            ->where('u.id', '=', $userId)->get();

        return $accountInfo[0];
    }

    /**
     * Method to get historical saved credit card information.
     *
     * @param $userId
     *
     * @return Array $accountInfo[0] user bank/card info
     */
    public function getCreditCardInfo($userId)
    {
        // credit card info
        $accountInfo = DB::table('users AS u')->select(['user_type',
            'auth_net_customer_id', 'pai.id AS paiId',
            'auth_net_card_payment_id'])
            ->leftJoin('posting_agent_info AS pai', 'pai.user_id', '=', 'u.id')
            ->where('u.id', '=', $userId)->get();

        return $accountInfo[0];
    }
}
