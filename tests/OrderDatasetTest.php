<?php

namespace SkiLoisirsDiffusion\Tests;

use SkiLoisirsDiffusion\DatasetTables\OrderDatasetTable;
use SkiLoisirsDiffusion\Datatypes\OrderDatatype;
use SkiLoisirsDiffusion\Tests\Factory\OrderFactory;

class OrderDatasetTest extends BaseTestCase
{
    /** @var \SkiLoisirsDiffusion\Datatypes\OrderDatatype $order */
    protected $order;

    /** @var \SkiLoisirsDiffusion\DatasetTables\DatasetTable $orderDatasetTable */
    protected $orderDatasetTable;

    public function setUp(): void
    {
        parent::setUp();

        /** factory create fake user array I throw to userDataType*/
        $this->order = OrderDatatype::create(OrderFactory::create());

        $this->orderDatasetTable = OrderDatasetTable::prepare()->with($this->order);
    }

    /** @test */
    public function order_dataset_schema_is_ok()
    {
        $expectedSchema = <<<EOT
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
EOT;
        $this->assertEquals($expectedSchema, $this->orderDatasetTable->renderSchema());
    }

    /** @test */
    public function order_dataset_body_is_ok()
    {
        $expectedBody = <<<EOT
<commande diffgr:id="commande1" msdata:rowOrder="0">
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
EOT;
        $this->assertEquals($expectedBody, $this->orderDatasetTable->renderBody());
    }
}
