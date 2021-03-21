<?php

namespace SkiLoisirsDiffusion\Tests;

use SkiLoisirsDiffusion\Datasets\CEDataset;
use SkiLoisirsDiffusion\Datasets\DatasetField;
use SkiLoisirsDiffusion\Datasets\DatasetTable;

class CEDatasetTest extends BaseTestCase
{
    /** @var \SkiLoisirsDiffusion\Datasets\DatasetTable $ceDatasetTable */
    protected $ceDatasetTable;

    public function setUp(): void
    {
        parent::setUp();
        $this->ceDatasetTable = DatasetTable::create('ce')
            ->addDatasetFields(
                [
                    DatasetField::create('ce_id', 'string', sldconfig('sld_partenaire_id')),
                    DatasetField::create('ce_societe', 'string', sldconfig('ce_societe')),
                    DatasetField::create('ce_nom', 'string', sldconfig('ce_nom')),
                    DatasetField::create('ce_prenom', 'string', sldconfig('ce_prenom')),
                    DatasetField::create('ce_email', 'string', sldconfig('ce_email')),
                    DatasetField::create('ce_codepostal', 'string', sldconfig('ce_codepostal')),
                    DatasetField::create('ce_ville', 'string', sldconfig('ce_ville')),
                ]
            );
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
<xs:element name="ce_nom" type="xs:string" minOccurs="0"/>
<xs:element name="ce_prenom" type="xs:string" minOccurs="0"/>
<xs:element name="ce_email" type="xs:string" minOccurs="0"/>
<xs:element name="ce_codepostal" type="xs:string" minOccurs="0"/>
<xs:element name="ce_ville" type="xs:string" minOccurs="0"/>
</xs:sequence>
</xs:complexType>
</xs:element>
EOT;
        $this->assertEquals($expectedSchema, $this->ceDatasetTable->renderSchema());
    }

    /** @test */
    public function ce_dataset_body_is_ok()
    {
        $expectedBody = '<NOM_TABLE diffgr:id="ce" msdata:rowOrder="0">' . PHP_EOL
            . '<ce_id>' . sldconfig('sld_partenaire_id') . '</ce_id>' . PHP_EOL
            . '<ce_societe>' . sldconfig('ce_societe') . '</ce_societe>' . PHP_EOL
            . '<ce_nom>' . sldconfig('ce_nom') . '</ce_nom>' . PHP_EOL
            . '<ce_prenom>' . sldconfig('ce_prenom') . '</ce_prenom>' . PHP_EOL
            . '<ce_email>' . sldconfig('ce_email') . '</ce_email>' . PHP_EOL
            . '<ce_codepostal>' . sldconfig('ce_codepostal') . '</ce_codepostal>' . PHP_EOL
            . '<ce_ville>' . sldconfig('ce_ville') . '</ce_ville>' . PHP_EOL
            . '</NOM_TABLE>';

        $this->assertEquals($expectedBody, $this->ceDatasetTable->renderBody());
    }
}
