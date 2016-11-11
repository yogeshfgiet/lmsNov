<?php namespace App\Models;

use DB;
use App\Models\DtQuery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use GuzzleHttp\Client;
use App\Models\State;

class Showings extends Model {

    /*
      |--------------------------------------------------------------------------
      | Showing Model
      |--------------------------------------------------------------------------
      |
      | This Model will have all the functionality related to showings table
      | This uses the Eloquent ORM model and its methods
      |
     */

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'showings';
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
    public $timestamps = true;

    protected $fillable = [
    'user_id', 'post_date', 'start_time',
    'end_time', 'expiration_time', 'customer_name',
    'customer_email', 'customer_phone_number', 'additional_fee',
    'comments', 'house_count', 'search_criteria'
    ];

    /**
     * Get the houses that this showing has.
     *
     * @param  nothing
     * @return object having houses list
     */
    public function houses()
    {
        return $this->hasMany('App\Models\ShowingHouses', 'showing_id');
    }

    /**
     * Method to get all valid showings for the user
     *
     * @param  int $userId user's rating
     * @param  array $dtParams array having datatable parameters
     * @return object showings list
     */
    public function getValidShowingsForUser($userId, $dtParams)
    {
        $dtModel = new DtQuery();

        //Keys should be the keys requiested and value is the used column
        $allSortFields = $allFields = array('id' => 's.id', 'start_time'
            => 's.start_time',
            'user_name' => DB::raw('CONCAT(LEFT(u.first_name, 1), " ", u
                .last_name)'),
            'post_date' => 's.post_date', 'end_time' => 's.end_time',
            'expiration_time' => 's.expiration_time');
        $allSortFields['list_price'] = 'list_price';

        //Building a query
        $query = DB::table('showings AS s')
               //->distinct()
        ->select('s.id',
            DB::raw('CONCAT(UCASE(LEFT(first_name, 1)), ". ",
                CONCAT(UCASE(LEFT(last_name, 1)), LCASE(SUBSTRING(last_name, 2)))) AS user_name'),
            DB::raw('DATE_FORMAT(s.start_time, "%h:%i%p") AS start_time'),
            DB::raw('DATE_FORMAT(s.post_date, "%m-%d-%y") AS post_date'),
            DB::raw('DATE_FORMAT(s.end_time, "%h:%i%p") AS end_time'),
            's.expiration_time', 'house_count','s.additional_fee',
                    //'sh.list_price',
            DB::raw('CONCAT("$", TRUNCATE(SUM(sh.list_price+(s.additional_fee / house_count)), 2)) AS list_price')
            )
        ->leftJoin('showing_houses AS sh', 's.id', '=', 'sh.showing_id')
        ->leftJoin('users AS u', function($join) use($userId)
        {
            $join->on('u.id', '=', 's.user_id');
                       // ->where('u.id','=',$userId);

        })
        ->where('s.showing_progress', '=', 0)
        ->where('s.user_id', '!=',  $userId)
               // change Yogesh
        ->where('s.expiration_time', '>', DB::raw('NOW()'))

        ->groupBy('s.id');



        $query = $dtModel->setLimit($query, $dtParams);
        $query = $dtModel->setOrders($query, $dtParams, $allSortFields,
            //['s.start_time' => 'desc', 's.end_time' => 'desc', 's.expiration_time' => 'asc']
            ['s.expiration_time' => 'asc']
            );

        //Calling a closure function for where conditions
        $query = $query->where(function ($query) use ($dtModel, $dtParams,
            $allFields) {
            return $dtModel->setWhere($query, $dtParams, $allFields);
        });

        //Query to fetch total number or records
        $totalRecordsQuery = DB::table('showings AS s')
        ->select(DB::raw('count(distinct(s.id)) as total_records'))
        ->join('users AS u', function($join) use($userId)
        {
            $join->on('u.average_rating', '>=', 's.search_criteria')
            ->where('u.id','=',$userId);
        })
        ->where('s.showing_progress', '=', 0)
        ->where('s.user_id', '!=',  $userId)

        ->where('s.expiration_time', '>', DB::raw('NOW()'));

        //Calling a closure function for where conditions
        $totalRecordsQuery = $totalRecordsQuery
        ->where(function ($totalRecordsQuery)
           use ($dtModel, $dtParams, $allFields)
           {
            return $dtModel->setWhere($totalRecordsQuery, $dtParams, $allFields);
        });

        //Fetching data
        $currentRecords = $query->get(array('s.id', 's.start_time'));
        $totalNoOfRecords = $totalRecordsQuery->get();

        //builidng the datatable responses
        $dtResponse = $dtModel->prepareDtResponse($currentRecords,
            $totalNoOfRecords, $dtParams);

        return $dtResponse;
    }

    /**
     * Getting the house to show on map
     *
     * @param int userId
     * @return mixed
     */
    public function getAllShowingsForMap($userId)
    {
        //Building a query
        $result = DB::table('showing_houses AS sh')
        ->join('showings AS s', 's.id', '=', 'sh.showing_id')
        ->join('users AS u', function($join) use($userId)
        {
            $join->on('u.average_rating', '>=', 's.search_criteria')
            ->where('u.id','=',$userId);
        })
        ->select('sh.id','sh.showing_id', 'sh.address','sh.city', 'sh.state',  'sh.lat_long',
            DB::raw('DATE_FORMAT(s.start_time, "%m/%d/%Y %h:%i%p") AS
                start_time'),
            DB::raw('DATE_FORMAT(s.end_time, "%m/%d/%Y %h:%i%p") AS
                end_time'))
        ->where('s.showing_progress', '=', 0)
        ->where('s.expiration_time', '>', DB::raw('NOW()'))
        ->where('lat_long', '>', 0)
        ->where('s.user_id', '!=',  $userId)
        ->get();
        return $result;
    }

    /**
     * Method to get all showings that the user posted
     *
     * @param  int $userId user's id
     * @return object data showings list
     */
    public function getMyShowings($userId)
    {
        $showings = DB::table('showings AS s')
        ->join('showing_houses AS sh', 's.id', '=', 'sh.showing_id')
        ->where('s.user_id', '=', $userId)
        ->get(array('s.id', 's.start_time'));

        return $showings;
    }

    /**
     * Method to save showing details in DB added by user
     *
     * @param  int $userId user's id
     * @return object data showings list
     */
    public function saveShowingDetails($userObjAuth)
    {

        $userId=$userObjAuth->id;
        $getParams = Input::get();



         //$customer_phone_number =  $getParams['first_customer_phone_number'].$getParams['second_customer_phone_number'] . $getParams['third_customer_phone_number'];


        
            $postDate = date('Y-m-d', strtotime($getParams['post_date']));
            // update user's data for the current user
            $userObj = $this->create([
            'user_id' => $userId,
            'post_date' => date('Y-m-d', strtotime($getParams['post_date'])),
            //'start_time' => date('Y-m-d H:i:s', strtotime($getParams['start_time'])),
            //'end_time' => date('Y-m-d H:i:s', strtotime($getParams['end_time'])),
           // 'expiration_time' => date('Y-m-d ', strtotime($getParams['post_date'])),
            'start_time' => $postDate . " ". date('H:i:s', strtotime($getParams['start_time'])),
            'end_time' => $postDate . " ". date('H:i:s', strtotime($getParams['end_time'])),
            'expiration_time' => $postDate . " ". date('H:i:s', strtotime($getParams['end_time'])),
            'additional_fee' => $getParams['additional_fee'],
            'customer_name' => $getParams['customer_name'],
            'customer_email' => $getParams['customer_email'],
            'customer_phone_number' => $getParams['customer_phone_number'],
            'comments' => $getParams['comments'],
            'house_count' => $getParams['house_count'],
            //'search_criteria' => $getParams['search_criteria']
            ]);



            // get the last showing id and add insert the house details
            $lastShowingId = $userObj->id;
            $houseDetails = [];
            $addressDetails = $getParams['address'];
            $addressUnitnumber = $getParams['unit_number'];
            $addressCity = $getParams['city'];
            $addressState= $getParams['state'];
            $addressZip = $getParams['zip'];

            $listPriceDetails = $getParams['list_price'];
            $mlsNumberDetails = $getParams['MLS_number'];


             //$states[]= '';
                   // $states[] = DB::table('state')->where('id', '=', $addressState)->get();

                    //$mapaddress[]='';
            for ($i = 0; $i < $getParams['house_count']; $i++)
            {


                //$names[$i] = array($addressDetails[$i],$addressCity[$i],$states[$i]);

                // $mapaddress[$i] = implode(" ", $names[$i] );
                $houseDetails[$i]['showing_id'] = $lastShowingId;
                $houseDetails[$i]['address'] = $addressDetails[$i];

                $houseDetails[$i]['unit_number'] = $addressUnitnumber[$i];
                $houseDetails[$i]['city'] = $addressCity[$i];
                $houseDetails[$i]['state'] = $addressState[$i];
                $houseDetails[$i]['zip'] = $addressZip[$i];



                $houseDetails[$i]['list_price'] =
                str_replace('$', '', $listPriceDetails[$i]);
                $houseDetails[$i]['MLS_number'] = $mlsNumberDetails[$i];

                $states[] = DB::table('state') ->where('id', '=', $addressState[$i])->first();
                $names = array($addressDetails[$i],$addressCity[$i], $states[$i]->name);
                $mapaddress[] = implode(" ", $names );


                $address_latlong = $this->getLatLong($mapaddress, $i);
                $houseDetails[$i]['lat_long'] = json_encode($address_latlong);
            }

            DB::table('showing_houses')->insert($houseDetails);


            /*
            * calling function to send notificatin email when save saving by posting agent in DB
            *
            */
            $this->send_notification_on_save_savings($getParams,$userObjAuth);


    }

    /*
    * function use for send notificatin email when save saving by posting agent in DB
    *Params:- post details, posting agent info
    * Return type bool
    */
    public function send_notification_on_save_savings($post_details,$posting_agent_info_obj) {



       (new Email())->showingSaveNotification($post_details,$posting_agent_info_obj);

      //dd('mail sent');

       return true;


   }





    /**
     * Method to get specific showing details to view all house details
     *
     * @param  int $showingId showing id
     * @return object data showing detail
     */
    public function getShowingDetails($showingId)
    {
        $showings = DB::table('showings AS s')
        ->join('showing_houses AS sh', 's.id', '=', 'sh.showing_id')
        ->join('users AS u', 's.user_id', '=', 'u.id')
        ->where('s.id', '=', $showingId)
        ->get(array('s.id', 's.post_date', 's.start_time',
            's.end_time', 's.expiration_time', 's.customer_name',
            's.customer_email', 's.customer_phone_number',
            's.comments', 's.house_count', 's.showing_progress',
            's.status', 's.showing_user_id', 'sh.showing_id',
            'sh.address','sh.city','sh.state','sh.zip', 'sh.list_price', 'sh.MLS_number',
            'u.first_name', 'u.last_name', 'u.email'));

        return $showings;
    }

    /**
     * Getting lat long value from address using google maps api
     * @param $addressDetails
     * @param $i
     * @return string
     */
    private function getLatLong($mapaddress, $i)
    {
        $client = new Client();
        $res = $client->request('GET', 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $mapaddress[$i] . '&key=');

        $result = $res->getBody()->getContents();
        $result_array = json_decode($result, true);
        $address_latlong = isset($result_array['results'][0]) ? $result_array['results'][0]['geometry']['location'] : "";
        return $address_latlong;
    }

    /**
     * Functionlity to mark showing accepted
     * @param int $showingId
     * @param int $userId
     * @return boolean
     */
    public function markShowingAccepted($showingId, $userId)
    {


        $data = ['showing_user_id' => $userId,
        'showing_progress' => '1'];

        $updateResponse = DB::table('showings')
        ->where('id', $showingId)
        ->update($data);

        if($updateResponse) {
            return true;
        }
        return false;
    }

    /**
     * Functionlity to mark showing completed
     * @param int $showingId
     * @param int $userId
     * @return boolean
     */
    public function markShowingCompleted($showingId, $userId)
    {
        $data = ['showing_progress' => '4'];

        $updateResponse = DB::table('showings')
        ->where('id', $showingId)
        ->where('showing_user_id', $userId)
        ->update($data);

        if($updateResponse) {
            return true;
        }
        return false;
    }

    /**
     * Functionlity to mark showing accepted
     *
     * @param int $userId
     * @param array $dtParams
     * @param string $type
     * @return boolean
     */
    public function getUsersShowings($userId, $dtParams, $type)
    {

        $dtModel = new DtQuery();
        if(auth()->user()->user_type == 1){

        }elseif(auth()->user()->user_type == 2){

        }else{

        }
        //Keys should be the keys requiested and value is the used column
        $allSortingFields = $allFields = array('id' => 's.id', 'start_time' => 's.start_time',
            'user_name' => DB::raw('CONCAT(LEFT(u.first_name, 1), " ", u
                .last_name)'),
            'post_date' => 's.post_date', 'end_time' => 's.end_time',
            'expiration_time' => 's.expiration_time',);
        $allSortingFields['list_price'] = 'list_price';

        //Building a query
        $query = DB::table('showings AS s')
        ->distinct()
        ->select('s.id','rs.id as rejected_id',
            'rs.showing_agent_id as rejected_showing_agent_id',
            DB::raw('CONCAT(UCASE(LEFT(first_name, 1)), ". ",
                CONCAT(UCASE(LEFT(last_name, 1)), LCASE(SUBSTRING(last_name, 2)))) AS user_name'),
            DB::raw('DATE_FORMAT(s.start_time, "%h:%i%p") AS start_time'),
            DB::raw('DATE_FORMAT(s.post_date, "%m-%d-%y") AS post_date'),
            DB::raw('DATE_FORMAT(s.end_time, "%h:%i%p") AS end_time'),
            's.expiration_time', 'house_count','s.showing_progress','s.showing_user_id','s.additional_fee',
            DB::raw('CONCAT("$", TRUNCATE(SUM(sh.list_price +(s.additional_fee / house_count)), 2)) AS list_price')
            )                                             
        ->join('showing_houses AS sh', 's.id', '=', 'sh.showing_id')
        ->leftjoin('rejected_showings AS rs', 's.id', '=', 'rs.showing_id')
        ->groupBy('sh.showing_id');

        $query = $dtModel->setLimit($query, $dtParams);
        $query = $dtModel->setOrders($query, $dtParams, $allSortingFields,
            [
            //'s.start_time' => 'desc',
            //'s.end_time' => 'desc',
            's.expiration_time' => 'asc'
            ]);

        //Calling a closure function for where conditions
        $query = $query->where(function ($query) use ($dtModel, $dtParams,
            $allFields) {
            return $dtModel->setWhere($query, $dtParams, $allFields);
        });

        //Query to fetch total number or records
        $totalRecordsQuery = DB::table('showings AS s')
        ->select(DB::raw('count(distinct(s.id)) as total_records'));

        if('posted' === $type) {
            if(auth()->user()->user_type == 1){


                $query->join('users AS u', 'u.id', '=', 's.user_id')
                ->where('s.user_id', '=', $userId)
                ->where('rs.showing_agent_id', null);
                //->whereNotIn( 'rs.posting_agent_id',$userId);
                $totalRecordsQuery->join('users AS u', 'u.id', '=', 's.user_id')
                ->leftjoin('rejected_showings AS rs', 's.id', '=', 'rs.showing_id')
                ->where('s.user_id', '=', $userId)
                ->where('rs.showing_id', null);


            }
            else if(auth()->user()->user_type == 3){

              $query->join('users AS u', 'u.id', '=', 's.user_id')
              ->where('s.user_id', '=', $userId)
              ->where('rs.showing_agent_id', null);
              $totalRecordsQuery->join('users AS u', 'u.id', '=', 's.user_id')
              ->leftjoin('rejected_showings AS rs', 's.id', '=', 'rs.showing_id')
              ->where('s.user_id', '=', $userId)
              ->where('rs.showing_id', null);

          }
      } 
      else if('rejected' === $type){
        if(auth()->user()->user_type == 2){

         $query->join('users AS u', 'u.id', '=', 's.user_id')
                //->where('s.showing_user_id', '=', $userId)
         ->where('rs.showing_agent_id', '=', $userId);

         $totalRecordsQuery->leftjoin('rejected_showings AS rs', 's.id', '=', 'rs.showing_id')
         ->where('rs.showing_agent_id', '=', $userId);

     }


     else if(auth()->user()->user_type == 1){
        $query->join('users AS u', 'u.id', '=', 's.user_id')
        ->where('s.user_id', '=', $userId)
                 // ->where('s.showing_progress', '=', 2);
        ->where('rs.posting_agent_id', '=', $userId);

        $totalRecordsQuery->leftjoin('rejected_showings AS rs', 's.id', '=', 'rs.showing_id')
        ->where('rs.posting_agent_id', '=', $userId);

    }

    else if(auth()->user()->user_type == 3){
        $query->join('users AS u', 'u.id', '=', 's.user_id')
                   // ->where('s.user_id', '=', $userId)
                 // ->where('s.showing_progress', '=', 2);
        ->where('rs.posting_agent_id', '=', $userId)
        ->orwhere('rs.showing_agent_id', '=', $userId);

        $totalRecordsQuery->join('rejected_showings AS rs', 's.id', '=', 'rs.showing_id')
        ->where('rs.posting_agent_id', '=', $userId)
        ->orwhere('rs.showing_agent_id', '=', $userId);



    }

}
else if('completed' === $type){
    if(auth()->user()->user_type == 1){

        $query->join('users AS u', 'u.id', '=', 's.user_id')
        ->where('s.user_id', '=', $userId)       
        ->Where(function ($query)  {
            $query->orwhere('s.showing_progress', '=',6) 
            ->orwhere('s.showing_progress', '=',4) ;

        });


        $totalRecordsQuery->join('users AS u', 'u.id', '=', 's.user_id')
        ->where('s.user_id', '=', $userId)     
        ->Where(function ($query)  {
            $query->orwhere('s.showing_progress', '=',6) 
            ->orwhere('s.showing_progress', '=',4);
        });

    }



    else if(auth()->user()->user_type == 2){

     $query->join('users AS u', 'u.id', '=', 's.user_id')
     ->where('s.showing_user_id', '=', $userId)       
     ->Where(function ($query)  {
        $query->orwhere('s.showing_progress', '=',6) 
        ->orwhere('s.showing_progress', '=',4) ;

    });


     $totalRecordsQuery->join('users AS u', 'u.id', '=', 's.user_id')
     ->where('s.showing_user_id', '=', $userId)     
     ->Where(function ($query)  {
        $query->orwhere('s.showing_progress', '=',6) 
        ->orwhere('s.showing_progress', '=',4) ;
    });


 }


 else if(auth()->user()->user_type == 3){


    $query->join('users AS u', 'u.id', '=', 's.user_id')
    ->where('s.showing_user_id', '=', $userId)  
    ->Where(function ($query)  {
        $query->orwhere('s.showing_progress', '=',6) 
        ->orwhere('s.showing_progress', '=',4) ;

    });
    $totalRecordsQuery->join('users AS u', 'u.id', '=', 's.user_id')
    ->where('s.showing_user_id', '=', $userId)

    ->Where(function ($query)  {
        $query->orwhere('s.showing_progress', '=',6) 
        ->orwhere('s.showing_progress', '=',4);
    });

}

}
else if('bothcompleted' === $type){
  if(auth()->user()->user_type == 3){
     $query->join('users AS u', 'u.id', '=', 's.user_id')
     ->where('s.user_id', '=', $userId)  
     ->Where(function ($query)  {
        $query->orwhere('s.showing_progress', '=',6) 
        ->orwhere('s.showing_progress', '=',4) ;

    });
     $totalRecordsQuery->join('users AS u', 'u.id', '=', 's.user_id')
     ->where('s.user_id', '=', $userId)

     ->Where(function ($query)  {
        $query->orwhere('s.showing_progress', '=',6) 
        ->orwhere('s.showing_progress', '=',4);
    });

 }
}


else {
    if(auth()->user()->user_type == 1){
     $query->join('users AS u', 'u.id', '=', 's.user_id')
     ->where('s.user_id', '=', $userId)
     ->where('s.showing_progress', '=', 2);
                   //->where('rs.posting_agent_id', '=', $userId);

     $totalRecordsQuery->join('users AS u', 'u.id', '=', 's.user_id')
     ->where('s.user_id', '=', $userId)
     ->where('s.showing_progress', '=', 2);
 }elseif(auth()->user()->user_type == 2){
     $query->join('users AS u', 'u.id', '=', 's.user_id')
     ->where('s.showing_user_id', '=', $userId)
     ->where('rs.showing_agent_id', null);
                 //->orwhere('rs.showing_agent_id', '=', $userId);
     $totalRecordsQuery->join('users AS u', 'u.id', '=', 's.user_id')
     ->leftjoin('rejected_showings AS rs', 's.id', '=', 'rs.showing_id')
     ->where('s.showing_user_id', '=', $userId)
     ->where('rs.showing_agent_id', null);
                    // ->orwhere('rs.showing_agent_id', '=', $userId);
 }else{
     $query->join('users AS u', 'u.id', '=', 's.user_id')
     ->where('s.showing_user_id', '=', $userId);
     $totalRecordsQuery->join('users AS u', 'u.id', '=', 's.user_id')
     ->where('s.showing_user_id', '=', $userId);
 }

}

        //Calling a closure function for where conditions
$totalRecordsQuery = $totalRecordsQuery
->where(function ($totalRecordsQuery)
    use ($dtModel, $dtParams, $allFields)
    {
        return $dtModel->setWhere($totalRecordsQuery, $dtParams, $allFields);
    });

        //Fetching data
$currentRecords = $query->get(array('s.id', 's.start_time'));

$totalNoOfRecords = $totalRecordsQuery->get();


        //builidng the datatable responses
$dtResponse = $dtModel->prepareDtResponse($currentRecords,
    $totalNoOfRecords, $dtParams);

return $dtResponse;
}

    /**
     * Method to get specific showing details to view all house details
     *
     * @param  int $showingId showing id
     * @return object data showing detail
     */
    public function getPostingCustomerDetails($showingId)
    {
      $showings = DB::table('showings AS s')
      ->join('users AS u', 's.user_id', '=', 'u.id')
      ->where('s.id', '=', $showingId)
      ->get(array('s.id', 's.customer_name','u.id as user_id',
        's.customer_email','s.updated_at','s.showing_user_id as showing_user_id',
        'u.first_name', 'u.last_name', 'u.email'));


      return $showings;
  }

    /**
     * Method to get specific showing details along with houses
     *
     * @param  int $showingId showing id
     * @param  int $userId user id
     * @return object data showing detail
     */
    public function getShowingWithHouses($showingId, $userId)
    {
        $showings = DB::table('showings AS s')
        ->join('showing_houses AS sh', 's.id', '=', 'sh.showing_id')
        ->join('users AS u', 's.user_id', '=', 'u.id')
        ->where('s.id', '=', $showingId)
        ->get(array('s.id', 's.post_date', 's.start_time',
            's.additional_fee', 's.end_time', 's.expiration_time',
            's.customer_name', 's.customer_email', 's.customer_phone_number',
            's.search_criteria', 's.comments', 's.house_count',
            's.showing_progress', 's.status', 's.showing_user_id',
            'sh.id AS house_id', 'sh.showing_id','sh.showing_id',
            'sh.address','sh.unit_number','sh.city','sh.state','sh.zip', 'sh.list_price', 'sh.MLS_number'));
        return $showings;
    }

    /**
     * Method to save showing details in DB added by user
     *
     * @param  int $userId user's id
     * @param array postParams posted data
     * @return object data showings list
     */
    public function updateShowingDetails($userId, $postParams)
    {
        $postDate = date('Y-m-d', strtotime($postParams['post_date']));

        
        // update user's data for the current user
        $showingInfo = [
        'post_date' => $postDate,
        'start_time' => $postDate . " ". date('H:i:s', strtotime($postParams['start_time'])),
        'end_time' => $postDate . " ". date('H:i:s', strtotime($postParams['end_time'])),
        'expiration_time' => $postDate . " ". date('H:i:s', strtotime($postParams['end_time'])),
        'additional_fee' => $postParams['additional_fee'],
        'customer_name' => $postParams['customer_name'],
        'customer_email' => $postParams['customer_email'],
        'customer_phone_number' => $postParams['customer_phone_number'],
        'comments' => $postParams['comments'],
        'house_count' => $postParams['house_count']
           // 'search_criteria' => $postParams['search_criteria']
        ];

        $this::updateOrCreate(['id' => $postParams['showing_id'], 'user_id' => $userId],
            $showingInfo);

        $addressDetails = $postParams['address'];
        $addressUnitnumber = $postParams['unit_number'];
        $addressCity = $postParams['city'];
        $addressState = $postParams['state'];
        $addressZip = $postParams['zip'];
        $listPriceDetails = $postParams['list_price'];
        $mlsNumberDetails = $postParams['MLS_number'];

        //Delete all houses of the showing before inserting new
        DB::table('showing_houses')
        ->where('showing_id', '=', $postParams['showing_id'])
        ->delete();

        for ($i = 0; $i < $postParams['house_count']; $i++)
        {

            $states[] = DB::table('state') ->where('id', '=', $addressState[$i])->first();
            $names = array($addressDetails[$i],$addressCity[$i], $states[$i]->name);
            $mapaddress[] = implode(" ", $names );

            $address_latlong = $this->getLatLong($mapaddress, $i);
           // $address_latlong = $this->getLatLong($addressDetails, $i);
            $houseInfo = [
            'showing_id' => $postParams['showing_id'],
            'address' => $addressDetails[$i],
            'address' => $addressDetails[$i],
            'unit_number'=> $addressUnitnumber[$i],
            'city' => $addressCity[$i],
            'state' => $addressState[$i],
            'zip' => $addressZip[$i],
            'list_price' => str_replace('$', '', $listPriceDetails[$i]),
            'MLS_number' => $mlsNumberDetails[$i],
            'lat_long' => json_encode($address_latlong)
            ];

            DB::table('showing_houses')->insert($houseInfo);
        }

        //Send notificatin to showing agent
        $this->newshowingModifyNotification($postParams['showing_id'], 'modified',$showingInfo);

        return true;
    }

    /**
     * Method to delete showing details with its houses
     *
     * @param  int $id showing id
     * @param  int $userId user's id
     * @param array postParams posted data
     * @return object data showings list
     */
    public function deleteShowingWithHouses($id, $userId)
    {
        //Send notificatin before delete
        $this->showingModifyNotification($id, "cancelled");

        //Delete all houses of the showing
        DB::table('showing_houses')
        ->where('showing_id', '=', $id)
        ->delete();
        //delete showing
        DB::table('showings')
        ->where('id', '=', $id)
        ->where('user_id', '=', $userId)
        ->delete();
        return true;
    }

    /**
     * Method to send notification that the showing modified or cancelled
     *
     * @param  int $id showing id
     * @param  string modification type
     *
     * @return boolean
     */
    protected function showingModifyNotification($id, $changeType = "modified")
    {
        $userInfo = DB::table('showings AS s')
        ->join('users AS u', 's.showing_user_id', '=', 'u.id')
        ->where('s.id', '=', $id)
        ->get(array('u.first_name', 'u.email'));

        if(0 < count($userInfo)) {
            $userInfo = (array) $userInfo[0];
            (new Email())->sendShowingEditNotification($userInfo, $changeType);
        }

        //dd('mail sent');
        return true;
    }

      /**
     * Method to send notification that the showing modified or cancelled
     *  mail is going via new template
     * @param  int $id showing id
     * @param  string modification type
     *
     * @return boolean
     */
      protected function newshowingModifyNotification($id, $changeType = "modified",$showing_info)
      {
        $userInfo = DB::table('showings AS s')
        ->join('users AS u', 's.showing_user_id', '=', 'u.id')
        ->where('s.id', '=', $id)
        ->get(array('u.first_name', 'u.email'));

        if(0 < count($userInfo)) {
            $userInfo = (array) $userInfo[0];
            (new Email())->newShowingEditNotification($userInfo, $changeType,$showing_info);
        }

       // dd('mail sent');
        return true;
    }

    /**
     * Method to get specific showings complete details
     *
     * @param  int $showingId showing id
     *
     * @return object data showing detail
     */
    public function getCompleteShowingInfo($showingId)
    {
        $showings = DB::table('showings AS s')
        ->join('users AS u', 's.user_id', '=', 'u.id')
        ->join('showing_houses AS sh', 's.id', '=', 'sh.showing_id')
        ->leftJoin('users AS su', 's.showing_user_id', '=', 'su.id')
        ->where('s.id', '=', $showingId)
        ->get(array('s.id', 's.post_date', 's.start_time',
            's.end_time', 's.expiration_time', 's.customer_name',
            's.customer_email', 's.customer_phone_number',
            's.comments', 's.house_count', 's.showing_progress',
            's.status', 's.showing_user_id',
            'sh.address','sh.city','sh.state','sh.zip','sh.unit_number','sh.list_price', 'sh.MLS_number',
            'u.first_name AS pa_first_name', 'u.last_name AS pa_last_name','u.id AS pa_id',
            'u.email AS pa_email', 'u.phone_number AS pa_phone_number',
            'su.first_name AS sa_first_name',
            'su.last_name AS sa_last_name', 'su.email AS sa_email',
            'su.phone_number AS sa_phone_number'));
        return $showings;
    }

    public function getCompleteSAgent($showingId)
    {
        $showings = DB::table('showings AS s')
        ->join('users AS u', 's.user_id', '=', 'u.id')
        ->join('showing_houses AS sh', 's.id', '=', 'sh.showing_id')
        ->leftJoin('users AS su', 's.showing_user_id', '=', 'su.id')
        ->leftjoin('rejected_showings AS rs', 's.id', '=', 'rs.showing_id')
        ->leftJoin('users AS rsu', 'rs.showing_agent_id', '=', 'rsu.id')
        ->where('s.id', '=', $showingId)
        ->get(array(
            'u.first_name AS pa_first_name', 'u.last_name AS pa_last_name',
            'u.email AS pa_email', 'u.phone_number AS pa_phone_number', 'u.id AS pa_id',
            'su.first_name AS sa_first_name',
            'su.last_name AS sa_last_name', 'su.email AS sa_email',
            'su.phone_number AS sa_phone_number','rsu.first_name As r_first_name',
            'rsu.last_name As r_last_name',
            'rsu.phone_number AS r_phone_number',
            'rsu.email AS r_email', 'rsu.id AS r_id'

            ));
        return $showings;
    }


}

