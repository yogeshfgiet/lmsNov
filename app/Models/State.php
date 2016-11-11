<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model {

    /*
      |--------------------------------------------------------------------------
      | State Model
      |--------------------------------------------------------------------------
      |
      | This Model will have all the functionality related to state table
      | This uses the Eloquent ORM model and its methods
      |
     */

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'state';

    /**
     * Primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Method to get all state list for USA country (for now)
     * and send to registration page.
     *
     * @param  int $countryId country Id
     * @return data into auth/register view page
     */
    public function getAllStatesByCountryId($countryId=1)
    {
        $states = $this::where('country_id', '=', $countryId)->lists('name',
            'id');
        return $states;
    }

}
