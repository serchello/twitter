<?php
namespace App\Helpers;
use Request;
use App\LogActivity as LogActivityModel;

class LogActivity
{

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\LogActivityModel
     */
    public static function addToLog()
    {
        $logActivity = new LogActivityModel;
        $logActivity->user_id =  auth()->user()->id;
        $logActivity->username = auth()->user()->username ;
        $logActivity->url =  Request::fullUrl();
        $logActivity->method = Request::method();
        $logActivity->save();	
    }

}