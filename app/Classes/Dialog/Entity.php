<?php

namespace App\Classes\Dialog;

class Entity {

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
    public $image;

    /**
     *
     * @var string 
     */
    public $type;

    /**
     * 
     * @param string $URI
     * @param string $name
     * @param string $image
     * @param string $type
     */
    function __construct($URI = null, $name = null, $image = null, $type = null) {
	$this->URI = $URI;
	$this->name = $name;
	$this->image = $image;
	$this->type = $type;
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

    /**
     * 
     * @return string
     */
    function getImage() {
	return $this->image;
    }

    /**
     * 
     * @return string
     */
    function getType() {
	return $this->type;
    }

    /**
     * 
     * @param string $image
     */
    function setImage($image) {
	$this->image = $image;
    }

    /**
     * 
     * @param string $type
     */
    function setType($type) {
	$this->type = $type;
    }

}
