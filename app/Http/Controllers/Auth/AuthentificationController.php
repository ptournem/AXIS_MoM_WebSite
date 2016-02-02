<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests\AuthRequest;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Controllers\PublicController;

class AuthentificationController extends Controller
{
    public function postLogin(AuthRequest $request)
    {
        if(session('isConnected') != true && is_object($session('user'))){
        $user = User::where('name', $request->input('name'))
                ->where('password', $request->input('password'))
                ->first();
        
        if(!is_object($user))
            return redirect()->back()->withInput()
            ->with('error','Identifiant ou mot de passe incorrecte'); //Gérer message d'erreur
        
	$request->session()->put('isConnected', true);
	$request->session()->put('user', $user);
        
        return redirect()->back();
        }
        else {
            return redirect()->back();
        }
    }
    
    public function postLogout(Request $request)
    {
	$request->session()->forget(array('isConnected','user'));
        return redirect()->to('');
    }
}
