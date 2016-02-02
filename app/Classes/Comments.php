<?php

namespace App\Classes;

use App\WebServices\AxisCsrmWebService;
use App\Classes\Dialog\Comment;
use App\Classes\Dialog\Entity;

class Comments {

    private $service;

    public function __construct() {
	$this->service = new AxisCsrmWebService();
    }

    /**
     * Ajoute un commentaire
     * @param Comment $c
     * @param Entity $e
     * @return Comment
     */
    public function AddComment(Comment $c, Entity $e) {
	$request = new \stdClass();
	$request->c = $c;
	$request->e = $e;
	return $this->service->AddComment($request, 'App\Classes\Dialog\Comment');
    }

    /**
     * Valide un commentaire
     * @param Comment $c
     * @return bool
     */
    public function GrantComment(Comment $c) {
	$request = new \stdClass();
	$request->c = $c;
	return $this->service->GrantComment($request);
    }

    /**
     * Refuse un commentaire
     * @param Comment $c
     * @return bool
     */
    public function DenyComment(Comment $c) {
	$request = new \stdClass();
	$request->c = $c;
	return $this->service->DenyComment($request);
    }

    /**
     * Supprime un commentaire
     * @param Comment $c
     * @param Entity $e
     * @return bool
     */
    public function RemoveComment(Comment $c, Entity $e) {
	$request = new \stdClass();
	$request->c = $c;
	$request->e = $e;
	return $this->service->RemoveComment($request);
    }

    /**
     * Charge les commentaire si $e est settée sinon charge toutes les entités
     * @param Entity $e
     * @return Comment[]
     */
    public function LoadComment(Entity $e = null) {
	$request = new \stdClass();
	$request->e = $e;
	return $this->service->LoadComment($request, 'App\Classes\Dialog\Comment[]');
    }

}
