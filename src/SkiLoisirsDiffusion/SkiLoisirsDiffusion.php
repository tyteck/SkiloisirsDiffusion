<?php

namespace SkiLoisirsDiffusion;

use SimpleXMLElement;
use SkiLoisirsDiffusion\Datasets\ArticleDataset;
use SkiLoisirsDiffusion\Datasets\CreateOrderDataset;
use SkiloisirsDiffusion\Exceptions\SLDPermissionDeniedException;
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
        if (!$this->ETAT_SITE()) {
            throw new SLDServiceNotAvailableException();
        }
    }

    public static function create(string $sldDomainUrl, string $partenaireId)
    {
        return new static($sldDomainUrl, $partenaireId);
    }

    public function ETAT_SITE(): bool
    {
        $result = $this->soapClient->ETAT_SITE();
        return $result->ETAT_SITEResult === true;
    }

    public function GET_MODES_PAIEMENTS(): array
    {
        $arrayParams = [
            'partenaire_id' => $this->partenaireId,
        ];
        $result = $this->soapClient->GET_MODES_PAIEMENTS($arrayParams);

        $body = $this->toSimpleXml($result->GET_MODES_PAIEMENTSResult->any);

        if ($body->NewDataSet->Paiements->statut == 'false') {
            throw new SLDPermissionDeniedException($body->NewDataSet->Paiements->message_erreur);
        }

        $results = [];
        foreach ($body->NewDataSet->Paiements as $paiement) {
            $paiementId = (string)$paiement->paiements_id;
            $results[$paiementId] = [
                'id' => $paiementId,
                'code' => trim($paiement->paiements_code),
                'reglement' => (string)$paiement->paiements_reglement,
                'redirect' => (string)$paiement->paiements_redirection,
                'name_fr' => (string)$paiement->paiements_nom_fr,
                'name_en' => (string)$paiement->paiements_nom_en,
                'description_fr' => (string)$paiement->paiements_indic_fr,
                'description_en' => (string)$paiement->paiements_indic_en,
                'ordre' => (string)$paiement->paiements_ordre,
            ];
        }
        return $results; // I still don't know why I get an error from SLD
    }

    public function GET_LIEU(string $lieuId): array
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

    public function toSimpleXml(string $xml): SimpleXMLElement
    {
        return simplexml_load_string(
            str_replace(['s:', 'diffgr:', 'xs:', 'msdata:'], '', $xml)
        );
    }
}
