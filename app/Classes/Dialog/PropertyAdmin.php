<?php

namespace App\Classes\Dialog;

class PropertyAdmin {

    /**
     *
     * @var String 
     */
    public $name;

    /**
     *
     * @var String 
     */
    public $value_locale;

    /**
     *
     * @var String 
     */
    public $value_dbpedia;

    /**
     *
     * @var App\Classes\Dialog\PropertyAdmin 
     */
    public $entity_locale;

    /**
     *
     * @var App\Classes\Dialog\PropertyAdmin 
     */
    public $entity_dbpedia;

    /**
     *
     * @var string 
     */
    public $type;

    /**
     * 
     * @param String $name
     * @param String $value_locale
     * @param String $value_dbpedia
     * @param App\Classes\Dialog\PropertyAdmin $entity_locale
     * @param App\Classes\Dialog\PropertyAdmin $entity_dbpedia
     * @param String $type
     */
    public function __construct($name = null, $value_locale = null, $value_dbpedia = null, $entity_locale = null, $entity_dbpedia = null, $type = null) {
	$this->name = $name;
	$this->value_locale = $value_locale;
	$this->value_dbpedia = $value_dbpedia;
	$this->entity_locale = $entity_locale;
	$this->entity_dbpedia = $entity_dbpedia;
	$this->type = $type;
    }

    /**
     * 
     * @return String
     */
    public function getName() {
	return $this->name;
    }

    /**
     * 
     * @return String
     */
    public function getValue_locale() {
	return $this->value_locale;
    }

    /**
     * 
     * @return String
     */
    public function getValue_dbpedia() {
	return $this->value_dbpedia;
    }

    /**
     * 
     * @return App\Classes\Dialog\PropertyAdmin
     */
    public function getEntity_locale() {
	return $this->entity_locale;
    }

    /**
     * 
     * @return App\Classes\Dialog\PropertyAdmin
     */
    public function getEntity_dbpedia() {
	return $this->entity_dbpedia;
    }

    /**
     * 
     * @param String $name
     */
    public function setName(String $name) {
	$this->name = $name;
    }

    /**
     * 
     * @param String $value_locale
     */
    public function setValue_locale(String $value_locale) {
	$this->value_locale = $value_locale;
    }

    /**
     * 
     * @param String $value_dbpedia
     */
    public function setValue_dbpedia(String $value_dbpedia) {
	$this->value_dbpedia = $value_dbpedia;
    }

    /**
     * 
     * @param App\Classes\Dialog\PropertyAdmin $entity_locale
     */
    public function setEntity_locale(String $entity_locale) {
	$this->entity_locale = $entity_locale;
    }

    /**
     * 
     * @param App\Classes\Dialog\PropertyAdmin $entity_dbpedia
     */
    public function setEntity_dbpedia(String $entity_dbpedia) {
	$this->entity_dbpedia = $entity_dbpedia;
    }

    /**
     * 
     * @return String
     */
    public function getType() {
	return $this->type;
    }

    /**
     * 
     * @param String $type
     */
    public function setType($type) {
	$this->type = $type;
    }

}
