<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

class ShowingAgent extends Model {

    /*
      |--------------------------------------------------------------------------
      | Showing Agent Model
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
    protected $table = 'showing_agent_info';
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
    protected $fillable = ['user_id', 'bank_name', 'account_name',
        'routing_number', 'account_number', 'account_type', 'holder_type',
        'mobile_pin_number', 'auth_net_bank_account_id'];

    /**
     * Method to insert showing agent details
     * or update if already present for the user.
     *
     * @param  int $userId           user Id
     * @param array $bankAccountInfo users bank account information
     *
     * @return Void
     */
    function saveAgentDetails($userId, $bankAccountInfo)
    {
        // update showing agent data for the current user
        $showingAgentData = ['user_id' => $userId,
            'auth_net_bank_account_id' => $bankAccountInfo['authorize_info']['auth_net_bank_account_id'],
            'bank_name' => $bankAccountInfo['bank_name'],
            'account_name' => $bankAccountInfo['account_name'],
            'routing_number' => $bankAccountInfo['routing_number'],
            'account_number' => $bankAccountInfo['account_number'],
            'account_type' => $bankAccountInfo['account_type'],
        ];
        $this::updateOrCreate(['user_id' => $userId], $showingAgentData);
    }
}
