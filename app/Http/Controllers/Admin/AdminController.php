<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Semantics;
use Logs;
use Session;
use Validator;
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
	$this->middleware('auth');
    }

    public function getIndex() {
        $users = User::all();
        $entities = Semantics::GetAllEntities();
	$logs = Log::all()->sortByDesc('created_at')->forPage(1, self::NB_LOGS_SHOWN);
	$comments = Comments::LoadComment();
	$cComments = collect($comments);
        
        $data = array(
	    'users' => $users,
	    'entities' => $entities,
	    'logs' => $logs,
	    'comments' => $comments,
	    'nbCommentNotValidated' => $cComments->where("validated", false)->count()
	);
	return view('admin/admin')->with($data);
    }  
    
    public function postAddEntity(Request $request) {
	
	// on crée le validator pour la requête
	$validator = Validator::make($request->all(), [
		    'name' => 'required|max:255',
		    'type' => 'required|in:object,activity,person,event,location,organisation',
		    'image'=>"active_url|required_without_all:imgFile",
		    'imgFile'=>"required_without_all:image|image"
	]);
	
	// Si la requête fail, on revoit un tableau avec les errors
	if ($validator->fails()) {
	    return response()->json(['require' => $validator->errors()]);
	}
	
	// on regarde si on a une image a uploadé
	$imgFile = $request->file('imgFile');    
	if ($imgFile!=null && $imgFile->isValid()) {
	    // on récupère où on doit la stocker
	    $chemin = config('upload.path');
	    $extension = $imgFile->getClientOriginalExtension();
	    do {// on crée un nom aléatoire
		$nom = str_random(10) . '.' . $extension;
	    } while (file_exists($chemin . '/' . $nom));

	    // on déplace le fichier
	    if ($imgFile->move($chemin, $nom)) {
		// et on set son lien pour l'ajout
		$image = url('/') .'/'. $chemin . '/' . $nom;
	    }else  {
		//si error, on renvoie un json false
		return response()->json(['result' => false]);
	    }
	} else { // si pas de fichier image, on utilise le lien
	    $image  = $request->get('image');
	}

	// on récupère les inputs
        $name = $request->get('name');
        $type  = $request->get('type');
        try{
	    // on ajoute
            $entity = Semantics::AddEntity(new Entity(null,$name,$image,$type));
            
	    // si pas de soucis , on log et on renvoie true
            if(isset($entity->URI) && $entity->URI != null){
                Logs::add("SUCCEED : ADD ENTITY", "Name Entity : " . $name . " type : " . $type, session("user"));
		return response()->json(['result' => true]);
            } else { // sinon on renvoie un json false
		return response()->json(['result' => false]);
	    }
        }  
        catch (Exception $e){
	    // en cas d'erreur on log et on renvoie un JSON false
            Logs::add("FAILED : ADD ENTITY", "Name Entity : " . $name . " type : " . $type, session("user"));
	    return response()->json(['result' => false]);
        }
        
        return $retour;
    }  
    
    public function getView($uri) {
        $URIencode = $uri;
        $uri = Utils::unformatURI($uri);
        //var_dump($uri);
        $entity = new Entity($uri,"",'','');
        $retours = Semantics::GetAllPropertiesAdmin($entity);
        $entity = Semantics::GetEntity(new Entity($uri,"",'',''));
	$comments = Comments::LoadComment($entity);
	$cComments = collect($comments);
        //var_dump($retours);
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
	    'comments' => $comments,
	    'nbCommentNotValidated' => $cComments->where("validated", false)->count()
        );
	return view('admin/entityView')->with($data);
    }
    
    public function postSetProperty(Request $request) {
        if (!$request->has('uri') || !$request->has('name')
                || !$request->has('value') || !$request->has('type')) {
	    return response()->json(['result' => false]);
	}
        $uri  = $request->get('uri');
        $value  = $request->get('value');
        $name = $request->get('name');
        $type  = $request->get('type');
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
            Logs::add("SUCCED : SET PROPERTY", "Uri Entity : " . $uri . " name : " . $name . " value : " . $value . " type : " . $type, session("user"));
            return json_encode (['success' => true]);
        }
        else{
            Logs::add("FAILED : SET PROPERTY", "Uri Entity : " . $uri . " name : " . $name . " value : " . $value . " type : " . $type, session("user"));
            return json_encode (['success' => false]);            
        }
    } 
    
    public function postDeleteEntity(Request $request) {
        if (!$request->has('uri')) {
	    return response()->json(['result' => false]);
	}
        
        $uri  = $request->get('uri');
        
        $retours = Semantics::RemoveEntity(new Entity($uri, null, null, null));   
        
        if($retours){
            Logs::add("SUCCED : DELETE ENTITY", "Uri Entity : " . $uri, session("user"));
            return json_encode (['success' => true]);
        }
        else{
            Logs::add("FAILED : DELETE ENTITY", "Uri Entity : " . $uri, session("user"));
            return json_encode (['success' => false]);            
        }
    } 
    
    public function postDeleteEntityProperty(Request $request) { 
        if (!$request->has('uri') || !$request->has('name')
                || !$request->has('uriB')) {
	    return response()->json(['result' => false]);
	}
        $uri  = $request->get('uri');
        $uriB  = $request->get('uriB');
        $name = $request->get('name');
        $entityValue = new Entity($uriB, null, null, null);
        $property = new Property($name, null, null, null); 
        $retours = Semantics::RemoveEntityProperty(new Entity($uri, null, null, null), 
            $property, $entityValue);    
        
        return json_encode (['success' => TRUE]);
        if($retours){
            Logs::add("SUCCED : DELETE ENTITY PROPERTY", "Uri Entity : " . $uri . " name property : " . $name . " uri property : " . $uriB, session("user"));
            return json_encode (['success' => true]);
        }
        else{
            Logs::add("FAILED : DELETE ENTITY PROPERTY", "Uri Entity : " . $uri . " name property : " . $name . " uri property : " . $uriB, session("user"));
            return json_encode (['success' => false]);
        }
    }
    	
    public function postDeleteLiteralProperty(Request $request) { 
        if (!$request->has('uri') || !$request->has('name') ) {
	    return response()->json(['result' => "parametres non présent"]);
	}
        $uri  = $request->get('uri');
        $entityValue = new Entity("", null, null, null);
        $property = new Property($request->get('name'), null, null, null); 
        $retours = Semantics::RemoveEntityProperty(new Entity($uri, null, null, null), 
            $property, $entityValue);    
        
        return json_encode (['success' => TRUE]);
        if($retours){
            Logs::add("SUCCED : DELETE LITERAL PROPERTY", "Uri Entity : " . $uri . " name property : " . $name, session("user"));
            return json_encode (['success' => true]);
        }
        else{
            Logs::add("FAILED : DELETE LITERAL PROPERTY", "Uri Entity : " . $uri . " name property : " . $name, session("user"));
            return json_encode (['success' => false]);
        }
    }
    
    public function getPrintQrCode($uri){
	$entity = Semantics::GetEntity(new Entity(Utils::unformatURI($uri)));
	if($entity == null || $entity->name==null){
	    Session::flash('messages',array("L'entité dont vous souhaitez imprimer le QrCode n'éxiste pas"));
	    return redirect('admin');
	}
	return view('admin/printQrCode')->with(array('entity'=>$entity));
    }
    
     /**
     * Renvoie les recherches d'un tableau
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function anySearchEntitySameas(Request $request) {
	// on test que l'on a bien le needle sinon on renvoie un tableau vide
	if (!$request->has("needle") || $request->input("needle") == "") {
	    return response()->json([]);
	}

	// on renvoie ce que l'on obtient du web service 
	return response()->json(Semantics::SearchAllEntitiesFromText($request->input("needle")));
    }
    
}
