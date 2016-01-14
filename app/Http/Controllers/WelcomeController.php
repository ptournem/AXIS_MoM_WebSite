<?php

namespace App\Http\Controllers;

class WelcomeController extends Controller {

    public function Index() {
	return view('welcome', array('convert' => 1));
    }

}
