<?php

namespace App\Http\Controllers;

use Comments;
use Utils;
use App\Classes\Dialog\Comment;
use App\Classes\Dialog\Entity;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller {

    public function __construct() {
	// toutes les méthodes sont accessible en ajax uniquement 
	$this->middleware('ajax');
	$this->middleware('isAdmin', ['except' => 'postComment']);
    }

    /**
     * Requête Ajax pour la validation d'un commentaire
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postGrantComment(Request $request) {
	if (!$request->has('id')) {
	    return response()->json(['result' => false]);
	}
	$c = new Comment(Utils::unformatURI($request->get('id')));
	return response()->json(['result' => Comments::GrantComment($c)]);
    }

    /**
     * Requête ajout pour la suppresion d'un commentaire
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postRemoveComment(Request $request) {
	if (!$request->has('id') || !$request->has('entity') ) {
	    return response()->json(['result' => false]);
	}
	$c = new Comment(Utils::unformatURI($request->get('id')));
	$e = new Entity(Utils::unformatURI($request->get('entity')));
	return response()->json(['result' => Comments::RemoveComment($c,$e)]);
    }

    /**
     * Requête ajax pour refuser un commentaire
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDenyComment(Request $request) {
	if (!$request->has('id')) {
	    return response()->json(['result' => false]);
	}
	$c = new Comment(Utils::unformatURI($request->get('id')));
	return response()->json(['result' => Comments::DenyComment($c)]);
    }

    public function postComment(Request $request) {

	// on crée le validator pour la requête
	$validator = Validator::make($request->all(), [
		    'Nom' => 'required|max:40|min:4',
		    'Mail' => 'required|email',
		    'Commentaire' => 'required'
	]);

	// Si la requête fail, on revoit un tableau avec les errors
	if ($validator->fails()) {
	    return response()->json(['require' => $validator->errors()]);
	}

	// on vérifie que l'on a bien une entité
	if (!$request->has('entity')) {
	    return response()->json(['result' => false]);
	}

	// sinon, on test l'envoie du commentaire
	return response()->json([
		    'result' => is_object(
			    Comments::AddComment(
				    new Comment(null,$request->get('Nom'), $request->get('Mail'), $request->get('Commentaire')), new Entity($request->get('entity'))
			    )
		    )
	]);
    }

}
