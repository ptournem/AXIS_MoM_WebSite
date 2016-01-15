<?php

namespace App\Classes\Dialog;

class Property {

    /**
     *
     * @var string 
     */
    public $URI;

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
     * @var App\Classes\Dialog\Property 
     */
    public $e;

    /**
     * 
     * @param string $URI
     * @param string $name
     * @param string $value
     * @param string $type
     * @param \App\Classes\Dialog\App\Classes\Dialog\Property $e
     */
    public function __construct($URI = null, $name = null, $value = null, $type = null, Entity $e = null) {
	$this->URI = $URI;
	$this->name = $name;
	$this->value = $value;
	$this->type = $type;
	$this->e = $e;
    }

    /**
     * 
     * @return string
     */
    public function getURI() {
	return $this->URI;
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
    public function getE() {
	return $this->e;
    }

    /**
     * 
     * @param string $URI
     */
    public function setURI($URI) {
	$this->URI = $URI;
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
    public function setE(App\Classes\Dialog\Property $e) {
	$this->e = $e;
    }

}
