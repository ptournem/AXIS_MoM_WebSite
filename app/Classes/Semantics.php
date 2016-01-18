<?php

namespace App\Classes;

use App\WebServices\AxisCsrmWebService;
use App\Classes\Dialog\Entity;
use App\Classes\Dialog\Property;
use App\Classes\Dialog\Comment;

class Semantics {

    private $service;

    public function __construct() {
	$this->service = new AxisCsrmWebService();
    }

    public function AddEntity(Entity $e) {
	$request = new \stdClass();
	$request->e = $e;
	return $this->service->AddEntity($request, 'App\Classes\Dialog\Entity');
    }

    public function RemoveEntity(Entity $e) {
	$request = new \stdClass();
	$request->e = $e;
	return $this->service->RemoveEntity($request);
    }

    public function SetEntityProperty(Entity $e, Property $p, Entity $valueEntity) {
	$request = new \stdClass();
	$request->e = $e;
	$request->p = $p;
	$request->valueEntity = $valueEntity;
	return $this->service->SetEntityProperty($request);
    }

    public function RemoveEntityObjectProperty(Entity $e, Property $p, Entity $valueEntity) {
	$request = new \stdClass();
	$request->e = $e;
	$request->p = $p;
	$request->valueEntity = $valueEntity;
	return $this->service->RemoveEntityObjectProperty($request);
    }

    public function RemoveEntityObjectPropertyWithObject(Entity $e, Property $p, Entity $valueEntity) {
	$request = new \stdClass();
	$request->e = $e;
	$request->p = $p;
	$request->valueEntity = $valueEntity;
	return $this->service->RemoveEntityObjectPropertyWithObject($request);
    }

    public function LoadEntityProperties(Entity $e) {
	$request = new \stdClass();
	$request->e = $e;
	return $this->service->LoadEntityProperties($request, 'App\Classes\Dialog\Property[]');
    }

    public function SearchOurEntitiesFromText($needle) {
	$request = new \stdClass();
	$request->needle = $needle;
	return $this->service->SearchOurEntitiesFromText($request, 'App\Classes\Dialog\Entity[]');
    }

    public function SearchAllEntitiesFromText($needle) {
	$request = new \stdClass();
	$request->needle = $needle;
	return $this->service->SearchAllEntitiesFromText($request, 'App\Classes\Dialog\Entity[]');
    }

    public function GetAllEntities() {
	$request = new \stdClass();
	return $this->service->GetAllEntities($request, 'App\Classes\Dialog\Entity[]');
    }

    public function GetAllPropertiesAdmin(Entity $e) {
	$request = new \stdClass();
	$request->e = $e;
	return $this->service->GetallPropertiesAdmin($request, 'App\Classes\Dialog\PropertyAdmin[]');
    }

}
