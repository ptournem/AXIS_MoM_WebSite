<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Semantics;
use App\Classes\Dialog\Entity;
use App\Http\Requests\Admin\AddEntityRequest;
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
    
    public function addEntity(AddEntityRequest $addEntityRequest) {
        try{
            $entity = Semantics::AddEntity();
            if($entity === Entity::class){
                
            }
        }  
        catch (Exception $e){
            return false;
        }
        // TODO appel WS
        return redirect()->back();
        
    }  
    
    public function view($id) {        
        $entity = array(array('Artiste', 'Jacques Louis David', 1), 
            array('Période', 'Néo-Classicisme', 2), 
            array('Support', 'Peinture à l\'huile', 3),
            array('Lieu', 'Musée du Louvre', 4)); 
        
        $itemName = 'Le sacre de Napoléon';
        
        $data = array(
            'entity'  => $entity,
            'itemName' => $itemName,
            'EntityID' => 4
        );
	return view('admin/entityView')->with($data);
    }  
    
    public function updateLOD($id, $value) {  
        //return true;
        $retour = [true, $id, $value];
        return $retour;
        
        return json_encode($retour);
        return 'reponse id : ' . $id . 'reponse value : ' . $value;
        
        //TODO: update
    } 
    
    public function deleteLOD($EntityID, $LODID) {  
        $retour = [true, $EntityID, $LODID];
        
        return json_encode($retour);
        return 'reponse id : ' . $id . 'reponse value : ' . $value;
        
        //TODO: update
    } 
    
}
