<?php

namespace App\Classes\Dialog;

class PropertyObject extends Property {

    /**
     *
     * @var string 
     */
    private $ObjectURI;

    /**
     * 
     * @param string $ObjectURI
     * @param string $propURI
     * @param string $name
     */
    public function __construct($ObjectURI, $propURI, $name) {
	parent::__construct($propURI, $name);
	$this->ObjectURI = $ObjectURI;
    }

    /**
     * 
     * @return string
     */
    public function getObjectURI() {
	return $this->ObjectURI;
    }

    /**
     * 
     * @param string $ObjectURI
     */
    public function setObjectURI($ObjectURI) {
	$this->ObjectURI = $ObjectURI;
    }

}
