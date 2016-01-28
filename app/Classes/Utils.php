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
    
    /**
     * Renvoie true si needle sur trouve à la fin de haystack
     * @param string $haystack
     * @param string $needle
     * @return boolean
     */
    private function endsWith($haystack, $needle) {
	// search forward starting from end minus needle length characters
	return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
    }

    /**
     * Renvoie une instance castée en className
     * @param mixed $instance
     * @param string $className
     * @return mixed
     */
    private function _cast($instance, $className) {
	return unserialize(sprintf(
			'O:%d:"%s"%s', strlen($className), $className, strstr(strstr(serialize($instance), '"'), ':')
	));
    }

    /**
     * Renvoie une ou plusieurs instance castée en className ou tableau de className
     * @param mixed $instance
     * @param string $className
     * @return mixed
     */
    public function cast($instance, $className) {
	if ($this->endsWith($className, "[]")) {
	    $class = substr($className, 0, -2);
	    $ret = array();
	    
	    // doit être un tableau ou au moins un objet 
	    if (!is_array($instance) && !is_object($instance)) {
		return $ret;
	    }
	    
	    // si l'objet renvoyé n'a pas de propriété
	    if(count((array) $instance)<1){
		return $ret;
	    }
	    if (!class_exists($class)) {
		return $ret;
	    }

	    // si c'est un tableau , on les ajoute tous
	    if (is_array($instance)) {
		foreach ($instance as $obj) {
		    $ret[] = $this->_cast($obj, $class);
		}
	    } else if (is_object($instance)) {// sinon, on en ajoute qu'une 
		$ret[] = $this->_cast($instance, $class);
	    }
	} else {
	    $ret = null;
	    
	    // si la classe n'existe pas ou que l'objet n'a pas d'attributs
	    if (!class_exists($className) || count((array) $instance)<1 ) {
		return $ret;
	    }

	    $ret = $this->_cast($instance, $className);
	}

	return $ret;
    }

}
