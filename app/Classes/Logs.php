<?php

namespace App\Classes;

use App\Log;

class Logs {

    const ACTION_ADD = "ADD";
    const ACTION_EDIT = "EDIT";
    const ACTION_DEL = "DELETE";

    public function __construct() {
	
    }

    public function add($action, $message, $user) {
	$log = new Log();
	$log->message = "$action : $message";
	if (is_object($user) && hasEntry("id", $user)) {
	    $log->user_id = $user->id;
	}
	$log->save();
    }

    public function debug($type, $message, $user) {
	if (env('APP_DEBUG', false) == true) {
	    $this->add("DEBUG $type", $message, $user);
	}
    }

}
