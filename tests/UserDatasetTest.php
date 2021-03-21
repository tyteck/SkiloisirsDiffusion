<?php

namespace SkiLoisirsDiffusion\Tests;

use SkiLoisirsDiffusion\Datasets\DatasetField;
use SkiLoisirsDiffusion\Datasets\DatasetTable;
use SkiLoisirsDiffusion\Tests\Factory\UserFactory;

class UserDatasetTest extends BaseTestCase
{
    /** @var array $user */
    protected array $user;

    /** @var \SkiLoisirsDiffusion\Datasets\DatasetTable $userDatasetTable */
    protected DatasetTable $userDatasetTable;

    public function setUp() :void
    {
        parent::setUp();
        $this->user = UserFactory::create();
        $this->userDatasetTable = DatasetTable::create('utilisateur')
            ->addDatasetFields(
                [
                    DatasetField::create('id_partenaire', 'string', $this->user['id_partenaire']),
                    DatasetField::create('utilisateurs_nom', 'string', $this->user['utilisateurs_nom']),
                    DatasetField::create('utilisateurs_prenom', 'string', $this->user['utilisateurs_prenom']),
                    DatasetField::create('utilisateurs_telephone', 'string', $this->user['utilisateurs_telephone']),
                    DatasetField::create('utilisateurs_portable', 'string', $this->user['utilisateurs_portable']),
                    DatasetField::create('utilisateurs_email', 'string', $this->user['utilisateurs_email']),
                    DatasetField::create('utilisateurs_adresse_nom', 'string', $this->user['utilisateurs_adresse_nom']),
                    DatasetField::create('utilisateurs_adresse1', 'string', $this->user['utilisateurs_adresse1']),
                    DatasetField::create('utilisateurs_adresse2', 'string', $this->user['utilisateurs_adresse2']),
                    DatasetField::create('utilisateurs_codepostal', 'string', $this->user['utilisateurs_codepostal']),
                    DatasetField::create('utilisateurs_ville', 'string', $this->user['utilisateurs_ville']),
                    DatasetField::create('utilisateurs_pays', 'string', $this->user['utilisateurs_pays']),
                    DatasetField::create('date_naissance', 'dateTime', $this->user['date_naissance']),
                ]
            );
    }

    /** @test */
    public function user_dataset_schema_is_ok()
    {
        $expectedSchema = <<<EOT
<xs:element name="utilisateur">
<xs:complexType>
<xs:sequence>
<xs:element name="id_partenaire" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_nom" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_prenom" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_telephone" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_portable" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_email" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_adresse_nom" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_adresse1" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_adresse2" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_codepostal" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_ville" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_pays" type="xs:string" minOccurs="0"/>
<xs:element name="date_naissance" type="xs:dateTime" minOccurs="0"/>
</xs:sequence>
</xs:complexType>
</xs:element>
EOT;
        $this->assertEquals($expectedSchema, $this->userDatasetTable->renderSchema());
    }

    /** @test */
    public function user_dataset_body_is_ok()
    {
        $expectedBody = <<<EOT
<NOM_TABLE diffgr:id="utilisateur" msdata:rowOrder="0">
<id_partenaire>{$this->user['id_partenaire']}</id_partenaire>
<utilisateurs_nom>{$this->user['utilisateurs_nom']}</utilisateurs_nom>
<utilisateurs_prenom>{$this->user['utilisateurs_prenom']}</utilisateurs_prenom>
<utilisateurs_telephone>{$this->user['utilisateurs_telephone']}</utilisateurs_telephone>
<utilisateurs_portable>{$this->user['utilisateurs_portable']}</utilisateurs_portable>
<utilisateurs_email>{$this->user['utilisateurs_email']}</utilisateurs_email>
<utilisateurs_adresse_nom>{$this->user['utilisateurs_adresse_nom']}</utilisateurs_adresse_nom>
<utilisateurs_adresse1>{$this->user['utilisateurs_adresse1']}</utilisateurs_adresse1>
<utilisateurs_adresse2>{$this->user['utilisateurs_adresse2']}</utilisateurs_adresse2>
<utilisateurs_codepostal>{$this->user['utilisateurs_codepostal']}</utilisateurs_codepostal>
<utilisateurs_ville>{$this->user['utilisateurs_ville']}</utilisateurs_ville>
<utilisateurs_pays>{$this->user['utilisateurs_pays']}</utilisateurs_pays>
<date_naissance>{$this->user['date_naissance']}</date_naissance>
</NOM_TABLE>
EOT;
        $this->assertEquals($expectedBody, $this->userDatasetTable->renderBody());
    }
}
