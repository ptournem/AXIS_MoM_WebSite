<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
	return view('welcome');
    }

    /**
     * Affiche une entité
     * @param string $uid
     * @return type
     */
    public function anyEntity($uid) {
	$comments = array(array('Robin', 'très belle oeuvre'),
	    array('Riad', 'wallah elle chill cette tablette'),
	    array('Corentin', 'moi aime pas trop'),
	    array("$uid", "uid de la page"));

	$infos = array(array('Artiste', 'Jacques Louis David'),
	    array('Période', 'Néo-Classicisme'),
	    array('Support', 'Peinture à l\'huile'),
	    array('Lieu', 'Musée du Louvre'));

	$itemName = 'Le sacre de Napoléon';

	$data = array(
	    'comments' => $comments,
	    'infos' => $infos,
	    'itemName' => $itemName
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
	return response()->json(array(
		    array("label" => "Leonard De Vinci", "category" => "Activite", "id" => "1"),
		    array("label" => "Leonard De Vinci", "category" => "Activite", "id" => "1"),
		    array("label" => "Leonard De Vinci", "category" => "Activite", "id" => "1"),
		    array("label" => "David Bowie", "category" => "Evènement", "id" => "2"),
		    array("label" => "David Bowie", "category" => "Evènement", "id" => "2"),
		    array("label" => "David Bowie", "category" => "Lieu", "id" => "2"),
		    array("label" => "David Bowie", "category" => "Lieu", "id" => "2"),
		    array("label" => "La Joconde", "category" => "Organisation", "id" => "3"),
		    array("label" => "La Joconde", "category" => "Organisation", "id" => "3"),
		    array("label" => "La Joconde", "category" => "Objet", "id" => "3"),
		    array("label" => "La Joconde", "category" => "Objet", "id" => "3"),
		    array("label" => "La Joconde", "category" => "Personne", "id" => "3"),
		    array("label" => "La Joconde", "category" => "Personne", "id" => "3"),
		    array("label" => "La Joconde", "category" => "Oeuvre", "id" => "3"),
		    array("label" => "La Joconde", "category" => "Oeuvre", "id" => "3"),
	));
    }

}
