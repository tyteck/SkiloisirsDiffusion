<?php

namespace SkiloisirsDiffusion;

use DOMDocument;
use SimpleXMLElement;

class SkiLoisirsDiffusion
{
    /** @var string $partenaireId */
    protected $partenaireId;

    /** @var SoapClientNG $soapClient */
    protected $soapClient;


    private function __construct(string $partenaireId)
    {
        $this->partenaireId = $partenaireId;
        $this->soapClient = new SoapClientNG(config('sld_domain_url') . '/Partenaire.svc?wsdl', ['cache_wsdl' => WSDL_CACHE_NONE]);
    }

    public static function create(string $partenaireId)
    {
        return new static($partenaireId);
    }

    public function ETAT_SITE() :bool
    {
        $result = $this->soapClient->ETAT_SITE();
        if ($result->ETAT_SITEResult === true) {
            return true;
        }
        return false;
    }

    public function GET_LIEU(string $lieuId)
    {
        $array_param = [ 'partenaire_id' => $this->partenaireId, 'lieux_id' => $lieuId, ];
        $result = $this->soapClient->GET_LIEU($array_param);

        $somewhatCleaner = html_entity_decode($result->GET_LIEUResult->any);
        
        $result = [];
        if (preg_match("#<lieux_plan>(?P<lieuxPlan>[^<]*)</lieux_plan>#", $somewhatCleaner, $match)) {
            $result['lieux_plan']=$match['lieuxPlan'];
        }

        if (preg_match("#<lieux_nom>(?P<lieuxNom>[^<]*)</lieux_nom>#", $somewhatCleaner, $match)) {
            $result['lieux_nom']=$match['lieuxNom'];
        }

        if (preg_match("#<lieux_id>(?P<lieuxId>[^<]*)</lieux_id>#", $somewhatCleaner, $match)) {
            $result['lieux_id']=$match['lieuxId'];
        }

        return $result;
    }
}
