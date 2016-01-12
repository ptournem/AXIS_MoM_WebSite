<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests\AuthRequest;
use App\Http\Controllers\Controller;
use App\User;

class AuthentificationController extends Controller
{
    public function postLogin(AuthRequest $request)
    {
        if(session('isConnected') != 'true'){
        $user = User::where('name', $request->input('name'))
                ->where('password', $request->input('password'))
                ->first();
        
        if(!is_object($user))
            return redirect()->back()->withInput()
            ->with('error','Identifiant ou mot de passe incorrecte'); //Gérer message d'erreur
        
        session(['isConnected' => 'true']);
        
        return redirect()->back();
        }
        else {
            return redirect()->back();
        }
    }
    
    public function postLogout()
    {
        session(['isConnected' => 'false']);
        return redirect()->back();
    }
}
