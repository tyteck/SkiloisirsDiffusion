<?php

namespace SkiLoisirsDiffusion\Tests;

use Mockery;
use SkiLoisirsDiffusion\SkiLoisirsDiffusion;

class SkiLoisirsDiffusionTest extends BaseTestCase
{
    /** @var \Mockery $mocked */
    protected $mocked;

    /** @var \SkiLoisirsDiffusion\SkiLoisirsDiffusion $factory */
    protected $factory;

    /** @var string $sldDomainUrl */
    protected $sldDomainUrl;

    /** @var string $partenaireId */
    protected $partenaireId;

    public function setUp():void
    {
        parent::setUp();

        $this->sldDomainUrl = sldconfig('sld_domain_url');
        $this->partenaireId = sldconfig('sld_partenaire_id');
        if (sldconfig('use_real_data') == 1) {
            $this->factory = SkiLoisirsDiffusion::create($this->sldDomainUrl, $this->partenaireId);
        } else {
            $this->mocked = Mockery::mock(SkiLoisirsDiffusion::class)->makePartial();
            $this->mocked->shouldReceive('create')->with($this->sldDomainUrl, $this->partenaireId);
        }
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    /** @test */
    public function etat_site_is_ok()
    {
        if (sldconfig('use_real_data') == 1) {
            $this->assertTrue($this->factory->ETAT_SITE());
        } else {
            $this->mocked->shouldReceive('ETAT_SITE')->once()->andReturn(true);
            $this->assertTrue($this->mocked->ETAT_SITE());
        }
    }

    /** @test */
    public function get_modes_paiements()
    {
        $keysToCheck = ['id', 'code', 'reglement'];
        $expectedResults = [
            [
                'id' => '2f8fcd84-0dc0-44eb-b217-e9b99a77983b',
                'code' => 'CB',
                'reglement' => 'CB1'
            ],
            [
                'id' => 'e1ec4ce3-2fc7-4bd2-af10-a8e934e4244f',
                'code' => 'CHQ',
                'reglement' => 'C01'
            ],
            [
                'id' => '79834c63-51af-4826-b45b-ff0539c5d7a4',
                'code' => 'FCH',
                'reglement' => 'C01'
            ],
        ];

        /*
        true call
        $results = SkiLoisirsDiffusion::create($this->sldDomainUrl, $this->partenaireId)->GET_MODES_PAIEMENTS();
        */
        if (sldconfig('use_real_data') == 1) {
            $results = $this->factory->GET_MODES_PAIEMENTS();
        } else {
            $this->mocked->shouldReceive('GET_MODES_PAIEMENTS')->once()->andReturn($expectedResults);
            $results = $this->mocked->GET_MODES_PAIEMENTS();
        }

        $this->assertCount(3, $results);
        array_map(function ($key) use ($results, $expectedResults) {
            $this->assertEqualsCanonicalizing(
                array_map(function ($item) use ($key) { return $item[$key];}, $expectedResults),
                array_map(function ($item) use ($key) { return $item[$key];}, $results),
                "Non expected result for key : {$key}"
            );
        }, $keysToCheck);
    }

    public function testGetLieu()
    {
        $expectedResult = [
            'lieux_id' => '745cf374-7556-407e-aad6-57c417508e3b', // disneyland paris
            'lieux_nom' => 'DISNEYLAND PARIS BILLETS',
            'lieux_plan' => 'https://cdn.skiloisirsdiffusion.com/image/plan_745cf374-7556-407e-aad6-57c417508e3b_0_0_0_0_20210119090624.png',
        ];

        if (sldconfig('use_real_data') == 1) {
            $result = $this->factory->GET_LIEU($expectedResult['lieux_id']);
        } else {
            $this->mocked->shouldReceive('GET_LIEU')->once()->with($expectedResult['lieux_id'])->andReturn($expectedResult);
            $result = $this->mocked->GET_LIEU($expectedResult['lieux_id']);
        }
        /*
         true call
         $result = SkiLoisirsDiffusion::create($this->sldDomainUrl, $this->partenaireId)->GET_LIEU($expectedResult['lieux_id']);
         */

        $this->assertIsArray($result, 'We should receive an array from GET_LIEU.');
        $this->assertEqualsCanonicalizing(
            array_keys($expectedResult),
            array_keys($result)
        );
        array_map(function ($key, $expectedValue) use ($result) {
            if ($key === 'lieux_plan') {
                /** not checkling if url is the exact one because it changes every week */
                $this->assertTrue(filter_var($result[$key], FILTER_VALIDATE_URL) !== false);
                return true;
            }
            $this->assertEquals($expectedValue, $result[$key], "We were expecting {$expectedValue} for {$key} and we obtained {$result[$key]}");
        }, array_keys($expectedResult), $expectedResult);
    }
}
