<?php

namespace SkiLoisirsDiffusion\Tests;

use SkiLoisirsDiffusion\Datasets\DatasetField;
use SkiLoisirsDiffusion\Datasets\DatasetTable;
use SkiLoisirsDiffusion\Tests\Factory\OrderFactory;
use SkiLoisirsDiffusion\Tests\Factory\UserFactory;

class SignatureDatasetTest extends BaseTestCase
{
    /** @var \SkiloisirsDiffusion\Datasets\DatasetTable $signatureDatasetTable */
    protected DatasetTable $signatureDatasetTable;

    protected string $signature;

    public function setUp() :void
    {
        parent::setUp();
        $order = OrderFactory::create();
        $user = UserFactory::create();

        $createSignatureParameters = [
            'code_livraison' => $order['code_livraison'],
            'id_partenaire' => $user['id_partenaire'],
            'mode_paiement' => $order['mode_paiement'],
            'utilisateurs_adresse1' => $user['utilisateurs_adresse1'],
            'utilisateurs_adresse_nom' => $user['utilisateurs_adresse_nom'],
            'utilisateurs_codepostal' => $user['utilisateurs_codepostal'],
            'utilisateurs_email' => $user['utilisateurs_email'],
            'utilisateurs_nom' => $user['utilisateurs_nom'],
            'utilisateurs_prenom' => $user['utilisateurs_prenom'],
            'utilisateurs_ville' => $user['utilisateurs_ville'],
            'clef_secrete' => sldconfig('clef_secrete'),
        ];
        $this->signature = generateSignature($createSignatureParameters);

        $this->signatureDatasetTable = DatasetTable::create('signature')
            ->addDatasetFields(
                [
                    DatasetField::create('signature', 'string', $this->signature),
                ]
            );
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
<NOM_TABLE diffgr:id="signature" msdata:rowOrder="0">
<signature>{$this->signature}</signature>
</NOM_TABLE>
EOT;
        $this->assertEquals($expectedBody, $this->signatureDatasetTable->renderBody());
    }
}
