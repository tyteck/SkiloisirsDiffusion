<?php

namespace SkiLoisirsDiffusion\Tests;

use InvalidArgumentException;
use SkiLoisirsDiffusion\Datatypes\CeDatatype;

class CeDatatypeTest extends BaseTestCase
{
    /**
     * @test
     * @dataProvider provide_invalid_data
     */
    public function partial_info_should_fail($invalidData)
    {
        $this->expectException(InvalidArgumentException::class);
        CeDatatype::create($invalidData);
    }

    /**
     * @test
     * @dataProvider provide_valid_data
     */
    public function all_fields_filled_should_be_ok($validData)
    {
        $ceDatatype = CeDatatype::create($validData);
        $this->assertInstanceOf(CeDatatype::class, $ceDatatype);
        $this->assertEquals($validData['ce_id'], $ceDatatype->ce_id);
        $this->assertEquals($validData['ce_societe'], $ceDatatype->ce_societe);
        $this->assertEquals($validData['ce_civilite'], $ceDatatype->ce_civilite);
        $this->assertEquals($validData['ce_nom'], $ceDatatype->ce_nom);
        $this->assertEquals($validData['ce_prenom'], $ceDatatype->ce_prenom);
        $this->assertEquals($validData['ce_telephone'], $ceDatatype->ce_telephone);
        $this->assertEquals($validData['ce_portable'], $ceDatatype->ce_portable);
        $this->assertEquals($validData['ce_fax'], $ceDatatype->ce_fax);
        $this->assertEquals($validData['ce_email'], $ceDatatype->ce_email);
        $this->assertEquals($validData['ce_adresse_nom'], $ceDatatype->ce_adresse_nom);
        $this->assertEquals($validData['ce_adresse1'], $ceDatatype->ce_adresse1);
        $this->assertEquals($validData['ce_adresse2'], $ceDatatype->ce_adresse2);
        $this->assertEquals($validData['ce_codepostal'], $ceDatatype->ce_codepostal);
        $this->assertEquals($validData['ce_ville'], $ceDatatype->ce_ville);
        $this->assertEquals($validData['ce_pays'], $ceDatatype->ce_pays);
    }

    public function provide_invalid_data()
    {
        return [
            [
                [
                    'ce_id' => null,
                    'ce_societe' => null,
                    'ce_civilite' => null,
                    'ce_nom' => null,
                    'ce_prenom' => null,
                    'ce_telephone' => null,
                    'ce_portable' => null,
                    'ce_fax' => null,
                    'ce_email' => null,
                    'ce_adresse_nom' => null,
                    'ce_adresse1' => null,
                    'ce_adresse2' => null,
                    'ce_codepostal' => null,
                    'ce_ville' => null,
                    'ce_pays' => null,
                ]
            ],
        ];
    }

    public function provide_valid_data()
    {
        return [
            [
                [
                    'ce_id' => sldconfig('sld_partenaire_id'),
                    'ce_societe' => sldconfig('ce_societe'),
                    'ce_civilite' => null,
                    'ce_nom' => sldconfig('ce_nom'),
                    'ce_prenom' => sldconfig('ce_prenom'),
                    'ce_telephone' => null,
                    'ce_portable' => null,
                    'ce_fax' => null,
                    'ce_email' => sldconfig('ce_email'),
                    'ce_adresse_nom' => null,
                    'ce_adresse1' => null,
                    'ce_adresse2' => null,
                    'ce_codepostal' => sldconfig('ce_codepostal'),
                    'ce_ville' => sldconfig('ce_ville'),
                    'ce_pays' => null,
                ]
            ],
        ];
    }
}
