<?php

namespace App\Classes;

class Utils {

    /**
     * Format un url pour le passer en paramètre d'une requête get
     * @param String $uri
     * @return String
     */
    public function formatURI($uri) {
	return str_replace("/", "|", $uri);
    }

    /**
     * Deformat un url passé en paramètre d'une requête get
     * @param string $uri
     * @return string
     */
    public function unformatURI($uri) {
	return str_replace("|", "/", $uri);
    }

}
