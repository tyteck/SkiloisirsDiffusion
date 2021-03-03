<?php

namespace SkiLoisirsDiffusion;

use SkiloisirsDiffusion\Exceptions\SLDServiceNotAvailableException;

class SkiLoisirsDiffusion
{
    /** @var string $partenaireId */
    protected $partenaireId;

    /** @var SoapClientNG $soapClient */
    protected $soapClient;

    private function __construct(string $sldDomainUrl, string $partenaireId)
    {
        $this->partenaireId = $partenaireId;
        $this->sldDomainUrl = $sldDomainUrl;
        $this->soapClient = new SoapClientNG("{$this->sldDomainUrl}/Partenaire.svc?wsdl", ['cache_wsdl' => WSDL_CACHE_NONE]);
        if (!$this->ETAT_SITE()) {
            throw new SLDServiceNotAvailableException();
        }
    }

    public static function create(string $sldDomainUrl, string $partenaireId)
    {
        return new static($sldDomainUrl, $partenaireId);
    }

    public function ETAT_SITE() :bool
    {
        $result = $this->soapClient->ETAT_SITE();
        return $result->ETAT_SITEResult === true;
    }

    public function GET_LIEU(string $lieuId)
    {
        $array_param = ['partenaire_id' => $this->partenaireId, 'lieux_id' => $lieuId, ];
        $result = $this->soapClient->GET_LIEU($array_param);

        $somewhatCleaner = html_entity_decode($result->GET_LIEUResult->any);

        $result = [];
        if (preg_match('#<lieux_plan>(?P<lieuxPlan>[^<]*)</lieux_plan>#', $somewhatCleaner, $match)) {
            $result['lieux_plan'] = $match['lieuxPlan'];
        }

        if (preg_match('#<lieux_nom>(?P<lieuxNom>[^<]*)</lieux_nom>#', $somewhatCleaner, $match)) {
            $result['lieux_nom'] = $match['lieuxNom'];
        }

        if (preg_match('#<lieux_id>(?P<lieuxId>[^<]*)</lieux_id>#', $somewhatCleaner, $match)) {
            $result['lieux_id'] = $match['lieuxId'];
        }

        return $result;
    }

    public function CREATION_COMMANDE()
    {
        $ce_id = '00000000-0000-0000-0000-000000000000';
        $signature = 'abcdefghijklmnopqrstuvwxyz';
        $arrayOfString = [
            'Ligne 1',
            'Ligne 2',
        ];
        $tablece = [
            'tableau_donnees' => $arrayOfString
        ];
        $tableuser = [
            'tableau_donnees' => $arrayOfString
        ];
        $tablecmd = [
            'tableau_donnees' => $arrayOfString
        ];
        $array_param = [
            'CE_ID' => $ce_id,
            'SIGNATURE' => $signature,
            'TABLE_CE' => $tablece,
            'TABLE_UTILISATEUR' => $tableuser,
            'TABLE_COMMANDE' => $tablecmd
        ];
        $testcreationcmdResult = $this->soapclient->CREATION_COMMANDE_ARRAY($array_param);
    }
}
