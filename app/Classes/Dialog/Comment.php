<?php

namespace App\Classes\Dialog;

class Comment {

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
     * @param string $authorName
     * @param string $email
     * @param string $comment
     */
    function __construct($authorName = null, $email = null, $comment = null, $validated = false) {
	$this->authorName = $authorName;
	$this->email = $email;
	$this->comment = $comment;
	$this->validated = $validated;
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

}
