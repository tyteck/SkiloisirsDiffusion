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
        $livraisons = Livraisons::init(sldconfig('sld_domain_url'));
        if (sldconfig('use_real_data') == 1) {
            $livraisons->fromRemote();
        } else {
            $livraisons->fromLocal();
        }
        $result = $livraisons->deliveryModes();

        $this->assertIsArray($result);
        $this->assertGreaterThan(0, count($result));
    }
}
