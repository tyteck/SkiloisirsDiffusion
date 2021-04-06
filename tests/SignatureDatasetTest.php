<?php

namespace SkiLoisirsDiffusion\Tests;

use SkiLoisirsDiffusion\DatasetTables\DatasetTable;
use SkiLoisirsDiffusion\DatasetTables\SignatureDatasetTable;
use SkiLoisirsDiffusion\Datatypes\OrderDatatype;
use SkiLoisirsDiffusion\Datatypes\UserDatatype;
use SkiLoisirsDiffusion\Tests\Factory\OrderFactory;
use SkiLoisirsDiffusion\Tests\Factory\UserFactory;

class SignatureDatasetTest extends BaseTestCase
{
    /** @var \SkiLoisirsDiffusion\DatasetTables\DatasetTable $signatureDatasetTable */
    protected DatasetTable $signatureDatasetTable;

    protected string $expectedSignature;

    public function setUp() :void
    {
        parent::setUp();
        $this->user = UserDatatype::create(UserFactory::create());
        $this->order = OrderDatatype::create(OrderFactory::create());

        $this->expectedSignature = $this->makeSignatureFrom($this->user, $this->order, sldconfig('clef_secrete'));

        $this->signatureDatasetTable = SignatureDatasetTable::prepare()->with($this->order, $this->user, sldconfig('clef_secrete'));
    }

    /** @test */
    public function signature_dataset_schema_is_ok()
    {
        $expectedSchema = <<<EOT
<xs:element name="signature">
<xs:complexType>
<xs:sequence>
<xs:element name="signature" type="xs:string" minOccurs="0"/>
</xs:sequence>
</xs:complexType>
</xs:element>
EOT;

        $this->assertEquals($expectedSchema, $this->signatureDatasetTable->renderSchema());
    }

    /** @test */
    public function signature_dataset_body_is_ok()
    {
        $expectedBody = <<<EOT
<signature diffgr:id="signature1" msdata:rowOrder="0">
<signature>{$this->expectedSignature}</signature>
</signature>
EOT;
        $this->assertEquals($expectedBody, $this->signatureDatasetTable->renderBody());
    }
}
