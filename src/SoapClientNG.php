<?php

namespace SkiLoisirsDiffusion;

use SkiLoisirsDiffusion\Exceptions\SoapEmptyResponseException;
use SoapClient;

class SoapClientNG extends SoapClient
{
    protected const ENVELOPE_RESULT_INDEX = 6;

    public function __doRequest($request, $location, $action, $version = SOAP_1_2, $oneWay = null)
    {
        $stringResult = parent::__doRequest($request, $location, $action, $version, $oneWay);
        if ($stringResult === null || !strlen($stringResult)) {
            throw new SoapEmptyResponseException('SOAP response is empty.');
        }
        $xmlArray = explode("\r\n", $stringResult);
        if (!strlen($xmlArray[self::ENVELOPE_RESULT_INDEX])) {
            throw new SoapEmptyResponseException('SOAP response is not complete.');
        }
        $response = preg_replace('/^(\x00\x00\xFE\xFF|\xFF\xFE\x00\x00|\xFE\xFF|\xFF\xFE|\xEF\xBB\xBF)/', '', $xmlArray[self::ENVELOPE_RESULT_INDEX]);
        return $response;
    }
}
