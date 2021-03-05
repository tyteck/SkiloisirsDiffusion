<?php

namespace SkiLoisirsDiffusion;

use SkiLoisirsDiffusion\Datasets\ArticleDataset;
use SkiLoisirsDiffusion\Datasets\CreateOrderDataset;
use SkiloisirsDiffusion\Exceptions\NotImplementedException;
use SkiloisirsDiffusion\Exceptions\SLDServiceNotAvailableException;
use SkiloisirsDiffusion\Exceptions\TicketPlaceReservationException;

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
        if (!$this->sldStatus()) {
            throw new SLDServiceNotAvailableException();
        }
    }

    public static function create(string $sldDomainUrl, string $partenaireId)
    {
        return new static($sldDomainUrl, $partenaireId);
    }

    public function sldStatus() :bool
    {
        $result = $this->soapClient->ETAT_SITE();
        return $result->ETAT_SITEResult === true;
    }

    public function GET_MODES_PAIEMENTS() :bool
    {
        $result = $this->soapClient->GET_MODES_PAIEMENTS($this->partenaireId);
        $foo = simplexml_load_string($result);
        return $result->ETAT_SITEResult === true;
    }

    public function GET_LIEU(string $lieuId)
    {
        $arrayParams = [
            'partenaire_id' => $this->partenaireId,
            'lieux_id' => $lieuId,
        ];
        $result = $this->soapClient->GET_LIEU($arrayParams);

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

    public function CREATION_COMMANDE(CreateOrderDataset $createOrderDataset)
    {
        throw new NotImplementedException();
        $arrayParams = [
            'CE_ID' => $this->partenaireId,
            'DS_DATA' => $createOrderDataset->dataset()
        ];

        $result = $this->soapClient->CREATION_COMMANDE($arrayParams);
        var_dump($result);
    }

    /**
     * place one reservation on some article.
     *
     * @param \SkiLoisirsDiffusion\Datasets\ArticleDataset $articleDataset
     * @param string $ticketnetOrderId
     *
     * @throws \SkiloisirsDiffusion\Exceptions\TicketPlaceReservationException
     *
     * @return string $ticketnetOrderId
     */
    public function ticketPlaceReservation(ArticleDataset $articleDataset, string $ticketnetOrderId = ''):string
    {
        $arrayParams = [
            'CE_ID' => $this->partenaireId,
            'numero_commande_ticketnet' => $ticketnetOrderId,
            'DS_DATA' => $articleDataset->dataset()
        ];
        var_dump($arrayParams);

        $result = $this->soapClient->CREATION_COMMANDE($arrayParams);
        var_dump($result);
        if (!$result->status) {
            throw new TicketPlaceReservationException("Reservation has failed with message {$result->message_erreur}");
        }
        return $result->numero_commande_ticketnet;
    }
}
