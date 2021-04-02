<?php

namespace Skiloisirs\Tests;

use SkiLoisirsDiffusion\Datasets\DatasetField;
use SkiLoisirsDiffusion\Exceptions\FieldMinOccursShouldBeGreaterThanZeroException;
use SkiLoisirsDiffusion\Exceptions\FieldNameShouldNotBeEmptyException;
use SkiLoisirsDiffusion\Exceptions\FieldTypeNotAllowedException;
use SkiLoisirsDiffusion\Exceptions\FieldValueDoesNotMatchWithTypeException;
use SkiLoisirsDiffusion\Tests\BaseTestCase;

class DatasetFieldTest extends BaseTestCase
{
    /** @test */
    public function non_allowed_type_should_fail()
    {
        $this->expectException(FieldTypeNotAllowedException::class);
        DatasetField::create('field1', 'unknown_type', 'value1');
    }

    /** @test */
    public function non_greater_to_O_min_occurs_should_fail()
    {
        $this->expectException(FieldMinOccursShouldBeGreaterThanZeroException::class);
        DatasetField::create('field1', 'string', 'value1', -12);
    }

    /** @test */
    public function empty_field_name_should_fail()
    {
        $this->expectException(FieldNameShouldNotBeEmptyException::class);
        DatasetField::create('', 'string', 'value1');
    }

    /** @test */
    public function not_a_decimal_should_fail()
    {
        $this->expectException(FieldValueDoesNotMatchWithTypeException::class);
        DatasetField::create('field1', 'decimal', 'value1');
    }

    /** @test */
    public function not_a_date_should_fail()
    {
        $this->expectException(FieldValueDoesNotMatchWithTypeException::class);
        DatasetField::create('field1', 'dateTime', 'this is not a date');
    }

    /** @test */
    public function not_an_int32_should_fail()
    {
        $this->expectException(FieldValueDoesNotMatchWithTypeException::class);
        DatasetField::create('field1', 'int32', 'this is not an int');
    }

    /** @test */
    public function not_an_int64_should_fail()
    {
        $this->expectException(FieldValueDoesNotMatchWithTypeException::class);
        DatasetField::create('field1', 'int64', 'this is not an int');
    }

    /** @test */
    public function string_is_ok()
    {
        $expectedFieldName = 'field1';
        $expectedFieldType = 'xs:string';
        $expectedValue = 'value1';
        $expectedMinOccurs = 10;
        $datasetField = DatasetField::create($expectedFieldName, 'string', $expectedValue, $expectedMinOccurs);
        $this->assertEquals($expectedFieldName, $datasetField->fieldName());
        $this->assertEquals($expectedFieldType, $datasetField->fieldType());
        $this->assertEquals($expectedValue, $datasetField->fieldValue());
        $this->assertEquals($expectedMinOccurs, $datasetField->fieldMinOccurs());
    }

    /** @test */
    public function int32_is_ok()
    {
        $expectedFieldName = 'field1';
        $expectedFieldType = 'xs:int32';
        $expectedValue = 1;
        $expectedMinOccurs = 0;
        $datasetField = DatasetField::create($expectedFieldName, 'int32', $expectedValue, $expectedMinOccurs);
        $this->assertEquals($expectedFieldName, $datasetField->fieldName());
        $this->assertEquals($expectedFieldType, $datasetField->fieldType());
        $this->assertEquals($expectedValue, $datasetField->fieldValue());
        $this->assertEquals($expectedMinOccurs, $datasetField->fieldMinOccurs());
    }

    /** @test */
    public function decimal_is_ok()
    {
        $expectedFieldName = 'field1';
        $expectedFieldType = 'xs:decimal';
        $expectedValue = 29.99;
        $datasetField = DatasetField::create($expectedFieldName, 'decimal', $expectedValue);
        $this->assertEquals(
            '<xs:element name="' . $expectedFieldName . '" type="' . $expectedFieldType . '" minOccurs="0"/>',
            $datasetField->renderSchema()
        );
        $this->assertEquals(
            "<{$expectedFieldName}>{$expectedValue}</{$expectedFieldName}>",
            $datasetField->renderBody()
        );
    }

    /** @test */
    public function date_time_is_ok()
    {
        $expectedFieldName = 'field1';
        $expectedFieldType = 'xs:dateTime';
        $expectedValue = '2015-01-31T08:37:59';
        $datasetField = DatasetField::create($expectedFieldName, 'dateTime', '2015-01-31 08:37:59');
        $this->assertEquals(
            '<xs:element name="' . $expectedFieldName . '" type="' . $expectedFieldType . '" minOccurs="0"/>',
            $datasetField->renderSchema()
        );
        $this->assertEquals(
            "<{$expectedFieldName}>{$expectedValue}</{$expectedFieldName}>",
            $datasetField->renderBody()
        );
    }

    /** @test */
    public function render_is_ok()
    {
        $expectedFieldName = 'field1';
        $expectedFieldType = 'xs:string';
        $expectedMinOccurs = 10;
        $expectedValue = 'value1';
        $datasetField = DatasetField::create($expectedFieldName, 'string', $expectedValue, $expectedMinOccurs);
        $this->assertEquals(
            '<xs:element name="' . $expectedFieldName . '" type="' . $expectedFieldType . '" minOccurs="' . $expectedMinOccurs . '"/>',
            $datasetField->renderSchema()
        );

        $this->assertEquals(
            "<{$expectedFieldName}>{$expectedValue}</{$expectedFieldName}>",
            $datasetField->renderBody()
        );
    }

    /** @test */
    public function allowed_field_types_is_ok()
    {
        $datasetFieldTypes = DatasetField::allowedFieldTypes();
        $this->assertIsArray($datasetFieldTypes);
        $this->assertEqualsCanonicalizing(['string', 'dateTime', 'decimal', 'int32', 'int64'], $datasetFieldTypes);
    }

    /** @test */
    public function empty_field_not_required_should_be_ok()
    {
        $datasetField = DatasetField::create('field1', 'string', '', 0, false);
        $this->assertEquals(
            '<xs:element name="field1" type="xs:string" minOccurs="0"/>',
            $datasetField->renderSchema()
        );
        $this->assertEquals('<field1></field1>', $datasetField->renderBody());
    }

    /** @test */
    public function null_field_not_required_should_be_ok()
    {
        $datasetField = DatasetField::create('field1', 'string', null, 0, false);
        $this->assertEquals(
            '<xs:element name="field1" type="xs:string" minOccurs="0"/>',
            $datasetField->renderSchema()
        );
        $this->assertEquals('<field1></field1>', $datasetField->renderBody());
    }
}
