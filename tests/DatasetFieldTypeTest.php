<?php

namespace Skiloisirs\Tests;

use SkiLoisirsDiffusion\Datasets\DatasetFieldType;
use SkiLoisirsDiffusion\Exceptions\FieldMinOccursShouldBeGreaterThanZeroException;
use SkiLoisirsDiffusion\Exceptions\FieldNameShouldNotBeEmptyException;
use SkiLoisirsDiffusion\Exceptions\FieldTypeNotAllowedException;
use SkiLoisirsDiffusion\Tests\BaseTestCase;

class DatasetFieldTypeTest extends BaseTestCase
{
    /** @test */
    public function non_allowed_type_should_fail()
    {
        $this->expectException(FieldTypeNotAllowedException::class);
        DatasetFieldType::create('foo', 'unknown_type');
    }

    /** @test */
    public function non_greater_to_O_min_occurs_should_fail()
    {
        $this->expectException(FieldMinOccursShouldBeGreaterThanZeroException::class);
        DatasetFieldType::create('foo', 'string', -12);
    }

    /** @test */
    public function empty_field_name_should_fail()
    {
        $this->expectException(FieldNameShouldNotBeEmptyException::class);
        DatasetFieldType::create('', 'string');
    }

    /** @test */
    public function simple_data_set_is_ok()
    {
        DatasetFieldType::create('field1', 'string');
    }
}
