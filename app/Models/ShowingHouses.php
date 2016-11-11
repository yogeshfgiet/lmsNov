<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShowingHouses extends Model {

    /*
      |--------------------------------------------------------------------------
      | ShowingHouses Model
      |--------------------------------------------------------------------------
      |
      | This Model will have all the functionality related to Showing Houses table
      | This uses the Eloquent ORM model and its methods
      |
     */

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'showing_houses';
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
     * Get the showing that owns the house.
     * 
     * @param  nothing
     * @return object having showing
     */
    public function showing()
    {
        return $this->belongsTo('App\Models\Showings', 'showing_id');
    }

}
