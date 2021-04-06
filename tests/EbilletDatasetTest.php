<?php

namespace SkiLoisirsDiffusion\Tests;

use SkiLoisirsDiffusion\DatasetTables\EbilletDatasetTable;
use SkiLoisirsDiffusion\Datatypes\EbilletDatatype;
use SkiLoisirsDiffusion\Tests\Factory\EbilletFactory;

class EbilletDatasetTest extends BaseTestCase
{
    public function setUp() :void
    {
        parent::setUp();
        $this->ebillet = EbilletDatatype::create(EbilletFactory::create());

        $this->ebilletDatasetTable = EbilletDatasetTable::prepare()->with($this->ebillet);
    }

    /** @test */
    public function ebillet_dataset_schema_is_ok()
    {
        $expectedSchema = <<<EOT
<xs:element name="ebillet">
<xs:complexType>
<xs:sequence>
<xs:element name="code_article" type="xs:string" minOccurs="0"/>
<xs:element name="nom" type="xs:string" minOccurs="0"/>
<xs:element name="prenom" type="xs:string" minOccurs="0"/>
<xs:element name="date" type="xs:string" minOccurs="0"/>
<xs:element name="date_naissance" type="xs:string" minOccurs="0"/>
<xs:element name="keycard" type="xs:string" minOccurs="0"/>
<xs:element name="skier_index" type="xs:int32" minOccurs="0"/>
</xs:sequence>
</xs:complexType>
</xs:element>
EOT;
        $this->assertEquals($expectedSchema, $this->ebilletDatasetTable->renderSchema());
    }

    /** @test */
    public function ebillet_dataset_body_is_ok()
    {
        $expectedBody = <<<EOT
<ebillet diffgr:id="ebillet1" msdata:rowOrder="0">
<code_article>{$this->ebillet->code_article}</code_article>
<nom>{$this->ebillet->nom}</nom>
<prenom>{$this->ebillet->prenom}</prenom>
<date>{$this->ebillet->date}</date>
<date_naissance>{$this->ebillet->date_naissance}</date_naissance>
<keycard>{$this->ebillet->keycard}</keycard>
<skier_index>{$this->ebillet->skier_index}</skier_index>
</ebillet>
EOT;
        $this->assertEquals($expectedBody, $this->ebilletDatasetTable->renderBody());
    }
}
