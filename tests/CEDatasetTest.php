<?php

namespace SkiLoisirsDiffusion\Tests;

use SkiLoisirsDiffusion\DatasetTables\CeDatasetTable;

class CEDatasetTest extends BaseTestCase
{
    /** @var \SkiLoisirsDiffusion\DatasetTables\DatasetTable $ceDatasetTable */
    protected $ceDatasetTable;

    public function setUp(): void
    {
        parent::setUp();
        $this->ceDatasetTable = CeDatasetTable::prepare()->withConfig();
    }

    /** @test */
    public function ce_dataset_schema_is_ok()
    {
        $expectedSchema = <<<EOT
<xs:element name="ce">
<xs:complexType>
<xs:sequence>
<xs:element name="ce_id" type="xs:string" minOccurs="0"/>
<xs:element name="ce_societe" type="xs:string" minOccurs="0"/>
<xs:element name="ce_civilite" type="xs:string" minOccurs="0" nillable="true"/>
<xs:element name="ce_nom" type="xs:string" minOccurs="0"/>
<xs:element name="ce_prenom" type="xs:string" minOccurs="0"/>
<xs:element name="ce_telephone" type="xs:string" minOccurs="0" nillable="true"/>
<xs:element name="ce_portable" type="xs:string" minOccurs="0" nillable="true"/>
<xs:element name="ce_fax" type="xs:string" minOccurs="0" nillable="true"/>
<xs:element name="ce_email" type="xs:string" minOccurs="0"/>
<xs:element name="ce_adresse_nom" type="xs:string" minOccurs="0" nillable="true"/>
<xs:element name="ce_adresse1" type="xs:string" minOccurs="0" nillable="true"/>
<xs:element name="ce_adresse2" type="xs:string" minOccurs="0" nillable="true"/>
<xs:element name="ce_codepostal" type="xs:string" minOccurs="0"/>
<xs:element name="ce_ville" type="xs:string" minOccurs="0"/>
<xs:element name="ce_pays" type="xs:string" minOccurs="0" nillable="true"/>
</xs:sequence>
</xs:complexType>
</xs:element>
EOT;
        $this->assertEquals($expectedSchema, $this->ceDatasetTable->renderSchema());
    }

    /** @test */
    public function ce_dataset_body_is_ok()
    {
        $ce_id = sldconfig('sld_partenaire_id');
        $ce_societe = sldconfig('ce_societe');
        $ce_nom = sldconfig('ce_nom');
        $ce_prenom = sldconfig('ce_prenom');
        $ce_email = sldconfig('ce_email');
        $ce_codepostal = sldconfig('ce_codepostal');
        $ce_ville = sldconfig('ce_ville');
        $expectedBody = <<<EOT
<ce diffgr:id="ce1" msdata:rowOrder="0">
<ce_id>{$ce_id}</ce_id>
<ce_societe>{$ce_societe}</ce_societe>
<ce_civilite></ce_civilite>
<ce_nom>{$ce_nom}</ce_nom>
<ce_prenom>{$ce_prenom}</ce_prenom>
<ce_telephone></ce_telephone>
<ce_portable></ce_portable>
<ce_fax></ce_fax>
<ce_email>{$ce_email}</ce_email>
<ce_adresse_nom></ce_adresse_nom>
<ce_adresse1></ce_adresse1>
<ce_adresse2></ce_adresse2>
<ce_codepostal>{$ce_codepostal}</ce_codepostal>
<ce_ville>{$ce_ville}</ce_ville>
<ce_pays></ce_pays>
</ce>
EOT;

        $this->assertEquals($expectedBody, $this->ceDatasetTable->renderBody());
    }
}
