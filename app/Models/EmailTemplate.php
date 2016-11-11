<?php

namespace App\Models;

use DB;
use App\Models\DtQuery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use GuzzleHttp\Client;
use Validator;


class EmailTemplate extends Model
{
      /*
      |--------------------------------------------------------------------------
      | EmailTemplate t Model
      |--------------------------------------------------------------------------
      |
      | This Model will have all the functionality related to EmailTemplate 
      | This uses the Eloquent ORM model and its methods
      |
     */

    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'email_templates';
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
    protected $fillable = ['name', 'dis_name', 'subject',
        'from_name', 'from_email_id', 'from_email_title','content','created_at','updated_at'];




      /**
     * Get a validator for an incoming showing request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function templateValidator(array $data)
    {
        return Validator::make($data,
            [
            'subject' => 'required',
            'content' => 'required',
            ]
            );
    }


    public static function getvalues($row, $values_array = array(), $subject_val_array = array())
    {
            if($row)
            {
                
                if(count($values_array))
                {
                        $arr_keys = array_keys($values_array);
                        $arr_values = array_values($values_array);

                        $email_content = str_replace($arr_keys, $arr_values, $row->content);
                      
                        $row->content = $email_content;
                }

                if(!empty($subject_val_array))
                {
                    $arr_keys = array_keys($subject_val_array);
                    $arr_values = array_values($subject_val_array);
                    $row->subject = str_replace($arr_keys, $arr_values, $row->subject);
                }

                return $row;
            }
    }
}
