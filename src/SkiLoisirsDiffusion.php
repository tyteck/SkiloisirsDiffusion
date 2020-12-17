<?php

namespace SkiloisirsDiffusion;

class SkiLoisirsDiffusion
{
    /** @var string $partenaireId */
    protected $partenaireId;

    private function __construct(string $partenaireId)
    {
        $this->partenaireId = $partenaireId;
    }

    public static function create(string $partenaireId)
    {
        return new static($partenaireId);
    }

    public function ETAT_SITE() :bool
    {
        $soapclient = new SoapClientNG(config('sld_domain_url') . '/Partenaire.svc?wsdl', ['cache_wsdl' => WSDL_CACHE_NONE]);
        $result = $soapclient->ETAT_SITE();
        if ($result->ETAT_SITEResult === true) {
            return true;
        }
        return false;
    }

    public function GET_LIEU(string $lieuId)
    {
        $soapclient = new SoapClientNG(config('sld_domain_url') . '/Partenaire.svc?wsdl', ['cache_wsdl' => WSDL_CACHE_NONE]);
        $result = $soapclient->GET_LIEU($this->partenaireId, $lieuId);
        return $this;
    }
}
