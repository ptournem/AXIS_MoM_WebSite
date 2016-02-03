<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Semantics;
use Logs;
use Comments;
use App\Classes\Dialog\Entity;
use App\Classes\Dialog\Property;
use App\Http\Requests\Admin\AddEntityRequest;
use App\Http\Controllers\Controller;
use App\User;
use App\Log;
use Utils;
use App\Repositories\UserRepository;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Blade;


class AdminController extends Controller
{
    /**
     * Nombre de logs affichés dans l'admin
     */
    const NB_LOGS_SHOWN = 20;
    protected $userRepository;
    
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function Index() {
        $users = User::all();
        $entities = Semantics::GetAllEntities();
	$logs = Log::all()->sortByDesc('created_at')->forPage(1, self::NB_LOGS_SHOWN);
	$comments = Comments::LoadComment();
        
        $data = array(
	    'users' => $users,
	    'entities' => $entities,
	    'logs' => $logs,
	    'comments' => $comments
	);
	return view('admin/admin')->with($data);
    }  
    
    public function addEntity($type, $name, $description, $image) {
        try{
            $entity = Semantics::AddEntity(new Entity("uRI",$name,Utils::unformatURI($image),$type));
            
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
        
        return $retour;
    }  
    
    public function view($uri) {
        $URIencode = $uri;
        $uri = str_replace('|', '/', $uri);
        //var_dump($uri);
        $entity = new Entity($uri,"",'','');
        $retours = Semantics::GetAllPropertiesAdmin($entity);
        $entity = Semantics::GetEntity(new Entity($uri,"",'',''));
	$comments = Comments::LoadComment($entity);
        //var_dump($retours[4]);
        $dbpedia = array();
        $dbpediaInfo = false;
        
        if($retours != null){
            foreach($retours as $retour){
                if($retour->name == 'sameas')
                    $dbpedia[] = $retour;
                if($retour->value_dbpedia != null
                    || $retour->entity_dbpedia != null){
                    $dbpediaInfo = true;
                    //var_dump($retour);
                }
            }
        }
        //var_dump($dbpedia);
        
        Blade::extend(function($value)
        {
            return preg_replace('/(\s*)@break(\s*)/', '$1<?php break; ?>$2', $value);
        });
        
        $data = array(
            'retours' => $retours,
            'dbpedia' => $dbpedia,
            'entity' => $entity,
            'URIencode' => $URIencode,
            'dbpediaInfo' => $dbpediaInfo,
	    'comments' => $comments
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
    
    public function setEntityProperty($uri, $name, $value, $type) {
        $uri  = Utils::unformatURI($uri);
        if($type != 'uri'){
            $entityValue = new Entity();
            $property = new Property($name, Utils::unformatURI($value), $type, null); 
            $retours = Semantics::SetEntityProperty(new Entity($uri,"",'',''), 
                $property, $entityValue);
        }
        else{
            $entityValue = new Entity(Utils::unformatURI($value), null, null, null);
            $property = new Property($name, null, $type, null);
            $retours = Semantics::SetEntityProperty(new Entity($uri,"",'',''), 
                $property, $entityValue);
        }
        
        if($retours){
            Logs::add("SUCCED : SET PROPERTY", "Uri Entity : " . $uri . " name : " . $name . " value : " . $value, session("user"));
            return json_encode (['success' => true]);
        }
        else{
            Logs::add("FAILED : SET PROPERTY", "Uri Entity : " . $uri . " name : " . $name . " value : " . $value, session("user"));
            return json_encode (['success' => false]);            
        }
        
    } 
    
    public function deleteEntityProperty($uri, $name, $uriB) { 
        //return $uri . ' ' . $name . ' ' . $uriB;
        $uri  = Utils::unformatURI($uri);
        $uriB  = Utils::unformatURI($uriB);
        $entityValue = new Entity($uriB, null, null, null);
        $property = new Property($name, null, null, null); 
        $retours = Semantics::RemoveEntityProperty(new Entity($uri, null, null, null), 
            $property, $entityValue);    
        
        return json_encode (['success' => true]);
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
