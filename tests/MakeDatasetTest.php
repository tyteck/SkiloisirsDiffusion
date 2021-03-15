<?php

namespace Skiloisirs\Tests;

use SkiLoisirsDiffusion\Datasets\DatasetField;
use SkiLoisirsDiffusion\Datasets\MakeDataset;
use SkiLoisirsDiffusion\Tests\BaseTestCase;
use stdClass;

class MakeDatasetTest extends BaseTestCase
{
    /** @test */
    public function simple_one_is_ok()
    {
        $streetAddressField = DatasetField::create('streetnumber', 'string', 'rue de la petite crèmerie');
        $createdDataset = MakeDataset::init('address')->addField($streetAddressField);
        $this->assertInstanceOf(stdClass::class, $createdDataset->dataset());

        dump($createdDataset->schema(), $createdDataset->body());
    }
}
