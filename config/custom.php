<?php
return [

    /*
      |--------------------------------------------------------------------------
      | Custom config data added here
      |--------------------------------------------------------------------------
      |
      | This file is used to add the custom config data
      |
     */
    'max_showing_houses' => 10,

    /*
      |--------------------------------------------------------------------------
      | Authorize.Net configuration added here
      |--------------------------------------------------------------------------
      |
     */
    'authorize_net_api_key' => '4sLjGk6Hx6A',
    'authorize_net_transaction_key' => '57b8NWt649daYvJa',
    'authorize_net_sandbox' => TRUE,

    /*
      |--------------------------------------------------------------------------
      | Agent user types
      |--------------------------------------------------------------------------
      |
     */
    'agent_types' => ['posting' => 1, 'showing' => 2, 'both_posting_showing'
    => 3],

    /*
      |--------------------------------------------------------------------------
      | Showings Search Criteria
      |--------------------------------------------------------------------------
      |
     */
    'showings_search_criteria' =>
        ['0' => 'Search by Name',
        '1' => '1+ ratings',
        '2' => '2+ ratings',
        '3' => '3+ ratings',
        '4' => '4+ ratings',
        '5' => '5 ratings',]
];
