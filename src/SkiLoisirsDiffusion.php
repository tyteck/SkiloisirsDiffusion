<?php

namespace SkiLoisirsDiffusion;

use SimpleXMLElement;
use SkiLoisirsDiffusion\Datasets\CreateOrderDataset;
use SkiLoisirsDiffusion\Datasets\InsertOrderLineDataset;
use SkiLoisirsDiffusion\Datasets\MakeDataset;
use SkiLoisirsDiffusion\DatasetTables\ArticleDatasetTable;
use SkiLoisirsDiffusion\Exceptions\SLDGenericException;
use SkiLoisirsDiffusion\Exceptions\SLDPermissionDeniedException;
use SkiLoisirsDiffusion\Exceptions\SLDServiceNotAvailableException;
use SkiLoisirsDiffusion\Exceptions\TicketPlaceReservationException;
use stdClass;

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

    /**
     * @return string order number newly created
     */
    public function CREATION_COMMANDE(CreateOrderDataset $createOrderDataset): string
    {
        $arrayParams = [
            'CE_ID' => $this->partenaireId,
            'DS_DATA' => $createOrderDataset->dataset()
        ];

        $result = $this->soapClient->CREATION_COMMANDE($arrayParams);
        $body = $this->toSimpleXml($result->CREATION_COMMANDEResult->any);

        if ($body->NewDataSet->Commande->statut == 'false') {
            throw new SLDGenericException($body->NewDataSet->Commande->message_erreur);
        }

        return $body->NewDataSet->Commande->commandes_numero;
    }

    /**
     * @return int order number newly created
     */
    public function INSERTION_LIGNE_COMMANDE(int $orderNumber, InsertOrderLineDataset $insertLineOrder): string
    {
        $arrayParams = [
            'CE_ID' => $this->partenaireId,
            'commandes_numero' => $orderNumber,
            'DS_DATA' => $insertLineOrder->dataset()
        ];

        dump($arrayParams);
        $result = $this->soapClient->INSERTION_LIGNE_COMMANDE($arrayParams);
        $body = $this->toSimpleXml($result->INSERTION_LIGNE_COMMANDEResult->any);

        dump($body);
        if ($body->NewDataSet->Commande->statut == 'false') {
            throw new SLDGenericException($body->NewDataSet->Commande->message_erreur);
        }

        return $body->NewDataSet->Commande->commandes_numero;
    }

    /**
     * place one reservation on some article.
     *
     * @param \SkiLoisirsDiffusion\Datasets\ArticleDatasetTable $articleDatasetTable
     * @param string $ticketnetOrderId
     *
     * @throws \SkiloisirsDiffusion\Exceptions\TicketPlaceReservationException
     *
     * @return string $ticketnetOrderId
     */
    public function ticketPlaceReservation(ArticleDatasetTable $articleDatasetTable, string $ticketnetOrderId = ''):string
    {
        $arrayParams = [
            'CE_ID' => $this->partenaireId,
            'numero_commande_ticketnet' => $ticketnetOrderId,
            'DS_DATA' => MakeDataset::init()->addDatasetTable($articleDatasetTable)->dataset()
        ];

        $result = $this->soapClient->CREATION_COMMANDE($arrayParams);
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

    public function TEST_DATASET(stdClass $dataset)
    {
        $arrayParams = [
            'DS_DATA' => $dataset
        ];

        $result = $this->soapClient->TEST_DATASET($arrayParams);
        dump($result);
    }
}
