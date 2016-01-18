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

    public function AddComment(Comment $c) {
	$request = new \stdClass();
	$request->c = $c;
	return $this->service->AddComment($request, 'App\Classes\Dialog\Comment');
    }

    public function GrantComment(Comment $c) {
	$request = new \stdClass();
	$request->c = $c;
	return $this->service->GrantComment($request);
    }

    public function RemoveComment(Comment $c) {
	$request = new \stdClass();
	$request->c = $c;
	return $this->service->RemoveComment($request);
    }

    public function LoadComment(Entity $e) {
	$request = new \stdClass();
	$request->e = $e;
	return $this->service->LoadComment($request,'App\Classes\Dialog\Comment[]');
    }

}
