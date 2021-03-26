<?php

namespace Skiloisirs\Tests;

use InvalidArgumentException;
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

        $expectedSchema = <<<EOT
<xs:element name="$expectedTableName">
<xs:complexType>
<xs:sequence>
</xs:sequence>
</xs:complexType>
</xs:element>
EOT;
        $this->assertEquals($expectedSchema, $schema = DatasetTable::create($expectedTableName)->renderSchema());
    }

    /** @test */
    public function render_empty_body_is_ok()
    {
        $expectedTableName = 'user';
        $expectedBody = <<<EOT
<{$expectedTableName} diffgr:id="{$expectedTableName}1" msdata:rowOrder="0">
</{$expectedTableName}>
EOT;

        $this->assertEquals($expectedBody, DatasetTable::create($expectedTableName)->renderBody());
    }

    /** @test */
    public function render_schema_with_one_field_is_ok()
    {
        $expectedTableName = 'user';
        $datasetField = $this->createDatasetField();
        $expectedSchema = <<<EOT
<xs:element name="$expectedTableName">
<xs:complexType>
<xs:sequence>
<xs:element name="{$datasetField->fieldName()}" type="{$datasetField->fieldType()}" minOccurs="{$datasetField->fieldMinOccurs()}"/>
</xs:sequence>
</xs:complexType>
</xs:element>
EOT;
        $this->assertEquals($expectedSchema, DatasetTable::create($expectedTableName)->addDatasetField($datasetField)->renderSchema());
    }

    /** @test */
    public function render_body_with_one_field_is_ok()
    {
        $expectedTableName = 'user';
        $datasetField = $this->createDatasetField();

        $expectedBody = <<<EOT
<{$expectedTableName} diffgr:id="{$expectedTableName}1" msdata:rowOrder="0">
<{$datasetField->fieldName()}>{$datasetField->fieldValue()}</{$datasetField->fieldName()}>
</{$expectedTableName}>
EOT;
        $this->assertEquals($expectedBody, DatasetTable::create($expectedTableName)->addDatasetField($datasetField)->renderBody());
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

        $expectedSchema = <<<EOT
<xs:element name="$expectedTableName">
<xs:complexType>
<xs:sequence>
{$this->datasetFieldsToString($datasetFields, true)}
</xs:sequence>
</xs:complexType>
</xs:element>
EOT;

        /** check schema  */
        $this->assertEquals($expectedSchema, $datasetTable->renderSchema());
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

        $expectedBody = <<<EOT
<{$expectedTableName} diffgr:id="{$expectedTableName}1" msdata:rowOrder="0">
{$this->datasetFieldsToString($datasetFields, false)}
</{$expectedTableName}>
EOT;
        $this->assertEquals($expectedBody, $datasetTable->renderBody());
    }
}
