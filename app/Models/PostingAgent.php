<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

class PostingAgent extends Model {

    /*
      |--------------------------------------------------------------------------
      | Posting Agent Model
      |--------------------------------------------------------------------------
      |
      | This Model will have all the functionality related to showings agent info table
      | This uses the Eloquent ORM model and its methods
      |
     */

    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'posting_agent_info';
    /**
     * Primary key of the table.
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * Indicates if the model should be timestamped.
     * @var bool
     */
    public $timestamps = FALSE;
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['user_id', 'card_full_name', 'card_number',
        'expiry_month', 'expiry_year', 'auth_net_card_payment_id'];

    /**
     * Method to insert posting agent details
     * or update if already present for the user.
     *
     * @param  int $userId            user Id
     * @param  array $userBillingInfo user's information
     *
     * @return Void
     */
    function saveAgentDetails($userId, $userBillingInfo)
    {
        // update posting agent data for the current user
        $postingAgentData = ['user_id' => $userId,
            'auth_net_card_payment_id' => $userBillingInfo['authorize_info']['auth_net_card_payment_id'],
            'card_full_name' => $userBillingInfo['card_full_name'],
            'card_number' => substr($userBillingInfo['card_number'], -4, 4),
            'expiry_month' => $userBillingInfo['expiry_month'],
            'expiry_year' => $userBillingInfo['expiry_year'],];

        $this::updateOrCreate(['user_id' => $userId], $postingAgentData);
    }
}
