<?php

namespace SkiLoisirsDiffusion\Tests;

use SkiLoisirsDiffusion\Datasets\DatasetField;
use SkiLoisirsDiffusion\Datasets\DatasetTable;
use SkiLoisirsDiffusion\Tests\Factory\FraisGestionFactory;

class FraisGestionDatasetTest extends BaseTestCase
{
    /** @var SkiLoisirsDiffusion\Datasets\DatasetTable $fraisGestionDatasetTable */
    protected $fraisGestionDatasetTable;

    /** @var array $fraisGestion */
    protected $fraisGestion;

    public function setUp() :void
    {
        parent::setUp();
        $this->fraisGestion = FraisGestionFactory::create();
        $this->fraisGestionDatasetTable = DatasetTable::create('frais_gestion')
            ->addDatasetFields(
                [
                    DatasetField::create('nb_ebillets', 'int32', $this->fraisGestion['nb_ebillets']),
                    DatasetField::create('prix_ebillet', 'decimal', $this->fraisGestion['prix_ebillet']),
                    DatasetField::create('nb_ebc', 'int32', $this->fraisGestion['nb_ebc']),
                    DatasetField::create('prix_ebc', 'decimal', $this->fraisGestion['prix_ebc']),
                    DatasetField::create('nb_ebr', 'int32', $this->fraisGestion['nb_ebr']),
                    DatasetField::create('prix_ebr', 'decimal', $this->fraisGestion['prix_ebr']),
                    DatasetField::create('nb_be', 'int32', $this->fraisGestion['nb_be']),
                    DatasetField::create('prix_be', 'decimal', $this->fraisGestion['prix_be']),
                    DatasetField::create('nb_etickets', 'int32', $this->fraisGestion['nb_etickets']),
                    DatasetField::create('prix_etickets', 'decimal', $this->fraisGestion['prix_etickets']),
                    DatasetField::create('nb_retraits', 'int32', $this->fraisGestion['nb_retraits']),
                    DatasetField::create('prix_retraits', 'decimal', $this->fraisGestion['prix_retraits']),
                    DatasetField::create('remise_ebillets', 'decimal', $this->fraisGestion['remise_ebillets']),
                    DatasetField::create('remise_ebc', 'decimal', $this->fraisGestion['remise_ebc']),
                    DatasetField::create('remise_ebr', 'decimal', $this->fraisGestion['remise_ebr']),
                    DatasetField::create('remise_be', 'decimal', $this->fraisGestion['remise_be']),
                    DatasetField::create('remise_etickets', 'decimal', $this->fraisGestion['remise_etickets']),
                    DatasetField::create('remise_retraits', 'decimal', $this->fraisGestion['remise_retraits']),
                    DatasetField::create('nb_cartes_cadeaux', 'int32', $this->fraisGestion['nb_cartes_cadeaux']),
                    DatasetField::create('prix_carte_cadeau', 'decimal', $this->fraisGestion['prix_carte_cadeau']),
                    DatasetField::create('remise_cartes_cadeaux', 'decimal', $this->fraisGestion['remise_cartes_cadeaux']),
                    DatasetField::create('montant_plafond_commande', 'decimal', $this->fraisGestion['montant_plafond_commande'], 0, false),
                    DatasetField::create('nb_frais_gestion', 'int32', $this->fraisGestion['nb_frais_gestion'], 0, false),
                    DatasetField::create('prix_frais_gestion', 'decimal', $this->fraisGestion['prix_frais_gestion'], 0, false),
                    DatasetField::create('nb_frais_demat', 'int32', $this->fraisGestion['nb_frais_demat'], 0, false),
                    DatasetField::create('prix_frais_demat', 'decimal', $this->fraisGestion['prix_frais_demat'], 0, false),
                    DatasetField::create('nb_frais_papier', 'int32', $this->fraisGestion['nb_frais_papier'], 0, false),
                    DatasetField::create('prix_frais_papier', 'decimal', $this->fraisGestion['prix_frais_papier'], 0, false),
                ]
            );
    }

    /** @test */
    public function frais_gestion_dataset_schema_is_ok()
    {
        $expectedSchema = <<<EOT
<xs:element name="frais_gestion">
<xs:complexType>
<xs:sequence>
<xs:element name="nb_ebillets" type="xs:int32" minOccurs="0"/>
<xs:element name="prix_ebillet" type="xs:decimal" minOccurs="0"/>
<xs:element name="nb_ebc" type="xs:int32" minOccurs="0"/>
<xs:element name="prix_ebc" type="xs:decimal" minOccurs="0"/>
<xs:element name="nb_ebr" type="xs:int32" minOccurs="0"/>
<xs:element name="prix_ebr" type="xs:decimal" minOccurs="0"/>
<xs:element name="nb_be" type="xs:int32" minOccurs="0"/>
<xs:element name="prix_be" type="xs:decimal" minOccurs="0"/>
<xs:element name="nb_etickets" type="xs:int32" minOccurs="0"/>
<xs:element name="prix_etickets" type="xs:decimal" minOccurs="0"/>
<xs:element name="nb_retraits" type="xs:int32" minOccurs="0"/>
<xs:element name="prix_retraits" type="xs:decimal" minOccurs="0"/>
<xs:element name="remise_ebillets" type="xs:decimal" minOccurs="0"/>
<xs:element name="remise_ebc" type="xs:decimal" minOccurs="0"/>
<xs:element name="remise_ebr" type="xs:decimal" minOccurs="0"/>
<xs:element name="remise_be" type="xs:decimal" minOccurs="0"/>
<xs:element name="remise_etickets" type="xs:decimal" minOccurs="0"/>
<xs:element name="remise_retraits" type="xs:decimal" minOccurs="0"/>
<xs:element name="nb_cartes_cadeaux" type="xs:int32" minOccurs="0"/>
<xs:element name="prix_carte_cadeau" type="xs:decimal" minOccurs="0"/>
<xs:element name="remise_cartes_cadeaux" type="xs:decimal" minOccurs="0"/>
<xs:element name="montant_plafond_commande" type="xs:decimal" minOccurs="0"/>
<xs:element name="nb_frais_gestion" type="xs:int32" minOccurs="0"/>
<xs:element name="prix_frais_gestion" type="xs:decimal" minOccurs="0"/>
<xs:element name="nb_frais_demat" type="xs:int32" minOccurs="0"/>
<xs:element name="prix_frais_demat" type="xs:decimal" minOccurs="0"/>
<xs:element name="nb_frais_papier" type="xs:int32" minOccurs="0"/>
<xs:element name="prix_frais_papier" type="xs:decimal" minOccurs="0"/>
</xs:sequence>
</xs:complexType>
</xs:element>
EOT;
        $this->assertEquals($expectedSchema, $this->fraisGestionDatasetTable->renderSchema());
    }

    /** @test */
    public function frais_gestion_dataset_body_is_ok()
    {
        $expectedBody = <<<EOT
<frais_gestion diffgr:id="frais_gestion1" msdata:rowOrder="0">
<nb_ebillets>{$this->fraisGestion['nb_ebillets']}</nb_ebillets>
<prix_ebillet>{$this->fraisGestion['prix_ebillet']}</prix_ebillet>
<nb_ebc>{$this->fraisGestion['nb_ebc']}</nb_ebc>
<prix_ebc>{$this->fraisGestion['prix_ebc']}</prix_ebc>
<nb_ebr>{$this->fraisGestion['nb_ebr']}</nb_ebr>
<prix_ebr>{$this->fraisGestion['prix_ebr']}</prix_ebr>
<nb_be>{$this->fraisGestion['nb_be']}</nb_be>
<prix_be>{$this->fraisGestion['prix_be']}</prix_be>
<nb_etickets>{$this->fraisGestion['nb_etickets']}</nb_etickets>
<prix_etickets>{$this->fraisGestion['prix_etickets']}</prix_etickets>
<nb_retraits>{$this->fraisGestion['nb_retraits']}</nb_retraits>
<prix_retraits>{$this->fraisGestion['prix_retraits']}</prix_retraits>
<remise_ebillets>{$this->fraisGestion['remise_ebillets']}</remise_ebillets>
<remise_ebc>{$this->fraisGestion['remise_ebc']}</remise_ebc>
<remise_ebr>{$this->fraisGestion['remise_ebr']}</remise_ebr>
<remise_be>{$this->fraisGestion['remise_be']}</remise_be>
<remise_etickets>{$this->fraisGestion['remise_etickets']}</remise_etickets>
<remise_retraits>{$this->fraisGestion['remise_retraits']}</remise_retraits>
<nb_cartes_cadeaux>{$this->fraisGestion['nb_cartes_cadeaux']}</nb_cartes_cadeaux>
<prix_carte_cadeau>{$this->fraisGestion['prix_carte_cadeau']}</prix_carte_cadeau>
<remise_cartes_cadeaux>{$this->fraisGestion['remise_cartes_cadeaux']}</remise_cartes_cadeaux>
<montant_plafond_commande>{$this->fraisGestion['montant_plafond_commande']}</montant_plafond_commande>
<nb_frais_gestion>{$this->fraisGestion['nb_frais_gestion']}</nb_frais_gestion>
<prix_frais_gestion>{$this->fraisGestion['prix_frais_gestion']}</prix_frais_gestion>
<nb_frais_demat>{$this->fraisGestion['nb_frais_demat']}</nb_frais_demat>
<prix_frais_demat>{$this->fraisGestion['prix_frais_demat']}</prix_frais_demat>
<nb_frais_papier>{$this->fraisGestion['nb_frais_papier']}</nb_frais_papier>
<prix_frais_papier>{$this->fraisGestion['prix_frais_papier']}</prix_frais_papier>
</frais_gestion>
EOT;
        $this->assertEquals($expectedBody, $this->fraisGestionDatasetTable->renderBody());
    }
}
