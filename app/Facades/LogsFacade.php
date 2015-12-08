<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class LogsFacade extends Facade {

    protected static function getFacadeAccessor() {
	return 'Logs';
    }

}
