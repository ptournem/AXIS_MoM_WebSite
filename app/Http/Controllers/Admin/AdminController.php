<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Semantics;
use App\Classes\Dialog\Entity;
use App\Classes\Dialog\Property;
use App\Http\Requests\Admin\AddEntityRequest;
use App\Http\Controllers\Controller;
use App\User;
use App\Repositories\UserRepository;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Blade;


class AdminController extends Controller
{
    protected $userRepository;
    
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function Index() {
        $users = User::all();
        $entities = Semantics::GetAllEntities();
        
        $data = array(
            'users'  => $users,
            'entities' => $entities
        );
        //return '' . print_r($users);
	return view('admin/admin')->with($data);
    }  
    
    public function addEntity($type, $name, $description, $image) {
        try{
            $entity = Semantics::AddEntity(new Entity("uRI",$name,$type,$image));
            
            //if($entity === Entity::class){
                $retour['success'] = true;
                $retour['type'] = $entity->type;
                $retour['URI'] = $entity->URI;
                $retour['name'] = $entity->name;
            //}
        }  
        catch (Exception $e){
            $retour['success'] = false;
        }
        
        return json_encode($retour);        
    }  
    
    public function view($uri) {
        $retours = Semantics::GetAllPropertiesAdmin(new Entity($uri,"namebabar",'type','image'));
        var_dump($retours);
        
        Blade::extend(function($value)
        {
            return preg_replace('/(\s*)@break(\s*)/', '$1<?php break; ?>$2', $value);
        });
        
        $data = array(
            'retours' => $retours
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
    
    public function updateEntityProperty($uri, $property, $value) {
        $retours = Semantics::SetEntityProperty(new Entity($uri,"namebabar",'type','image'), new Property(),
                new Entity($uri,"namebabar",'type','image'));
        if($retours)
            return json_encode (['success' => true]);
        else
            return json_encode (['success' => false]);
        
    } 
    
    public function deleteLOD($EntityID, $LODID) {  
        $retour = [true, $EntityID, $LODID];
        
        return json_encode($retour);
        return 'reponse id : ' . $id . 'reponse value : ' . $value;
        
        //TODO: update
    } 
    
}
