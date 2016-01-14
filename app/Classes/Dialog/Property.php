<?php

namespace App\Classes\Dialog;

class Property {

    /**
     *
     * @var string 
     */
    private $propURI;

    /**
     *
     * @var string 
     */
    private $name;

    /**
     * 
     * @param string $propURI
     * @param string $name
     */
    public function __construct($propURI, $name) {
	$this->propURI = $propURI;
	$this->name = $name;
    }

    /**
     * 
     * @return string
     */
    public function getPropURI() {
	return $this->propURI;
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
     * @param string $propURI
     */
    public function setPropURI($propURI) {
	$this->propURI = $propURI;
    }

    /**
     * 
     * @param string $name
     */
    public function setName($name) {
	$this->name = $name;
    }

}
