<?php

namespace App\Helpers;

use App\LogActivity as LogActivityModel;
use Request;

class LogActivity
{
	 /**
	  * Add To Log
	  *
	  * @param string $subject
	  * @param array $newData
	  * @param array $oldData
	  * @return void
	  */
    public static function addToLog($subject, $oldData = [], $newData = [])
    {
        LogActivityModel::create([
            'subject'  => $subject,
            'url'      => Request::fullUrl(),
            'method'   => Request::method(),
            'ip'       => Request::ip(),
            'agent'    => Request::header('user-agent'),
            'user_id'  => auth()->check() ? auth()->user()->id : null,
            'old_data' => json_encode($oldData),
            'data'     => json_encode($newData),
        ]);
    }

    public static function logActivityLists()
    {
        return LogActivityModel::with('user')->latest()->get();
    }
}
