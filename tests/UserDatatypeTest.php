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
        $this->assertEquals($validData['utilisateurs_nom'], $userDatatype->utilisateurs_nom);
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
