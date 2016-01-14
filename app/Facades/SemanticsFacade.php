<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class SemanticsFacade extends Facade{

    protected static function getFacadeAccessor() {
	return 'Semantics';
    }

}
