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

    protected string $signature;

    public function setUp() :void
    {
        parent::setUp();
        $this->user = UserDatatype::create(UserFactory::create());
        $this->order = OrderDatatype::create(OrderFactory::create());

        $createSignatureParameters = [
            'code_livraison' => $this->order->code_livraison,
            'id_partenaire' => $this->user->id_partenaire,
            'mode_paiement' => $this->order->mode_paiement,
            'utilisateurs_adresse1' => $this->user->utilisateurs_adresse1,
            'utilisateurs_adresse_nom' => $this->user->utilisateurs_adresse_nom,
            'utilisateurs_codepostal' => $this->user->utilisateurs_codepostal,
            'utilisateurs_email' => $this->user->utilisateurs_email,
            'utilisateurs_nom' => $this->user->utilisateurs_nom,
            'utilisateurs_prenom' => $this->user->utilisateurs_prenom,
            'utilisateurs_ville' => $this->user->utilisateurs_ville,
            'clef_secrete' => sldconfig('clef_secrete'),
        ];
        $this->signature = generateSignature($createSignatureParameters);

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
<signature>{$this->signature}</signature>
</signature>
EOT;
        $this->assertEquals($expectedBody, $this->signatureDatasetTable->renderBody());
    }
}
