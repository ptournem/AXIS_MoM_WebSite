<?php

namespace App\Http\Controllers;


class WelcomeController extends Controller {

    public function Index() {


	return view('welcome');
    }

    public function Infos() {

	return view('informations');
    }
    
    public function Admin() {

	return view('admin/admin');
    }
    
}
