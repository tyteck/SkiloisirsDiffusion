<?php

namespace SkiLoisirsDiffusion\Tests;

use SkiLoisirsDiffusion\Datasets\DatasetField;
use SkiLoisirsDiffusion\Datasets\DatasetTable;
use SkiLoisirsDiffusion\Tests\Factory\OrderFactory;

class OrderDatasetTest extends BaseTestCase
{
    /** @var array $order */
    protected array $order;

    /** @var \SkiLoisirsDiffusion\Datasets\DatasetTable $orderDatasetTable */
    protected DatasetTable $orderDatasetTable;

    public function setUp() :void
    {
        parent::setUp();
        $this->order = OrderFactory::create();
        $this->orderDatasetTable = DatasetTable::create('commande')
            ->addDatasetFields(
                [
                    DatasetField::create('nb_cheques_vacances', 'string', $this->order['nb_cheques_vacances']),
                    DatasetField::create('montant_total_cheques_vacances', 'string', $this->order['montant_total_cheques_vacances']),
                    DatasetField::create('mode_paiement', 'string', $this->order['mode_paiement']),
                    DatasetField::create('prix_livraison', 'decimal', $this->order['prix_livraison']),
                    DatasetField::create('code_livraison', 'string', $this->order['code_livraison']),
                    DatasetField::create('commentaire', 'string', $this->order['commentaire'], 0, false),
                    DatasetField::create('livraison_adresse_societe', 'string', $this->order['livraison_adresse_societe']),
                    DatasetField::create('livraison_adresse_nom', 'string', $this->order['livraison_adresse_nom']),
                    DatasetField::create('livraison_adresse_1', 'string', $this->order['livraison_adresse_1']),
                    DatasetField::create('livraison_adresse_2', 'string', $this->order['livraison_adresse_2']),
                    DatasetField::create('livraison_codepostal', 'string', $this->order['livraison_codepostal']),
                    DatasetField::create('livraison_ville', 'string', $this->order['livraison_ville']),
                    DatasetField::create('livraison_pays', 'string', $this->order['livraison_pays'], 0, false),
                    DatasetField::create('url_retour', 'string', $this->order['url_retour'], 0, false),
                    DatasetField::create('url_retour_ok', 'string', $this->order['url_retour_ok'], 0, false),
                    DatasetField::create('url_retour_err', 'string', $this->order['url_retour_err'], 0, false),
                    DatasetField::create('acompte', 'decimal', $this->order['acompte'], 0, false),
                    DatasetField::create('numero_commande_ticketnet', 'string', $this->order['numero_commande_ticketnet'], 0, false),
                    DatasetField::create('frais_gestion_payeur', 'string', $this->order['frais_gestion_payeur'], 0, false),
                    DatasetField::create('frais_port_payeur', 'string', $this->order['frais_port_payeur'], 0, false),
                    DatasetField::create('remise_frais_port', 'decimal', $this->order['remise_frais_port'], 0, false),
                    DatasetField::create('numero_commande_distributeur', 'string', $this->order['numero_commande_distributeur'], 0, false),
                ]
            );
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
<xs:element name="livraison_adresse_1" type="xs:string" minOccurs="0"/>
<xs:element name="livraison_adresse_2" type="xs:string" minOccurs="0"/>
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
<NOM_TABLE diffgr:id="commande" msdata:rowOrder="0">
<nb_cheques_vacances>{$this->order['nb_cheques_vacances']}</nb_cheques_vacances>
<montant_total_cheques_vacances>{$this->order['montant_total_cheques_vacances']}</montant_total_cheques_vacances>
<mode_paiement>{$this->order['mode_paiement']}</mode_paiement>
<prix_livraison>{$this->order['prix_livraison']}</prix_livraison>
<code_livraison>{$this->order['code_livraison']}</code_livraison>
<commentaire>{$this->order['commentaire']}</commentaire>
<livraison_adresse_societe>{$this->order['livraison_adresse_societe']}</livraison_adresse_societe>
<livraison_adresse_nom>{$this->order['livraison_adresse_nom']}</livraison_adresse_nom>
<livraison_adresse_1>{$this->order['livraison_adresse_1']}</livraison_adresse_1>
<livraison_adresse_2>{$this->order['livraison_adresse_2']}</livraison_adresse_2>
<livraison_codepostal>{$this->order['livraison_codepostal']}</livraison_codepostal>
<livraison_ville>{$this->order['livraison_ville']}</livraison_ville>
<livraison_pays>{$this->order['livraison_pays']}</livraison_pays>
<url_retour>{$this->order['url_retour']}</url_retour>
<url_retour_ok>{$this->order['url_retour_ok']}</url_retour_ok>
<url_retour_err>{$this->order['url_retour_err']}</url_retour_err>
<acompte>{$this->order['acompte']}</acompte>
<numero_commande_ticketnet>{$this->order['numero_commande_ticketnet']}</numero_commande_ticketnet>
<frais_gestion_payeur>{$this->order['frais_gestion_payeur']}</frais_gestion_payeur>
<frais_port_payeur>{$this->order['frais_port_payeur']}</frais_port_payeur>
<remise_frais_port>{$this->order['remise_frais_port']}</remise_frais_port>
<numero_commande_distributeur>{$this->order['numero_commande_distributeur']}</numero_commande_distributeur>
</NOM_TABLE>
EOT;
        $this->assertEquals($expectedBody, $this->orderDatasetTable->renderBody());
    }
}
