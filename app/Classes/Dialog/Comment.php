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
     * 
     * @param string $authorName
     * @param string $email
     * @param string $comment
     */
    function __construct($authorName = null, $email = null, $comment = null) {
	$this->authorName = $authorName;
	$this->email = $email;
	$this->comment = $comment;
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

}
