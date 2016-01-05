<?php

namespace App\Http\Controllers;

//use App\WebServices\CurrencyService;

class WelcomeController extends Controller {

    public function Index() {
	//$service = new CurrencyService();

	//$amount = $service->convert("USD", "AUD", "2014-06-05", 1000);

	return view('welcome');
    }

}
