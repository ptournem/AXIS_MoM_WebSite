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
        $entity = new Entity("uRI","namebabar",'type','image');
        $ret = Semantics::LoadEntityProperties($entity);
        $LODs = array();
        
        foreach($ret as $re){
            if($re->type == 'sameas')
                $LODs[$re->name] = $re;
        }
        var_dump($LODs);
        $entity = array(array('Artiste', 'Jacques louis david', true), 
            array('Période', 'Néo-Classicisme', false),
            array('Date', '', false),
            array('Personne', '', false),
            array('Droit', '', false),
            array('Support', 'Peinture à l\'huile', true),
            array('Lieu', 'Musée du Louvre', false)); 
        
        $itemName = 'Le sacre de Napoléon';
        
        $LODs = array(array('DBPedia', 1, array('Jacques Louis David', '1750-1830', '', '', '', '', ''), array(false, true, false, false, false, false, false)), 
            array('Freebase', 2, array('Jacques-Louis David', '', '', '', '', '', 'Musée du Louvre'), array(false, false, false, false, false, false, true)));
        
        $data = array(
            'retours' => $ret,
            'entity'  => $entity,
            'itemName' => $itemName,
            'LODs' => $LODs,
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
