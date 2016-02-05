<?php

namespace App\Http\Controllers\Admin;

use App\Log;
use App\Http\Controllers\Controller;

class LogsController extends Controller {
   public function __construct() {
       $this->middleware('ajax');
       $this->middleware('isAdmin');
   }
    
   public function postDeleteLog(){
       Log::truncate();
       
       return response()->json(['result' =>Log::all()->count()==0]);
       
   }
}
