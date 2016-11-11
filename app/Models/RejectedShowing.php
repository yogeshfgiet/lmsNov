<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RejectedShowing extends Model
{
    
     /*
      |--------------------------------------------------------------------------
      | Rejected Showing t Model
      |--------------------------------------------------------------------------
      |
      | This Model will have all the functionality related to showings rejected 
      | This uses the Eloquent ORM model and its methods
      |
     */

    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'rejected_showings';
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
    protected $fillable = ['showing_id', 'posting_agent_id', '	showing_agent_id',
        'date', 'created_at', 'updated_at'];

    /**
     * Method to insert showing agent details
     * or update if already present for the user.
     */
   
}
