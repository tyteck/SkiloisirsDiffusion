<?php

namespace SkiLoisirsDiffusion\Tests;

use InvalidArgumentException;
use SkiLoisirsDiffusion\Datatypes\EbilletDatatype;
use SkiLoisirsDiffusion\Tests\Factory\EbilletFactory;

class EbilletDatatypeTest extends BaseTestCase
{
    /**
     * @test
     * @dataProvider provide_invalid_data
     */
    public function partial_info_should_fail($invalidData)
    {
        $this->expectException(InvalidArgumentException::class);
        EbilletDatatype::create($invalidData);
    }

    /**
     * @test
     * @dataProvider provide_valid_data
     */
    public function all_fields_filled_should_be_ok($validData)
    {
        $ebilletDatatype = EbilletDatatype::create($validData);
        $this->assertInstanceOf(EbilletDatatype::class, $ebilletDatatype);
        $this->assertEquals($validData['code_article'], $ebilletDatatype->code_article);
        $this->assertEquals($validData['nom'], $ebilletDatatype->nom);
        $this->assertEquals($validData['prenom'], $ebilletDatatype->prenom);
        $this->assertEquals($validData['date'], $ebilletDatatype->date);
        $this->assertEquals($validData['date_naissance'], $ebilletDatatype->date_naissance);
        $this->assertEquals($validData['keycard'], $ebilletDatatype->keycard);
        $this->assertEquals($validData['skier_index'], $ebilletDatatype->skier_index);
    }

    public function provide_invalid_data()
    {
        return [
            [
                [
                    'code_article' => null,
                    'nom' => null,
                    'prenom' => null,
                    'date' => null,
                    'date_naissance' => null,
                    'keycard' => null,
                    'skier_index' => null,
                ]
            ],
        ];
    }

    public function provide_valid_data()
    {
        return [
            [EbilletFactory::create()],
            [EbilletFactory::create()],
        ];
    }
}
