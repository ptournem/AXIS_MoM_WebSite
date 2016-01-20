<?php

namespace App\WebServices;

use Artisaninweb\SoapWrapper\Extension\SoapService;

class AxisCsrmWebService extends SoapService {

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
    private function cast($instance, $className) {
	if ($this->endsWith($className, "[]")) {
	    $class = substr($className, 0, -2);
	    $ret = array();
	    
	    // doit être un tableau ou au moins un objet
	    if (!is_array($instance) && !is_object($instance)) {
		return null;
	    }
	    if (!class_exists($class)) {
		return null;
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
	    if (!class_exists($className)) {
		return $ret;
	    }

	    $ret = $this->_cast($instance, $className);
	}

	return $ret;
    }

    /**
     * Override du call pour caster automatique et renvoyer le resultat si il est dans un stdClass contenant un attribut result 
     * @param string $name
     * @param mixed $arguments
     * @return mixed
     */
    public function __call($name, $arguments) {
	// on fait appel à la fonction dans le WS
	try {
	    $ret = $this->call($name, $arguments);
	} catch (\Exception $e) {
	    // si erreur on retourne null
	    return null;
	}

	// si la réponse à une propriété return, on dit que renvoie la propriété
	if (property_exists($ret, 'return')) {
	    $ret = $ret->return;
	}
	// si on a au moins un argument et qu'il est texte
	if (count($arguments) > 0 && is_string($arguments[count($arguments) - 1])) {
	    // on essaye de caster la réponse 
	    $ret = $this->cast($ret, $arguments[count($arguments) - 1]);
	}

	// on renvoie le resultat 
	return $ret;
    }

    /**
     * @var string web service name
     */
    protected $name = 'AXIS_MoM_WS';

    /**
     * @var string wsdl link
     */
    protected $wsdl;

    /**
     * @var boolean 
     */
    protected $trace = false;

    /**
     * Get all the available functions
     *
     * @return mixed
     */
    public function functions() {
	return $this->getFunctions();
    }

    public function __construct() {
	// load the wsdl url from the config 
	$this->wsdl = config('webservices.AXIS_MoM_WSDL');
	parent::__construct();
    }

}
