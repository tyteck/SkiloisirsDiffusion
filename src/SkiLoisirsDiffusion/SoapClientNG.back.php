<?php

namespace SkiLoisirsDiffusion;

use Exception;
use SkiLoisirsDiffusion\Exceptions\SoapEmptyResponseException;
use SoapClient;
use SoapFault;

class SoapClientNG extends SoapClient
{
    protected const ENVELOPE_RESULT_INDEX = 6;

    public function __doRequest($request, $location, $action, $version = SOAP_1_2, $oneWay = null)
    {
        try {
            $this->__last_request = $request;
            $response = parent::__doRequest($request, $location, $action, $version, $oneWay);
        } catch (SoapFault $soapFault) {
            /** @todo add log */
            die("with soapfault : {$soapFault->getMessage()}");
        } catch (Exception $exception) {
            /** @todo add log */
            die("with exception : {$exception->getMessage()}");
        }

        if ((isset($this->__soap_fault)) && ($this->__soap_fault != null)) {
            //this is where the exception from __doRequest is stored
            $exception = $this->__soap_fault;
            die("soapfault catched after : $exception->getMessage()");
        }

        if ($response === null) {
            throw new SoapEmptyResponseException('SOAP response is empty.');
        }

        /**
         * skiloisirs is customizing the response with some garbage
         * it doesn't return clean xml.
         */
        $xmlWithNameSpaces = $this->extractXml($response);

        /** working without namespaces is faster */
        $cleanXml = $this->removeAllNamespaces($xmlWithNameSpaces);
        echo "\n------\n$cleanXml";
        $simpleXml = simplexml_load_string($cleanXml);
        echo "\n------\n" . get_class($simpleXml);

        return $simpleXml;
    }

    public function removeAllNamespaces($xml)
    {
        return str_replace(['s:', 'diffgr:', 'xs:', 'msdata:'], '', $xml);
    }

    public function extractXml(string $skiloisirsResponse)
    {
        $resultLines = explode("\r\n", $skiloisirsResponse);
        if (!strlen($resultLines[self::ENVELOPE_RESULT_INDEX])) {
            throw new SoapEmptyResponseException('SOAP response is not complete.');
        }

        return preg_replace('/^(\x00\x00\xFE\xFF|\xFF\xFE\x00\x00|\xFE\xFF|\xFF\xFE|\xEF\xBB\xBF)/', '', $resultLines[self::ENVELOPE_RESULT_INDEX]);
    }
}
