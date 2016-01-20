<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Semantics;
use Comments;
use Utils;
use App\Classes\Dialog\Entity;
use App\Classes\Dialog\Property;
use App\Classes\Dialog\Comment;

class PublicController extends Controller {

    public function __construct() {
	// la méthode de recherche est uniquement disponible en ajax
	$this->middleware('ajax', ['only' => ['anySearchEntity']]);
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
	$uri  = Utils::unformatURI($uid);
	$e = Semantics::GetEntity(new Entity($uri));
	$comments = Comments::LoadComment($e);
	$infos = $this->sortProperties(Semantics::LoadEntityProperties($e));


	$data = array(
	    'comments' => $comments,
	    'infos' => $infos,
	    'entity' => $e
	);
	return view('informations')->with($data);
    }

    /**
     * Renvoie les recherche d'un tableau
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function anySearchEntity(Request $request) {
	if (!$request->has("needle")) {
	    return response()->json([]);
	}

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
	foreach ($properties as $prop) {
	    if ($prop->type !== 'URI') {
		$ret->literal[] = $prop;
	    } else {
		$ret->object[] = $prop;
	    }
	}

	return $ret;
    }

}
