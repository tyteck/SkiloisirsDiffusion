<?php

namespace SkiLoisirsDiffusion\Tests;

use InvalidArgumentException;
use SkiLoisirsDiffusion\Datatypes\OrderDatatype;
use SkiLoisirsDiffusion\Tests\Factory\OrderFactory;

class OrderDatatypeTest extends BaseTestCase
{
    /**
     * @test
     * @dataProvider provide_invalid_data
     */
    public function partial_info_should_fail($invalidData)
    {
        $this->expectException(InvalidArgumentException::class);
        OrderDatatype::create($invalidData);
    }

    /**
     * @test
     * @dataProvider provide_valid_data
     */
    public function all_fields_filled_should_be_ok($validData)
    {
        $orderDatatype = OrderDatatype::create($validData);
        $this->assertInstanceOf(OrderDatatype::class, $orderDatatype);
        $this->assertEquals($validData['nb_cheques_vacances'], $orderDatatype->nb_cheques_vacances);
        $this->assertEquals($validData['montant_total_cheques_vacances'], $orderDatatype->montant_total_cheques_vacances);
        $this->assertEquals($validData['mode_paiement'], $orderDatatype->mode_paiement);
        $this->assertEquals($validData['prix_livraison'], $orderDatatype->prix_livraison);
        $this->assertEquals($validData['code_livraison'], $orderDatatype->code_livraison);
        $this->assertEquals($validData['commentaire'], $orderDatatype->commentaire);
        $this->assertEquals($validData['livraison_adresse_societe'], $orderDatatype->livraison_adresse_societe);
        $this->assertEquals($validData['livraison_adresse_nom'], $orderDatatype->livraison_adresse_nom);
        $this->assertEquals($validData['livraison_adresse1'], $orderDatatype->livraison_adresse1);
        $this->assertEquals($validData['livraison_adresse2'], $orderDatatype->livraison_adresse2);
        $this->assertEquals($validData['livraison_codepostal'], $orderDatatype->livraison_codepostal);
        $this->assertEquals($validData['livraison_ville'], $orderDatatype->livraison_ville);
        $this->assertEquals($validData['livraison_pays'], $orderDatatype->livraison_pays);
        $this->assertEquals($validData['url_retour'], $orderDatatype->url_retour);
        $this->assertEquals($validData['url_retour_ok'], $orderDatatype->url_retour_ok);
        $this->assertEquals($validData['url_retour_err'], $orderDatatype->url_retour_err);
        $this->assertEquals($validData['acompte'], $orderDatatype->acompte);
        $this->assertEquals($validData['numero_commande_ticketnet'], $orderDatatype->numero_commande_ticketnet);
        $this->assertEquals($validData['frais_gestion_payeur'], $orderDatatype->frais_gestion_payeur);
        $this->assertEquals($validData['frais_port_payeur'], $orderDatatype->frais_port_payeur);
        $this->assertEquals($validData['remise_frais_port'], $orderDatatype->remise_frais_port);
        $this->assertEquals($validData['numero_commande_distributeur'], $orderDatatype->numero_commande_distributeur);
    }

    public function provide_invalid_data()
    {
        return [
            [
                [
                    'nb_cheques_vacances' => null,
                    'montant_total_cheques_vacances' => null,
                    'mode_paiement' => null,
                    'prix_livraison' => null,
                    'code_livraison' => null,
                    'commentaire' => null,
                    'livraison_adresse_societe' => null,
                    'livraison_adresse_nom' => null,
                    'livraison_adresse1' => null,
                    'livraison_adresse2' => null,
                    'livraison_codepostal' => null,
                    'livraison_ville' => null,
                    'livraison_pays' => null,
                    'url_retour' => null,
                    'url_retour_ok' => null,
                    'url_retour_err' => null,
                    'acompte' => null,
                    'numero_commande_ticketnet' => null,
                    'frais_gestion_payeur' => null,
                    'frais_port_payeur' => null,
                    'remise_frais_port' => null,
                    'numero_commande_distributeur' => null,
                ]
            ],
        ];
    }

    public function provide_valid_data()
    {
        return [
            [OrderFactory::create()],
            [OrderFactory::create()],
        ];
    }
}
