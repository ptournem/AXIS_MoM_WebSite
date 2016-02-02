<?php

namespace App\Classes\Dialog;

class Comment {

    /**
     * @var string
     */
    public $id;

    /**
     *
     * @var string 
     */
    public $authorName;

    /**
     *
     * @var string 
     */
    public $email;

    /**
     *
     * @var string 
     */
    public $comment;

    /**
     * @var boolean
     */
    public $validated;

    /**
     *
     * @var \App\Classes\Dialog\Entity
     */
    public $entity;

    /**
     *
     * @var String 
     */
    public $createDt;

    /**
     * 
     * @param string $id
     * @param string $authorName
     * @param string $email
     * @param string $comment
     * @param boolean $validated
     * @param \App\Classes\Dialog\Entity $entity
     * @param String $createDt
     */
    public function __construct($id = null, $authorName = null, $email = null, $comment = null, $validated = null, \App\Classes\Dialog\Entity $entity = null, Date $createDt = null) {
	$this->id = $id;
	$this->authorName = $authorName;
	$this->email = $email;
	$this->comment = $comment;
	$this->validated = $validated;
	$this->entity = $entity;
	$this->createDt = $createDt;
    }

    /**
     * 
     * @return string
     */
    function getAuthorName() {
	return $this->authorName;
    }

    /**
     * 
     * @return string
     */
    function getEmail() {
	return $this->email;
    }

    /**
     * 
     * @return string
     */
    function getComment() {
	return $this->comment;
    }

    /**
     * 
     * @param string $authorName
     */
    function setAuthorName($authorName) {
	$this->authorName = $authorName;
    }

    /**
     * 
     * @param string $email
     */
    function setEmail($email) {
	$this->email = $email;
    }

    /**
     * 
     * @param string $comment
     */
    function setComment($comment) {
	$this->comment = $comment;
    }

    /**
     * 
     * @return boolean
     */
    public function getValidated() {
	return $this->validated;
    }

    /**
     * 
     * @param boolean $validated
     */
    public function setValidated($validated) {
	$this->validated = $validated;
    }

    /**
     * 
     * @return string
     */
    public function getId() {
	return $this->id;
    }

    /**
     * 
     * @return \App\Classes\Dialog\Entity
     */
    public function getEntity() {
	return $this->entity;
    }

    /**
     * 
     * @return String
     */
    public function getCreateDt() {
	return $this->createDt;
    }

    /**
     * 
     * @param string $URI
     */
    public function setId($id) {
	$this->id = $id;
    }

    /**
     * 
     * @param \App\Classes\Dialog\Entity $entity
     */
    public function setEntity($entity) {
	$this->entity = $entity;
    }

    /**
     * 
     * @param String $createDt
     */
    public function setCreateDt($createDt) {
	$this->createDt = $createDt;
    }

}
