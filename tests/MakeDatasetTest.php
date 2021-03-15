<?php

namespace Skiloisirs\Tests;

use SkiLoisirsDiffusion\Datasets\MakeDataset;
use SkiLoisirsDiffusion\Tests\BaseTestCase;
use stdClass;

class MakeDatasetTest extends BaseTestCase
{
    /** @test */
    public function duplicate_field_is_not_allowed()
    {
        $dataset = MakeDataset::create(
            [
                'field1' => ['type' => 'string', 'minOccurs' => 0],
            ]
        )->dataset();
        $this->assertInstanceOf(stdClass::class, $dataset);
    }

    /** @test */
    public function simple_one_is_ok()
    {
        $dataset = MakeDataset::create(
            [
                'field1' => ['type' => 'string', 'minOccurs' => 0],
            ]
        )->dataset();
        $this->assertInstanceOf(stdClass::class, $dataset);
    }
}
