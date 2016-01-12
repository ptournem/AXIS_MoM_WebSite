<?php

namespace App\Classes\Dialog;

class Comment {

    /**
     *
     * @var string 
     */
    private $AuthorName;

    /**
     *
     * @var string 
     */
    private $email;

    /**
     *
     * @var string 
     */
    private $comment;

    /**
     * 
     * @param string $AuthorName
     * @param string $email
     * @param string $comment
     */
    function __construct($AuthorName, $email, $comment) {
	$this->AuthorName = $AuthorName;
	$this->email = $email;
	$this->comment = $comment;
    }

    /**
     * 
     * @return string
     */
    function getAuthorName() {
	return $this->AuthorName;
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
     * @param string $AuthorName
     */
    function setAuthorName($AuthorName) {
	$this->AuthorName = $AuthorName;
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
