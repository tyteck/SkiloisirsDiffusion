<?php

namespace SkiLoisirsDiffusion\Datasets;

use SkiLoisirsDiffusion\Interfaces\Dataset;
use stdClass;

class OrderDataset implements Dataset
{
    /** @var stdClass $dataset */
    protected $dataset;

    /** @var string $tablename */
    protected $tablename = 'commande';

    private function __construct(array $attributes = [])
    {
        $this->nb_cheques_vacances = $attributes['nb_cheques_vacances'] ?? null;
        $this->montant_total_cheques_vacances = $attributes['montant_total_cheques_vacances'] ?? null;
        $this->mode_paiement = $attributes['mode_paiement'] ?? null;
        $this->prix_livraison = $attributes['prix_livraison'] ?? null;
        $this->code_livraison = $attributes['code_livraison'] ?? null;
        $this->commentaire = $attributes['commentaire'] ?? null;
        $this->livraison_adresse_societe = $attributes['livraison_adresse_societe'] ?? null;
        $this->livraison_adresse_nom = $attributes['livraison_adresse_nom'] ?? null;
        $this->livraison_adresse_1 = $attributes['livraison_adresse_1'] ?? null;
        $this->livraison_adresse_2 = $attributes['livraison_adresse_2'] ?? null;
        $this->livraison_codepostal = $attributes['livraison_codepostal'] ?? null;
        $this->livraison_ville = $attributes['livraison_ville'] ?? null;
        $this->livraison_pays = $attributes['livraison_pays'] ?? null;
        $this->url_retour = $attributes['url_retour'] ?? null;
        $this->url_retour_ok = $attributes['url_retour_ok'] ?? null;
        $this->url_retour_err = $attributes['url_retour_err'] ?? null;
        $this->acompte = $attributes['acompte'] ?? null;
        $this->numero_commande_ticketnet = $attributes['numero_commande_ticketnet'] ?? null;
        $this->frais_gestion_payeur = $attributes['frais_gestion_payeur'] ?? null;
        $this->frais_port_payeur = $attributes['frais_port_payeur'] ?? null;
        $this->remise_frais_port = $attributes['remise_frais_port'] ?? null;
        $this->numero_commande_distributeur = $attributes['numero_commande_distributeur'] ?? null;

        $this->dataset = new stdClass();
        $this->dataset->schema = '
<xs:element name="' . $this->tablename . '">
    <xs:complexType>
        <xs:sequence>
            <xs:element name="nb_cheques_vacances" type="xs:string" minOccurs="0" />
            <xs:element name="montant_total_cheques_vacances" type="xs:string" minOccurs="0" />
            <xs:element name="mode_paiement" type="xs:string" minOccurs="0" />
            <xs:element name="prix_livraison" type="xs:decimal" minOccurs="0" />
            <xs:element name="code_livraison" type="xs:string" minOccurs="0" />
            <xs:element name="commentaire" type="xs:string" minOccurs="0" />
            <xs:element name="livraison_adresse_societe" type="xs:string" minOccurs="0" />
            <xs:element name="livraison_adresse_nom" type="xs:string" minOccurs="0" />
            <xs:element name="livraison_adresse_1" type="xs:string" minOccurs="0" />
            <xs:element name="livraison_adresse_2" type="xs:string" minOccurs="0" />
            <xs:element name="livraison_codepostal" type="xs:string" minOccurs="0" />
            <xs:element name="livraison_ville" type="xs:string" minOccurs="0" />
            <xs:element name="livraison_pays" type="xs:string" minOccurs="0" />
            <xs:element name="url_retour" type="xs:string" minOccurs="0" />
            <xs:element name="url_retour_ok" type="xs:string" minOccurs="0" />
            <xs:element name="url_retour_err" type="xs:string" minOccurs="0" />
            <xs:element name="acompte" type="xs:decimal" minOccurs="0" />
            <xs:element name="numero_commande_ticketnet" type="xs:string" minOccurs="0" />
            <xs:element name="frais_gestion_payeur" type="xs:string" minOccurs="0" />
            <xs:element name="frais_port_payeur" type="xs:string" minOccurs="0" />
            <xs:element name="remise_frais_port" type="xs:string" minOccurs="0" />
            <xs:element name="numero_commande_distributeur" type="xs:string" minOccurs="0" />
        </xs:sequence>
    </xs:complexType>
</xs:element>
';

        $this->dataset->any = '
<' . $this->tablename . ' diffgr:id="' . $this->tablename . '1" msdata:rowOrder="0">
    <nb_cheques_vacances>' . $this->nb_cheques_vacances . '</nb_cheques_vacances>
    <montant_total_cheques_vacances>' . $this->montant_total_cheques_vacances . '</montant_total_cheques_vacances>
    <mode_paiement>' . $this->mode_paiement . '</mode_paiement>
    <prix_livraison>' . $this->prix_livraison . '</prix_livraison>
    <code_livraison>' . $this->code_livraison . '</code_livraison>
    <commentaire>' . $this->commentaire . '</commentaire>
    <livraison_adresse_societe>' . $this->livraison_adresse_societe . '</livraison_adresse_societe>
    <livraison_adresse_nom>' . $this->livraison_adresse_nom . '</livraison_adresse_nom>
    <livraison_adresse_1>' . $this->livraison_adresse_1 . '</livraison_adresse_1>
    <livraison_adresse_2>' . $this->livraison_adresse_2 . '</livraison_adresse_2>
    <livraison_codepostal>' . $this->livraison_codepostal . '</livraison_codepostal>
    <livraison_ville>' . $this->livraison_ville . '</livraison_ville>
    <livraison_pays>' . $this->livraison_pays . '</livraison_pays>
    <url_retour>' . $this->url_retour . '</url_retour>
    <url_retour_ok>' . $this->url_retour_ok . '</url_retour_ok>
    <url_retour_err>' . $this->url_retour_err . '</url_retour_err>
    <acompte>' . $this->acompte . '</acompte>
    <numero_commande_ticketnet>' . $this->numero_commande_ticketnet . '</numero_commande_ticketnet>
    <frais_gestion_payeur>'.$this->frais_gestion_payeur.'</frais_gestion_payeur>
    <frais_port_payeur>'.$this->frais_port_payeur.'</frais_port_payeur>
    <remise_frais_port>'.$this->remise_frais_port.'</remise_frais_port>
    <numero_commande_distributeur>'.$this->numero_commande_distributeur.'</numero_commande_distributeur>
</' . $this->tablename . '>
';
    }

    public static function create(...$params)
    {
        return new static(...$params);
    }

    public function schema():string
    {
        return $this->dataset->schema;
    }

    public function body():string
    {
        return $this->dataset->any;
    }

    public function dataset():stdClass
    {
        return $this->dataset;
    }
}
