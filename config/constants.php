<?php
/**
 * Created by PhpStorm.
 * User: brcon
 * Date: 01/02/2017
 * Time: 13:46
 */

return [

    /*
    |--------------------------------------------------------------------------
    | User Defined Variables
    |--------------------------------------------------------------------------
    |
    | This is a set of variables that are made specific to this application
    | that are better placed here rather than in .env file.
    | Use config('your_key') to get the values.
    |
    */

    'base_client_uri' => env('BASE_CLIENT_URI','http://localhost:9001'),
    'base_server_uri' => env('BASE_SERVER_URI','http://happy-hour.beer'),
//    'base_server_uri' => env('BASE_SERVER_URI','http://localhost:8000'),

    'minutes_for_user_cancel_order' => env('MINUTES_FOR_USER_CANCEL_ORDER','5'),

];