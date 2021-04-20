<?php

namespace SkiLoisirsDiffusion\Tests;

use SkiLoisirsDiffusion\DatasetTables\UserDatasetTable;
use SkiLoisirsDiffusion\Datatypes\UserDatatype;
use SkiLoisirsDiffusion\Tests\Factory\UserFactory;

class UserDatasetTest extends BaseTestCase
{
    /** @var \SkiLoisirsDiffusion\Datatypes\UserDatatype $user */
    protected $user;

    /** @var \SkiLoisirsDiffusion\DatasetTables\DatasetTable $userDatasetTable */
    protected $userDatasetTable;

    public function setUp(): void
    {
        parent::setUp();
        /** factory create fake user array I throw to userDataType*/
        $this->user = UserDatatype::create(UserFactory::create());

        $this->userDatasetTable = UserDatasetTable::prepare()->with($this->user);
    }

    /** @test */
    public function user_dataset_schema_is_ok()
    {
        $expectedSchema = <<<EOT
<xs:element name="utilisateur">
<xs:complexType>
<xs:sequence>
<xs:element name="id_partenaire" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_societe" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_civilite" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_nom" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_prenom" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_telephone" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_portable" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_fax" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_email" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_adresse_nom" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_adresse1" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_adresse2" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_codepostal" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_ville" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_pays" type="xs:string" minOccurs="0"/>
<xs:element name="utilisateurs_date_naissance" type="xs:string" minOccurs="0"/>
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
<utilisateur diffgr:id="utilisateur1" msdata:rowOrder="0">
<id_partenaire>{$this->user->id_partenaire}</id_partenaire>
<utilisateurs_societe>{$this->user->utilisateurs_societe}</utilisateurs_societe>
<utilisateurs_civilite>{$this->user->utilisateurs_civilite}</utilisateurs_civilite>
<utilisateurs_nom>{$this->user->utilisateurs_nom}</utilisateurs_nom>
<utilisateurs_prenom>{$this->user->utilisateurs_prenom}</utilisateurs_prenom>
<utilisateurs_telephone>{$this->user->utilisateurs_telephone}</utilisateurs_telephone>
<utilisateurs_portable>{$this->user->utilisateurs_portable}</utilisateurs_portable>
<utilisateurs_fax>{$this->user->utilisateurs_fax}</utilisateurs_fax>
<utilisateurs_email>{$this->user->utilisateurs_email}</utilisateurs_email>
<utilisateurs_adresse_nom>{$this->user->utilisateurs_adresse_nom}</utilisateurs_adresse_nom>
<utilisateurs_adresse1>{$this->user->utilisateurs_adresse1}</utilisateurs_adresse1>
<utilisateurs_adresse2>{$this->user->utilisateurs_adresse2}</utilisateurs_adresse2>
<utilisateurs_codepostal>{$this->user->utilisateurs_codepostal}</utilisateurs_codepostal>
<utilisateurs_ville>{$this->user->utilisateurs_ville}</utilisateurs_ville>
<utilisateurs_pays>{$this->user->utilisateurs_pays}</utilisateurs_pays>
<utilisateurs_date_naissance>{$this->user->utilisateurs_date_naissance}</utilisateurs_date_naissance>
</utilisateur>
EOT;
        $this->assertEquals($expectedBody, $this->userDatasetTable->renderBody());
    }
}
