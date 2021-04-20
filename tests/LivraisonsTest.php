<?php

namespace SkiLoisirsDiffusion\Tests;

use SkiLoisirsDiffusion\Livraisons;

class LivraisonsTest extends BaseTestCase
{
    public function setUp() :void
    {
        parent::setUp();
    }

    /** @test */
    public function livraisons_is_working_properly()
    {
        $result = Livraisons::init(sldconfig('sld_domain_url'))->fromRemote()->deliveryModes();
        //dump($result);
        $this->assertIsArray($result);
        $this->assertGreaterThan(0, count($result));
    }
}
