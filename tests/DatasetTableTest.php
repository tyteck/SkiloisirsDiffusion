<?php

namespace Skiloisirs\Tests;

use InvalidArgumentException;
use SkiLoisirsDiffusion\Datasets\DatasetField;
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

    /** @test */
    public function dataset_fields_is_ok()
    {
        $datasetTable = DatasetTable::create('user');
        $this->assertCount(0, $datasetTable->datasetFields());

        $datasetTable->addDatasetField($this->createDatasetField());
        $this->assertCount(1, $datasetTable->datasetFields());
    }

    /** @test */
    public function render_empty_schema_is_ok()
    {
        $expectedTableName = 'user';
        $schema = DatasetTable::create($expectedTableName)->renderSchema();

        $this->assertStringContainsString('<xs:element name="' . $expectedTableName . '">', $schema);
        $this->assertStringContainsString('<xs:complexType>', $schema);
        $this->assertStringContainsString('<xs:sequence>', $schema);
        $this->assertStringContainsString('</xs:sequence>', $schema);
        $this->assertStringContainsString('</xs:complexType>', $schema);
        $this->assertStringContainsString('</xs:element>', $schema);
    }

    /** @test */
    public function render_empty_body_is_ok()
    {
        $expectedTableName = 'user';
        $body = DatasetTable::create($expectedTableName)->renderBody();

        $this->assertStringContainsString('<NOM_TABLE diffgr:id="' . $expectedTableName . '" msdata:rowOrder="0">', $body);
        $this->assertStringContainsString('</NOM_TABLE>', $body);
    }

    /** @test */
    public function render_schema_with_one_field_is_ok()
    {
        $expectedTableName = 'user';
        $datasetField = $this->createDatasetField();
        $schema = DatasetTable::create($expectedTableName)->addDatasetField($datasetField)->renderSchema();

        $this->assertStringContainsString('<xs:element name="' . $expectedTableName . '">', $schema);
        $this->assertStringContainsString('<xs:complexType>', $schema);
        $this->assertStringContainsString('<xs:sequence>', $schema);
        $this->assertStringContainsString('<xs:element name="' . $datasetField->fieldName() . '" type="' . $datasetField->fieldType() . '" minOccurs="' . $datasetField->fieldMinOccurs() . '"/>', $schema);
        $this->assertStringContainsString('</xs:sequence>', $schema);
        $this->assertStringContainsString('</xs:complexType>', $schema);
        $this->assertStringContainsString('</xs:element>', $schema);
    }

    /** @test */
    public function render_body_with_one_field_is_ok()
    {
        $expectedTableName = 'user';
        $datasetField = $this->createDatasetField();
        $body = DatasetTable::create($expectedTableName)->addDatasetField($datasetField)->renderBody();

        $this->assertStringContainsString('<NOM_TABLE diffgr:id="' . $expectedTableName . '" msdata:rowOrder="0">', $body);
        $this->assertStringContainsString('<' . $datasetField->fieldName() . '>' . $datasetField->fieldValue() . '</' . $datasetField->fieldName() . '>', $body);
        $this->assertStringContainsString('</NOM_TABLE>', $body);
    }

    /** @test */
    public function adding_something_else_should_fail()
    {
        $this->expectException(InvalidArgumentException::class);
        DatasetTable::create('foo')->addDatasetFields(['not a datasetField object']);
    }

    /** @test */
    public function add_many_datasets_is_ok()
    {
        $expectedTableName = 'user';
        $expectedDatasetFieldNumber = 5;
        $datasetFields = $this->createManyDatasetFields($expectedDatasetFieldNumber);

        /** check datafields */
        $datasetTable = DatasetTable::create($expectedTableName)->addDatasetFields($datasetFields);
        $this->assertCount($expectedDatasetFieldNumber, $datasetTable->datasetFields());

        /** check schema  */
        $schema = $datasetTable->renderSchema();
        $this->assertStringContainsString('<xs:element name="' . $expectedTableName . '">', $schema);
        $this->assertStringContainsString('<xs:complexType>', $schema);
        $this->assertStringContainsString('<xs:sequence>', $schema);
        array_map(function (DatasetField $datasetField) use ($schema) {
            $this->assertStringContainsString(
                '<xs:element name="' . $datasetField->fieldName() . '" type="' . $datasetField->fieldType() . '" minOccurs="' . $datasetField->fieldMinOccurs() . '"/>',
                $schema
            );
        }, $datasetFields);
        $this->assertStringContainsString('</xs:sequence>', $schema);
        $this->assertStringContainsString('</xs:complexType>', $schema);
        $this->assertStringContainsString('</xs:element>', $schema);
    }

    /** @test */
    public function render_body_with_many_fields_is_ok()
    {
        $expectedTableName = 'car';
        $expectedDatasetFieldNumber = 3;
        $datasetFields = $this->createManyDatasetFields($expectedDatasetFieldNumber);

        /** check datafields */
        $datasetTable = DatasetTable::create($expectedTableName)->addDatasetFields($datasetFields);
        $this->assertCount($expectedDatasetFieldNumber, $datasetTable->datasetFields());

        $body = $datasetTable->renderBody();
        $this->assertStringContainsString('<NOM_TABLE diffgr:id="' . $expectedTableName . '" msdata:rowOrder="0">', $body);
        array_map(function (DatasetField $datasetField) use ($body) {
            $this->assertStringContainsString(
                '<' . $datasetField->fieldName() . '>' . $datasetField->fieldValue() . '</' . $datasetField->fieldName() . '>',
                $body
            );
        }, $datasetFields);
        $this->assertStringContainsString('</NOM_TABLE>', $body);
    }
}
