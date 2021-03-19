<?php

namespace Skiloisirs\Tests;

use SkiLoisirsDiffusion\Datasets\DatasetTable;
use SkiLoisirsDiffusion\Exceptions\TableNameShouldNotBeEmptyException;
use SkiLoisirsDiffusion\Tests\BaseTestCase;

class DatasetTableTest extends BaseTestCase
{
    /** @test */
    public function empty_table_name_should_fail()
    {
        $this->expectException(TableNameShouldNotBeEmptyException::class);
        DatasetTable::create('');
    }
}
