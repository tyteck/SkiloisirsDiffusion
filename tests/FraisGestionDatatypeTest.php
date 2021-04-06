<?php

namespace SkiLoisirsDiffusion\Tests;

use InvalidArgumentException;
use SkiLoisirsDiffusion\Datatypes\FraisGestionDatatype;
use SkiLoisirsDiffusion\Tests\Factory\FraisGestionFactory;

class FraisGestionDatatypeTest extends BaseTestCase
{
    /**
     * @test
     * @dataProvider provide_invalid_data
     */
    public function partial_info_should_fail($invalidData)
    {
        $this->expectException(InvalidArgumentException::class);
        FraisGestionDatatype::create($invalidData);
    }

    /**
     * @test
     * @dataProvider provide_valid_data
     */
    public function all_fields_filled_should_be_ok($validData)
    {
        $fraisGestionDatatype = FraisGestionDatatype::create($validData);
        $this->assertInstanceOf(FraisGestionDatatype::class, $fraisGestionDatatype);
        $this->assertEquals($validData['nb_ebillets'], $fraisGestionDatatype->nb_ebillets);
        $this->assertEquals($validData['prix_ebillet'], $fraisGestionDatatype->prix_ebillet);
        $this->assertEquals($validData['nb_ebc'], $fraisGestionDatatype->nb_ebc);
        $this->assertEquals($validData['prix_ebc'], $fraisGestionDatatype->prix_ebc);
        $this->assertEquals($validData['nb_ebr'], $fraisGestionDatatype->nb_ebr);
        $this->assertEquals($validData['prix_ebr'], $fraisGestionDatatype->prix_ebr);
        $this->assertEquals($validData['nb_be'], $fraisGestionDatatype->nb_be);
        $this->assertEquals($validData['prix_be'], $fraisGestionDatatype->prix_be);
        $this->assertEquals($validData['nb_etickets'], $fraisGestionDatatype->nb_etickets);
        $this->assertEquals($validData['prix_etickets'], $fraisGestionDatatype->prix_etickets);
        $this->assertEquals($validData['nb_retraits'], $fraisGestionDatatype->nb_retraits);
        $this->assertEquals($validData['prix_retraits'], $fraisGestionDatatype->prix_retraits);
        $this->assertEquals($validData['remise_ebillets'], $fraisGestionDatatype->remise_ebillets);
        $this->assertEquals($validData['remise_ebc'], $fraisGestionDatatype->remise_ebc);
        $this->assertEquals($validData['remise_ebr'], $fraisGestionDatatype->remise_ebr);
        $this->assertEquals($validData['remise_be'], $fraisGestionDatatype->remise_be);
        $this->assertEquals($validData['remise_etickets'], $fraisGestionDatatype->remise_etickets);
        $this->assertEquals($validData['remise_retraits'], $fraisGestionDatatype->remise_retraits);
        $this->assertEquals($validData['nb_cartes_cadeaux'], $fraisGestionDatatype->nb_cartes_cadeaux);
        $this->assertEquals($validData['prix_carte_cadeau'], $fraisGestionDatatype->prix_carte_cadeau);
        $this->assertEquals($validData['remise_cartes_cadeaux'], $fraisGestionDatatype->remise_cartes_cadeaux);
        $this->assertEquals($validData['montant_plafond_commande'], $fraisGestionDatatype->montant_plafond_commande);
        $this->assertEquals($validData['nb_frais_gestion'], $fraisGestionDatatype->nb_frais_gestion);
        $this->assertEquals($validData['prix_frais_gestion'], $fraisGestionDatatype->prix_frais_gestion);
        $this->assertEquals($validData['nb_frais_demat'], $fraisGestionDatatype->nb_frais_demat);
        $this->assertEquals($validData['prix_frais_demat'], $fraisGestionDatatype->prix_frais_demat);
        $this->assertEquals($validData['nb_frais_papier'], $fraisGestionDatatype->nb_frais_papier);
        $this->assertEquals($validData['prix_frais_papier'], $fraisGestionDatatype->prix_frais_papier);
    }

    public function provide_invalid_data()
    {
        return [
            [
                [
                    'nb_ebillets' => null,
                    'prix_ebillet' => null,
                    'nb_ebc' => null,
                    'prix_ebc' => null,
                    'nb_ebr' => null,
                    'prix_ebr' => null,
                    'nb_be' => null,
                    'prix_be' => null,
                    'nb_etickets' => null,
                    'prix_etickets' => null,
                    'nb_retraits' => null,
                    'prix_retraits' => null,
                    'remise_ebillets' => null,
                    'remise_ebc' => null,
                    'remise_ebr' => null,
                    'remise_be' => null,
                    'remise_etickets' => null,
                    'remise_retraits' => null,
                    'nb_cartes_cadeaux' => null,
                    'prix_carte_cadeau' => null,
                    'remise_cartes_cadeaux' => null,
                    'montant_plafond_commande' => null,
                    'nb_frais_gestion' => null,
                    'prix_frais_gestion' => null,
                    'nb_frais_demat' => null,
                    'prix_frais_demat' => null,
                    'nb_frais_papier' => null,
                    'prix_frais_papier' => null,
                ]
            ],
        ];
    }

    public function provide_valid_data()
    {
        return [
            [FraisGestionFactory::create()],
            [FraisGestionFactory::create()],
        ];
    }
}
