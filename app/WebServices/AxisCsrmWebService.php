<?php

namespace App\WebServices;

use Artisaninweb\SoapWrapper\Extension\SoapService;
use Utils;
use Logs;

class AxisCsrmWebService extends SoapService {

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
	    // on log en debug
	    Logs::debug('WS', $e->getMessage());
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
	    $ret = Utils::cast($ret, $arguments[count($arguments) - 1]);
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
	try {
	    parent::__construct();
	} catch (\SoapFault $e) {
	    Logs::debug('WS', $e->getMessage());
	}
    }

}
