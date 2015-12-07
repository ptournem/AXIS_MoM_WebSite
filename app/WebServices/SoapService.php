<?php

namespace App\WebServices;

use Artisaninweb\SoapWrapper\Extension\SoapService;

class CurrencyService extends SoapService {

    /**
     * @var string
     */
    protected $name = 'currency';

    /**
     * @var string
     */
    protected $wsdl = 'http://currencyconverter.kowabunga.net/converter.asmx?WSDL';

    /**
     * @var boolean
     */
    protected $trace = true;

    /**
     * Get all the available functions
     *
     * @return mixed
     */
    public function functions() {
	return $this->getFunctions();
    }

    public function convert($currencyFrom, $currencyTo, $rateDate, $amount) {
	$data = [
	    'CurrencyFrom' => $currencyFrom,
	    'CurrencyTo' => $currencyTo,
	    'RateDate' => $rateDate,
	    'Amount' => $amount
	];
	
	return $this->call('GetConversionAmount', [$data])->GetConversionAmountResult;
    }

}
