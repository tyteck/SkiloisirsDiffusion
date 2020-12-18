<?php

namespace SkiloisirsDiffusion;

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
        var_dump($result);die();
        return $this;
    }
}
