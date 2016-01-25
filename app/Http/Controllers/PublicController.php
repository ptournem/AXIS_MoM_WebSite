<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Semantics;
use Comments;
use Validator;
use Utils;
use App\Classes\Dialog\Entity;
use App\Classes\Dialog\Property;
use App\Classes\Dialog\Comment;

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
	$uri = Utils::unformatURI($uid);
	$e = Semantics::GetEntity(new Entity($uri));

	// si l'entité est null, on redirect vers l'index
	if ($e == null) {
	    return redirect()->action('PublicController@anyIndex');
	}

	// on charge les commentaires et les properties
	$comments = Comments::LoadComment($e);
	$infos = $this->sortProperties(Semantics::LoadEntityProperties($e));


	// on les ajoute aux data
	$data = array(
	    'comments' => $comments,
	    'infos' => $infos,
	    'entity' => $e
	);

	// on renvoie la vue
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
	    if ($prop->type !== 'uri') {
		$ret->literal[] = $prop;
	    } else {
		$ret->object[] = $prop;
		if (is_object($prop->ent)) {
		    $ret->connection[] = new Property($prop->name, null, 'uri', Utils::cast($prop->ent, 'App\Classes\Dialog\Entity'));
		} elseif (is_array($prop->ent)) {
		    foreach ($prop->ent as $conn) {
			$ret->connection[] = new Property($prop->name, null, 'uri', Utils::cast($conn, 'App\Classes\Dialog\Entity'));
		    }
		}
	    }
	}

	return $ret;
    }

    public function postComment(Request $request) {

	$validator = Validator::make($request->all(), [
		    'Nom' => 'required|max:40|min:4',
		    'Mail' => 'required|email',
		    'Commentaire' => 'required'
	]);

	if ($validator->fails()) {
	    return response()->json(['require' => $validator->errors()]);
	}

	return response()->json(['result' => is_object(Comments::AddComment(new Comment($request->get('Nom'), $request->get('Mail'), $request->get('Commentaire'))))]);
    }

}
