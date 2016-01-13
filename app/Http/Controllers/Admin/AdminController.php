<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Repositories\UserRepository;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;


class AdminController extends Controller
{
    protected $userRepository;
    
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function Index() {
        $users = User::all();
        
        $entities = array(array('name' => 'La Joconde', 'type' => 'Objet', 'id' => 1), 
            array('name' => 'Le sacre de Napoléon', 'type' => 'Objet', 'id' => 2), 
            array('name' => 'Le mortier du roi Den', 'type' => 'Objet', 'id' => 3),
            array('name' => 'De Vinci', 'type' => 'Personne', 'id' => 4)); 
        
        $data = array(
            'users'  => $users,
            'entities' => $entities
        );
        //return '' . print_r($users);
	return view('admin/admin')->with($data);
    }  
    
    public function addEntity(Request $request) {
        // TODO appel WS
        return redirect()->back();
    }  
    
    public function view($id) {
        return 'lala : ' . $id;
        return redirect()->back();
    }  
}
