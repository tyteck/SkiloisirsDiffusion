<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use SkiloisirsDiffusion\SkiLoisirsDiffusion;

class SkiLoisirsDiffusionTest extends TestCase
{
    public function setUp():void
    {
        parent::setUp();
        $this->partenaireId = config('sld_partenaire_id');
    }

    public function testEtatSite()
    {
        $this->assertTrue(SkiLoisirsDiffusion::create($this->partenaireId)
            ->ETAT_SITE());
    }
    
    public function testGetLieu()
    {
        $lieu = SkiLoisirsDiffusion::create($this->partenaireId)->GET_LIEU('745cf374-7556-407e-aad6-57c417508e3b');
        $this->assertIsArray($lieu, 'We should receive an array.');
        // disneyland paris
        $expectedLocationName='Disneyland paris';
        $this->assertEquals(
            $expectedLocationName,
            SkiLoisirsDiffusion::create($this->partenaireId)->GET_LIEU('745cf374-7556-407e-aad6-57c417508e3b')['name']
        );
    }
}
