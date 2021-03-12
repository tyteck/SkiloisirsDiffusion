<?php

namespace SkiLoisirsDiffusion\Tests;

class SignatureDatasetTest extends BaseTestCase
{
    /** @var \SkiloisirsDiffusion\Datasets\SignatureDataset $signatureDataset */
    protected $signatureDataset;

    public function setUp() :void
    {
        parent::setUp();
        $this->signatureDataset = $this->createSignatureDataset($this->expectedSignatureDatasetBody()) ;
    }

    /** @test */
    public function signature_dataset_schema_is_ok()
    {
        $schema = $this->signatureDataset->schema();

        $this->assertStringContainsString(
            '<xs:element name="signature" type="xs:string" minOccurs="0"/>',
            $schema,
            'The key signature with type string is not set properly.'
        );
    }

    /** @test */
    public function signature_dataset_body_is_ok()
    {
        $expectedSignature = sha1(
            array_reduce(
                $this->expectedSignatureDatasetBody(),
                function ($carry, $requiredParameter) {
                    if (strlen($carry)) {
                        $carry .= '+';
                    }
                    return $carry .= $requiredParameter;
                }
            )
        );

        $this->assertStringContainsString(
            "<signature>{$expectedSignature}</signature>",
            $this->signatureDataset->body(),
            "The value {$expectedSignature} for signature is not set properly."
        );
    }
}
