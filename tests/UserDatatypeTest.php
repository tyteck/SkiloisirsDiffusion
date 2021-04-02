<?php

namespace SkiLoisirsDiffusion\Tests;

use InvalidArgumentException;
use SkiLoisirsDiffusion\Datatypes\UserDatatype;
use SkiLoisirsDiffusion\Tests\Factory\UserFactory;

class UserDatatypeTest extends BaseTestCase
{
    /**
     * @test
     * @dataProvider provide_invalid_data
     */
    public function partial_info_should_fail($invalidData)
    {
        $this->expectException(InvalidArgumentException::class);
        UserDatatype::create($invalidData);
    }

    /**
     * @test
     * @dataProvider provide_valid_data
     */
    public function all_fields_filled_should_be_ok($validData)
    {
        $userDatatype = UserDatatype::create($validData);
        $this->assertInstanceOf(UserDatatype::class, $userDatatype);
        $this->assertEquals($validData['id_partenaire'], $userDatatype->id_partenaire);
        $this->assertEquals($validData['utilisateurs_societe'], $userDatatype->utilisateurs_societe);
        $this->assertEquals($validData['utilisateurs_civilite'], $userDatatype->utilisateurs_civilite);
        $this->assertEquals($validData['utilisateurs_nom'], $userDatatype->utilisateurs_nom);
        $this->assertEquals($validData['utilisateurs_prenom'], $userDatatype->utilisateurs_prenom);
        $this->assertEquals($validData['utilisateurs_telephone'], $userDatatype->utilisateurs_telephone);
        $this->assertEquals($validData['utilisateurs_portable'], $userDatatype->utilisateurs_portable);
        $this->assertEquals($validData['utilisateurs_fax'], $userDatatype->utilisateurs_fax);
        $this->assertEquals($validData['utilisateurs_email'], $userDatatype->utilisateurs_email);
        $this->assertEquals($validData['utilisateurs_adresse_nom'], $userDatatype->utilisateurs_adresse_nom);
        $this->assertEquals($validData['utilisateurs_adresse1'], $userDatatype->utilisateurs_adresse1);
        $this->assertEquals($validData['utilisateurs_adresse2'], $userDatatype->utilisateurs_adresse2);
        $this->assertEquals($validData['utilisateurs_codepostal'], $userDatatype->utilisateurs_codepostal);
        $this->assertEquals($validData['utilisateurs_ville'], $userDatatype->utilisateurs_ville);
        $this->assertEquals($validData['utilisateurs_pays'], $userDatatype->utilisateurs_pays);
        $this->assertEquals($validData['utilisateurs_date_naissance'], $userDatatype->utilisateurs_date_naissance);
    }

    public function provide_invalid_data()
    {
        return [
            [
                [
                    'id_partenaire' => null, 'utilisateurs_societe' => null, 'utilisateurs_civilite' => null, 'utilisateurs_nom' => null,
                    'utilisateurs_prenom' => null, 'utilisateurs_telephone' => null, 'utilisateurs_portable' => null, 'utilisateurs_fax' => null,
                    'utilisateurs_email' => null, 'utilisateurs_adresse_nom' => null, 'utilisateurs_adresse1' => null, 'utilisateurs_adresse2' => null,
                    'utilisateurs_codepostal' => null, 'utilisateurs_ville' => null, 'utilisateurs_pays' => null, 'utilisateurs_date_naissance' => null,
                ]
            ],
            [
                [
                    'id_partenaire' => 1, 'utilisateurs_societe' => 'Acme', 'utilisateurs_civilite' => null, 'utilisateurs_nom' => null,
                    'utilisateurs_prenom' => null, 'utilisateurs_telephone' => null, 'utilisateurs_portable' => null, 'utilisateurs_fax' => null,
                    'utilisateurs_email' => null, 'utilisateurs_adresse_nom' => null, 'utilisateurs_adresse1' => null, 'utilisateurs_adresse2' => null,
                    'utilisateurs_codepostal' => null, 'utilisateurs_ville' => null, 'utilisateurs_pays' => null, 'utilisateurs_date_naissance' => null,
                ]
            ],
        ];
    }

    public function provide_valid_data()
    {
        return [
            [UserFactory::create()],
            [UserFactory::create()],
        ];
    }
}
