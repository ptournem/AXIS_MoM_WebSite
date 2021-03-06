<?php

namespace App\Classes\Dialog;

class Property {

    /**
     *
     * @var string 
     */
    public $name;

    /**
     *
     * @var string 
     */
    public $value;

    /**
     *
     * @var string 
     */
    public $type;
    
    /**
     * 
     */
    public $lang;

    /**
     *
     * @var App\Classes\Dialog\Property 
     */
    public $ent;

    /**
     * 
     * @param string $name
     * @param string $value
     * @param string $type
     * @param \App\Classes\Dialog\App\Classes\Dialog\Property $e
     * @param string $lang
     */
    public function __construct($name = null, $value = null, $type = null, Entity $ent = null,$lang = null) {
	$this->name = $name;
	$this->value = $value;
	$this->type = $type;
	$this->ent = $ent;
	$this->lang = $lang;
    }

    /**
     * 
     * @return string
     */
    public function getName() {
	return $this->name;
    }

    /**
     * 
     * @return string
     */
    public function getValue() {
	return $this->value;
    }

    /**
     * 
     * @return string
     */
    public function getType() {
	return $this->type;
    }

    /**
     * 
     * @return string
     */
    public function getEnt() {
	return $this->ent;
    }

    /**
     * 
     * @param string $name
     */
    public function setName($name) {
	$this->name = $name;
    }

    /**
     * 
     * @param string $value
     */
    public function setValue($value) {
	$this->value = $value;
    }

    /**
     * 
     * @param string $type
     */
    public function setType($type) {
	$this->type = $type;
    }

    /**
     * 
     * @param \App\Classes\Dialog\App\Classes\Dialog\Property $e
     */
    public function setEnt(App\Classes\Dialog\Property $ent) {
	$this->ent = $ent;
    }
    
    /**
     * 
     * @return string
     */
    public function getLang() {
	return $this->lang;
    }

    /**
     * 
     * @param strig $lang
     */
    public function setLang($lang) {
	$this->lang = $lang;
    }



}
