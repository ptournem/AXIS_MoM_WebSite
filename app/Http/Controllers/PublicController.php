<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Semantics;
use Comments;
use Utils;
use App\Classes\Dialog\Entity;
use App\Classes\Dialog\Property;

class PublicController extends Controller {

    public function __construct() {
	// la méthode de recherche est uniquement disponible en ajax
	$this->middleware('ajax', ['only' => ['anySearchEntity', 'postComment']]);
    }

    /**
     * Montre la page d'index
     * @return type
     */
    public function anyIndex() {
//	$entity = new Entity("uRI","namebabar",'type','image');
//	$valueEntity = new Entity("1234","bibi",'Kind','png');
//	$property = new Property("is child of","babybel","oeuvre",$entity);
//	$comment = new Comment("babibel", "babibel@yopmail.com", "I enjoyed it !!!");
//	$ret = Semantics::AddEntity($entity);
//	$ret = Semantics::RemoveEntity($entity);
//	$ret = Semantics::SetEntityProperty($entity,$property,$valueEntity);
//	$ret = Semantics::RemoveEntityObjectProperty($entity,$property,$valueEntity);
//	$ret = Semantics::RemoveEntityObjectPropertyWithObject($entity,$property,$valueEntity);
//	$ret = Semantics::LoadEntityProperties($entity);
//	$ret = Semantics::SearchOurEntitiesFromText("our");
//	$ret = Semantics::SearchAllEntitiesFromText("all");
//	$ret = Semantics::GetAllEntities();
//	$ret = Semantics::GetAllPropertiesAdmin($entity);
//	$ret = Semantics::GetEntity($entity);
//	$ret = Comments::AddComment($comment);
//	$ret = Comments::GrantComment($comment);
//	$ret = Comments::RemoveComment($comment);
//	$ret = Comments::LoadComment($entity);
//	var_dump($ret);
	return view('welcome');
    }

    /**
     * Affiche une entité
     * @param string $uid
     * @return type
     */
    public function anyEntity($uid) {
	// variable globale pour les hashTags socialNetwork
	global $socialNetwork ;
	$socialNetwork = "";
	
	$uri = Utils::unformatURI($uid);
	$e = Semantics::GetEntity(new Entity($uri));

	// si l'entité est null, on redirect vers l'index
	if ($e == null) {
	    return redirect()->action('PublicController@anyIndex');
	}

	// on charge les commentaires puis on les mets dans une collection pour 
	// pouvoir les filtrer
	$comments = Comments::LoadComment($e);
	$cComments = collect($comments);

	// chargement des infos 
	$unformatedInfos = Semantics::LoadEntityProperties($e);
	$infos = $this->sortProperties($unformatedInfos);
	
	// création du texte pour les hashTags
	collect($unformatedInfos)->where("name", "socialnetwork")->each(function($item,$key){
	    global $socialNetwork;
	    $socialNetwork .= (($socialNetwork=="")?$item->value:",".$item->value);
	});

	// on les ajoute aux data
	$data = array(
	    'comments' => $cComments->where('validated', true), // comments filtrés
	    'infos' => $infos,
	    'entity' => $e,
	    'socialNetworkTags'=> $socialNetwork
	);

	// on renvoie la vue avec les datas
	return view('informations')->with($data);
    }

    /**
     * Renvoie les recherche d'un tableau
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function anySearchEntity(Request $request) {
	// on test que l'on a bien le needle sinon on renvoie un tableau vide
	if (!$request->has("needle") || $request->input("needle") == "") {
	    return response()->json([]);
	}

	// on renvoie ce que l'on obtient du web service 
	return response()->json(Semantics::SearchOurEntitiesFromText($request->input("needle")));
    }
    
    /**
     * Trie les propriété et renvoie un object avec un tableau de propriété literal (literal) et un tableau de propriété d'entite (object)
     * @param App\Classes\Dialog\Property $properties
     * @return \stdClass
     */
    private function sortProperties($properties) {
	$ret = new \stdClass();
	$ret->literal = [];
	$ret->object = [];
	$ret->connection = [];

	if (!is_array($properties)) {
	    return $ret;
	}

	foreach ($properties as $prop) {
	    if ($prop->type !== 'uri') { // pas de type URI, on mets dans les literaux
		$ret->literal[] = $prop;
	    } else {
		$ret->object[] = $prop; // C'est un objet
		if (is_object($prop->ent)) { // si la prop entity est un object, on l'ajoute en tant que property de connection
		    $ret->connection[] = new Property($prop->name, null, 'uri', Utils::cast($prop->ent, 'App\Classes\Dialog\Entity'));
		} elseif (is_array($prop->ent)) {// si c'est un tableau, on les ajoutes tous en tant que property de connection
		    foreach ($prop->ent as $conn) {
			$ret->connection[] = new Property($prop->name, null, 'uri', Utils::cast($conn, 'App\Classes\Dialog\Entity'));
		    }
		}
	    }
	}

	return $ret;
    }

}
