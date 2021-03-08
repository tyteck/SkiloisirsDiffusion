<?php

namespace SkiLoisirsDiffusion\Tests;

use SkiLoisirsDiffusion\Datasets\CEDataset;
use SkiLoisirsDiffusion\Datasets\CreateOrderDataset;
use SkiLoisirsDiffusion\SkiLoisirsDiffusion;

class SkiLoisirsDiffusionTest extends BaseTestCase
{
    public function setUp():void
    {
        parent::setUp();
        $this->partenaireId = sldconfig('sld_partenaire_id');
        $this->sldDomainUrl = sldconfig('sld_domain_url');
    }

    /** @test */
    public function etat_site_is_ok()
    {
        $this->assertTrue(
            SkiLoisirsDiffusion::create($this->sldDomainUrl, $this->partenaireId)
                ->ETAT_SITE()
        );
    }

    /** @test */
    public function get_modes_paiements()
    {
        //$this->markTestIncomplete('👉 to be done.');
        $this->assertTrue(
            SkiLoisirsDiffusion::create($this->sldDomainUrl, $this->partenaireId)
                ->GET_MODES_PAIEMENTS()
        );
    }

    public function testGetLieu()
    {
        $expectedResult = [
            'lieux_id' => '745cf374-7556-407e-aad6-57c417508e3b', // disneyland paris
            'lieux_nom' => 'DISNEYLAND PARIS BILLETS',
            'lieux_plan' => 'https://cdn.skiloisirsdiffusion.com/image/plan_745cf374-7556-407e-aad6-57c417508e3b_0_0_0_0_20210119090624.png',
        ];
        $result = SkiLoisirsDiffusion::create($this->sldDomainUrl, $this->partenaireId)->GET_LIEU($expectedResult['lieux_id']);

        $this->assertIsArray($result, 'We should receive an array from GET_LIEU.');
        $this->assertEqualsCanonicalizing(
            array_keys($expectedResult),
            array_keys($result)
        );
        array_map(function ($key, $expectedValue) use ($result) {
            $this->assertEquals($expectedValue, $result[$key], "We were expecting {$expectedValue} for {$key} and we obtained {$result[$key]}");
        }, array_keys($expectedResult), $expectedResult);
    }

    /** @test */
    public function creation_commande_is_ok()
    {
        //$this->markTestIncomplete('👉 Strange behavior or strange requesting❓');
        $ceDataSet = CEDataset::create();
        $userDataSet = $this->createUserDataset();
        $orderDataSet = $this->createOrderDataset();
        $signatureDataSet = $this->createSignatureDataset($this->signatureDatasetParameters());

        $createOrderDataset = CreateOrderDataset::create($ceDataSet, $userDataSet, $orderDataSet, $signatureDataSet);
        $result = SkiLoisirsDiffusion::create($this->sldDomainUrl, $this->partenaireId)
            ->CREATION_COMMANDE($createOrderDataset);
    }

    /** @test */
    public function ticket_place_reservation_is_ok()
    {
        $articleDataset = $this->createArticleDataset($this->articleDatasetParameters());
        $result = SkiLoisirsDiffusion::create($this->sldDomainUrl, $this->partenaireId)
            ->ticketPlaceReservation($articleDataset);
    }
}
