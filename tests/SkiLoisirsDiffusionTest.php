<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use SkiLoisirsDiffusion\SkiLoisirsDiffusion;

class SkiLoisirsDiffusionTest extends TestCase
{
    public function setUp():void
    {
        parent::setUp();
        $this->partenaireId = sldconfig('sld_partenaire_id');
    }

    public function testEtatSite()
    {
        $this->assertTrue(SkiLoisirsDiffusion::create($this->partenaireId)
            ->ETAT_SITE());
    }

    public function testGetLieu()
    {
        $expectedResult = [
            'lieux_id' => '745cf374-7556-407e-aad6-57c417508e3b', // disneyland paris
            'lieux_nom' => 'DISNEYLAND PARIS BILLETS',
            'lieux_plan' => 'https://cdn.skiloisirsdiffusion.com/image/plan_745cf374-7556-407e-aad6-57c417508e3b_0_0_0_0_20201202035517.png',
        ];
        $result = SkiLoisirsDiffusion::create($this->partenaireId)->GET_LIEU($expectedResult['lieux_id']);

        $this->assertIsArray($result, 'We should receive an array from GET_LIEU.');
        $this->assertEqualsCanonicalizing(
            array_keys($expectedResult),
            array_keys($result)
        );
        array_map(function ($key, $expectedValue) use ($result) {
            $this->assertEquals($expectedValue, $result[$key], "We were expecting {$expectedValue} for {$key} and we obtained {$result[$key]}");
        }, array_keys($expectedResult), $expectedResult);
    }
}
