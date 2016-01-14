<?php

namespace App\Classes\Dialog;

class PropertyText extends Property {

    /**
     *
     * @var string
     */
    private $value;

    /**
     * 
     * @param string $value
     * @param string $propURI
     * @param string $name
     */
    function __construct($value, $propURI, $name) {
	parent::__construct($propURI, $name);
	$this->value = $value;
    }

    /**
     * 
     * @return string
     */
    function getValue() {
	return $this->value;
    }

    /**
     * 
     * @param string $value
     */
    function setValue($value) {
	$this->value = $value;
    }

}
