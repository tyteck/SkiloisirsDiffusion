<?php

namespace SkiLoisirsDiffusion;

use SimpleXMLElement;
use SkiLoisirsDiffusion\Exceptions\SLDGenericException;

class OrderStatus
{
    /** @var string $sldDomainUrl */
    protected $sldDomainUrl;

    /** @var array $deliveryModes */
    protected $status = [];

    private function __construct(string $sldDomainUrl)
    {
        $this->sldDomainUrl = $sldDomainUrl;
    }

    public static function init(...$params)
    {
        return new static(...$params);
    }

    public function fromRemote()
    {
        $fileContent = file_get_contents($this->sldDomainUrl . '/flux_etats_commandes.aspx');
        $etats = new SimpleXMLElement($fileContent);

        foreach ($etats as $etat) {
            $this->status[trim($etat->etats_id)] = trim($etat->etats_nom);
        }
        return $this;
    }

    public function fromLocal()
    {
        $this->status = [
            'e65715d6-b734-4846-8550-15c60981ae12' => 'Cartes cadeaux en cours de réapprovisionnement',
            '6e70a77a-bc9c-49b6-a07d-51fa7fcb53be' => 'Commande à disposition du coursier',
            'c74d90d7-ec72-4fb2-8556-89d6251e8933' => 'Commande à votre disposition',
            'c482f6d7-5ea6-48f4-8f0f-2999baf7103e' => 'Commande annulée',
            '85c1259a-b9cd-491f-af17-6e8ae30167ce' => 'Commande bloquée',
            'b4f85f79-1167-4307-a503-c62384b9d653' => 'Commande en attente de paiement',
            '7ef7c216-7c8c-4a8f-9c90-1861d1bb81a6' => 'Commande en cours de préparation',
            '166be7dd-f03e-40bf-a5d7-3cc7126363b5' => 'Commande en cours de validation',
            'edd486e4-5fc8-4e72-a663-f7dc5c6fbd2c' => 'Commande envoyée',
            '74777da0-93a4-46ec-870e-2220d40978e6' => 'Commande envoyée par le système',
            '407ef0cf-596c-40e7-8b04-d74bc5640455' => 'Commande envoyée sur facturation',
            'ce396be9-c19d-4965-9181-cba77baa3cd6' => 'Commande et paiement confirmés',
            'c5944e7e-6e3c-40c3-8682-9c86552e10f1' => 'Commande non finalisée',
            'e0d519b5-07e1-427f-888b-a802a8bd84dd' => 'Commande non payée',
            '1155b458-8356-4bc8-a86d-43280a38aae4' => 'Commande réceptionnée mais non validée par votre établissement bancaire. Contactez le Service Client',
            '202d2092-7089-49b0-a881-c722ffe80941' => 'Commande remboursée',
            '58081e43-f3ca-4da3-a74b-65345ae6e544' => 'Commande retirée',
            '5e40967f-0dd6-42b8-be86-9217dff70cb2' => 'Commande sur facturation',
            '84d4e36f-2426-418b-86c8-d6dd7e3c90b0' => 'Commande Test',
            'f5cccf5b-922d-4e20-97aa-cf8f2e690075' => 'Commande Test WCF',
            'f5a46a3c-ed9b-476f-9bb3-021cd6c0efde' => 'E-Billets cinémas en cours de réapprovisionnement',
            'f9fd34d5-26a3-4298-baff-70906c98790d' => 'E-Billets en cours de réapprovisionnement',
            'e985be84-fdb6-444d-925a-e4567901e147' => 'Paiement CB refusé',
        ];
        return $this;
    }

    public function status()
    {
        return $this->status;
    }

    public function label(string $statusId)
    {
        if (!count($this->status)) {
            $this->fromRemote();
        }
        if (!array_key_exists($statusId, $this->status)) {
            throw new SLDGenericException("This order status {$statusId} does not exists.");
        }
        return $this->status[$statusId];
    }
}
