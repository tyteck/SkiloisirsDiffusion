<?php

namespace SkiLoisirsDiffusion\Tests;

use SkiLoisirsDiffusion\Datasets\CEDataset;

class CEDatasetTest extends BaseTestCase
{
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
        $this->assertEquals($expectedSchema, CEDataset::create()->schema());
    }

    /** @test */
    public function ce_dataset_body_is_ok()
    {
        $ceDatasetBody = CEDataset::create()->body();

        $expectedBody = '<NOM_TABLE diffgr:id="ce" msdata:rowOrder="0">' . PHP_EOL
            . '<ce_id>' . sldconfig('sld_partenaire_id') . '</ce_id>' . PHP_EOL
            . '<ce_societe>' . sldconfig('ce_societe') . '</ce_societe>' . PHP_EOL
            . '<ce_nom>' . sldconfig('ce_nom') . '</ce_nom>' . PHP_EOL
            . '<ce_prenom>' . sldconfig('ce_prenom') . '</ce_prenom>' . PHP_EOL
            . '<ce_email>' . sldconfig('ce_email') . '</ce_email>' . PHP_EOL
            . '<ce_codepostal>' . sldconfig('ce_codepostal') . '</ce_codepostal>' . PHP_EOL
            . '<ce_ville>' . sldconfig('ce_ville') . '</ce_ville>' . PHP_EOL
            . '</NOM_TABLE>';

        $this->assertEquals($expectedBody, CEDataset::create()->body());
    }
}
