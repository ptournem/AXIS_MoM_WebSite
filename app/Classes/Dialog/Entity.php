<?php

namespace App\Classes\Dialog;

class Entity {

    /**
     *
     * @var string 
     */
    private $URI;

    /**
     *
     * @var string
     */
    private $name;

    /**
     * 
     * @param string $URI
     * @param string $name
     */
    public function __construct($URI, $name) {
	$this->URI = $URI;
	$this->name = $name;
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

}
