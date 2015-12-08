<?php

namespace App\WebServices;

use Artisaninweb\SoapWrapper\Extension\SoapService;

class AxisCsrmWebService extends SoapService {

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
