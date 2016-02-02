<?php

namespace App\Http\Controllers\Admin;

use Comments;
use Utils;
use App\Classes\Dialog\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller {

    public function __construct() {
	// toutes les méthodes sont accessible en ajax uniquement 
	$this->middleware('ajax');
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
	if (!$request->has('id')) {
	    return response()->json(['result' => false]);
	}
	$c = new Comment(Utils::unformatURI($request->get('id')));
	return response()->json(['result' => Comments::RemoveComment($c)]);
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

}
