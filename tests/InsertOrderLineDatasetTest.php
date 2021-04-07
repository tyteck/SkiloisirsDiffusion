<?php

namespace SkiLoisirsDiffusion\Tests;

use SkiLoisirsDiffusion\Datasets\InsertOrderLineDataset;
use SkiLoisirsDiffusion\DatasetTables\ArticleDatasetTable;
use SkiLoisirsDiffusion\DatasetTables\FraisGestionDatasetTable;
use SkiLoisirsDiffusion\Datatypes\ArticleDatatype;
use SkiLoisirsDiffusion\Datatypes\FraisGestionDatatype;
use SkiLoisirsDiffusion\Tests\Factory\ArticleFactory;
use SkiLoisirsDiffusion\Tests\Factory\FraisGestionFactory;

class InsertOrderLineDatasetTest extends BaseTestCase
{
    protected $user;
    protected $order;
    protected $orderNumber;
    protected $expectedSignature;
    protected $datasetTables = [];
    protected $fraisGestion;

    /** @var \Skiloisirs\Datasets\InsertOrderLineDataset $insertOrderLine */
    protected $insertOrderLine;

    public function setUp() :void
    {
        parent::setUp();

        /** creating order */
        $this->orderNumber = (string)rand(24300, 24400);
        $this->insertOrderLine = InsertOrderLineDataset::create($this->orderNumber);
    }

    /** @test */
    public function with_one_article_only_is_ok()
    {
        $this->datasetTables[] = ArticleDatasetTable::prepare()->with(ArticleDatatype::create(ArticleFactory::create()));
        $this->datasetTables[] = FraisGestionDatasetTable::prepare()->with(FraisGestionDatatype::create(FraisGestionFactory::create()));
        $this->insertOrderLine->addDatasetTables($this->datasetTables)->render();
    }

    protected function expectedBody(): string
    {
        return <<<EOT
<diffgr:diffgram xmlns:diffgr="urn:schemas-microsoft-com:xml-diffgram-v1" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata">
<NewDataSet xmlns="">
<utilisateur diffgr:id="utilisateur1" msdata:rowOrder="1">
<id_partenaire>{$this->user->id_partenaire}</id_partenaire>
<utilisateurs_societe>{$this->user->utilisateurs_societe}</utilisateurs_societe>
<utilisateurs_civilite>{$this->user->utilisateurs_civilite}</utilisateurs_civilite>
<utilisateurs_nom>{$this->user->utilisateurs_nom}</utilisateurs_nom>
<utilisateurs_prenom>{$this->user->utilisateurs_prenom}</utilisateurs_prenom>
<utilisateurs_telephone>{$this->user->utilisateurs_telephone}</utilisateurs_telephone>
<utilisateurs_portable>{$this->user->utilisateurs_portable}</utilisateurs_portable>
<utilisateurs_fax>{$this->user->utilisateurs_fax}</utilisateurs_fax>
<utilisateurs_email>{$this->user->utilisateurs_email}</utilisateurs_email>
<utilisateurs_adresse_nom>{$this->user->utilisateurs_adresse_nom}</utilisateurs_adresse_nom>
<utilisateurs_adresse1>{$this->user->utilisateurs_adresse1}</utilisateurs_adresse1>
<utilisateurs_adresse2>{$this->user->utilisateurs_adresse2}</utilisateurs_adresse2>
<utilisateurs_codepostal>{$this->user->utilisateurs_codepostal}</utilisateurs_codepostal>
<utilisateurs_ville>{$this->user->utilisateurs_ville}</utilisateurs_ville>
<utilisateurs_pays>{$this->user->utilisateurs_pays}</utilisateurs_pays>
<utilisateurs_date_naissance>{$this->user->utilisateurs_date_naissance}</utilisateurs_date_naissance>
</utilisateur>
<commande diffgr:id="commande1" msdata:rowOrder="2">
<nb_cheques_vacances>{$this->order->nb_cheques_vacances}</nb_cheques_vacances>
<montant_total_cheques_vacances>{$this->order->montant_total_cheques_vacances}</montant_total_cheques_vacances>
<mode_paiement>{$this->order->mode_paiement}</mode_paiement>
<prix_livraison>{$this->order->prix_livraison}</prix_livraison>
<code_livraison>{$this->order->code_livraison}</code_livraison>
<commentaire>{$this->order->commentaire}</commentaire>
<livraison_adresse_societe>{$this->order->livraison_adresse_societe}</livraison_adresse_societe>
<livraison_adresse_nom>{$this->order->livraison_adresse_nom}</livraison_adresse_nom>
<livraison_adresse1>{$this->order->livraison_adresse1}</livraison_adresse1>
<livraison_adresse2>{$this->order->livraison_adresse2}</livraison_adresse2>
<livraison_codepostal>{$this->order->livraison_codepostal}</livraison_codepostal>
<livraison_ville>{$this->order->livraison_ville}</livraison_ville>
<livraison_pays>{$this->order->livraison_pays}</livraison_pays>
<url_retour>{$this->order->url_retour}</url_retour>
<url_retour_ok>{$this->order->url_retour_ok}</url_retour_ok>
<url_retour_err>{$this->order->url_retour_err}</url_retour_err>
<acompte>{$this->order->acompte}</acompte>
<numero_commande_ticketnet>{$this->order->numero_commande_ticketnet}</numero_commande_ticketnet>
<frais_gestion_payeur>{$this->order->frais_gestion_payeur}</frais_gestion_payeur>
<frais_port_payeur>{$this->order->frais_port_payeur}</frais_port_payeur>
<remise_frais_port>{$this->order->remise_frais_port}</remise_frais_port>
<numero_commande_distributeur>{$this->order->numero_commande_distributeur}</numero_commande_distributeur>
</commande>
<signature diffgr:id="signature1" msdata:rowOrder="3">
<signature>{$this->expectedSignature}</signature>
</signature>
</NewDataSet>
</diffgr:diffgram>
EOT;
    }

    protected function expectedSchema(): string
    {
        return <<<EOT
<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns="" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata" id="NewDataSet">
<xs:element name="NewDataSet" msdata:IsDataSet="true" msdata:UseCurrentLocale="true">
<xs:complexType>
<xs:choice minOccurs="0" maxOccurs="unbounded">
<xs:element name="ce">
<xs:complexType>
<xs:sequence>
<xs:element name="ce_id" type="xs:string" minOccurs="0"/>
<xs:element name="ce_societe" type="xs:string" minOccurs="0"/>
<xs:element name="ce_civilite" type="xs:string" minOccurs="0"/>
<xs:element name="ce_nom" type="xs:string" minOccurs="0"/>
<xs:element name="ce_prenom" type="xs:string" minOccurs="0"/>
<xs:element name="ce_telephone" type="xs:string" minOccurs="0"/>
<xs:element name="ce_portable" type="xs:string" minOccurs="0"/>
<xs:element name="ce_fax" type="xs:string" minOccurs="0"/>
<xs:element name="ce_email" type="xs:string" minOccurs="0"/>
<xs:element name="ce_adresse_nom" type="xs:string" minOccurs="0"/>
<xs:element name="ce_adresse1" type="xs:string" minOccurs="0"/>
<xs:element name="ce_adresse2" type="xs:string" minOccurs="0"/>
<xs:element name="ce_codepostal" type="xs:string" minOccurs="0"/>
<xs:element name="ce_ville" type="xs:string" minOccurs="0"/>
<xs:element name="ce_pays" type="xs:string" minOccurs="0"/>
</xs:sequence>
</xs:complexType>
</xs:element>
<xs:element name="utilisateur">
<xs:complexType>
<xs:sequence>
<xs:element name="id_partenaire" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_societe" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_civilite" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_nom" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_prenom" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_telephone" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_portable" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_fax" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_email" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_adresse_nom" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_adresse1" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_adresse2" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_codepostal" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_ville" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_pays" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_date_naissance" type="xs:dateTime" minOccurs="0"/>
</xs:sequence>
</xs:complexType>
</xs:element>
<xs:element name="commande">
<xs:complexType>
<xs:sequence>
<xs:element name="nb_cheques_vacances" type="xs:string" minOccurs="0"/>
<xs:element name="montant_total_cheques_vacances" type="xs:string" minOccurs="0"/>
<xs:element name="mode_paiement" type="xs:string" minOccurs="0"/>
<xs:element name="prix_livraison" type="xs:decimal" minOccurs="0"/>
<xs:element name="code_livraison" type="xs:string" minOccurs="0"/>
<xs:element name="commentaire" type="xs:string" minOccurs="0"/>
<xs:element name="livraison_adresse_societe" type="xs:string" minOccurs="0"/>
<xs:element name="livraison_adresse_nom" type="xs:string" minOccurs="0"/>
<xs:element name="livraison_adresse1" type="xs:string" minOccurs="0"/>
<xs:element name="livraison_adresse2" type="xs:string" minOccurs="0"/>
<xs:element name="livraison_codepostal" type="xs:string" minOccurs="0"/>
<xs:element name="livraison_ville" type="xs:string" minOccurs="0"/>
<xs:element name="livraison_pays" type="xs:string" minOccurs="0"/>
<xs:element name="url_retour" type="xs:string" minOccurs="0"/>
<xs:element name="url_retour_ok" type="xs:string" minOccurs="0"/>
<xs:element name="url_retour_err" type="xs:string" minOccurs="0"/>
<xs:element name="acompte" type="xs:decimal" minOccurs="0"/>
<xs:element name="numero_commande_ticketnet" type="xs:string" minOccurs="0"/>
<xs:element name="frais_gestion_payeur" type="xs:string" minOccurs="0"/>
<xs:element name="frais_port_payeur" type="xs:string" minOccurs="0"/>
<xs:element name="remise_frais_port" type="xs:decimal" minOccurs="0"/>
<xs:element name="numero_commande_distributeur" type="xs:string" minOccurs="0"/>
</xs:sequence>
</xs:complexType>
</xs:element>
<xs:element name="signature">
<xs:complexType>
<xs:sequence>
<xs:element name="signature" type="xs:string" minOccurs="0"/>
</xs:sequence>
</xs:complexType>
</xs:element>
</xs:choice>
</xs:complexType>
</xs:element>
</xs:schema>
EOT;
    }
}
