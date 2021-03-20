<?php

namespace Skiloisirs\Tests;

use SkiLoisirsDiffusion\Datasets\MakeDataset;
use SkiLoisirsDiffusion\Tests\BaseTestCase;

class MakeDatasetTest extends BaseTestCase
{
    /** @test */
    public function schema_with_no_datatable_is_ok()
    {
        $dataset = MakeDataset::init();

        $expectedSchema = <<<EOT
<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns="" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata" id="NewDataSet">
<xs:element name="NewDataSet" msdata:IsDataSet="true" msdata:UseCurrentLocale="true">
<xs:complexType>
<xs:choice minOccurs="0" maxOccurs="unbounded">
</xs:choice>
</xs:complexType>
</xs:element>
</xs:schema>
EOT;
        $this->assertEquals($expectedSchema, $dataset->schema());
    }

    /** @test */
    public function body_with_no_datatable_is_ok()
    {
        $dataset = MakeDataset::init();

        $expectedBody = <<<EOT
<diffgr:diffgram xmlns:diffgr="urn:schemas-microsoft-com:xml-diffgram-v1" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata">
<NewDataSet xmlns="">
</NewDataSet>
</diffgr:diffgram>
EOT;
        $this->assertEquals($expectedBody, $dataset->body());
    }

    /** @test */
    public function schema_with_empty_datatable_is_ok()
    {
        $expectedDatasetTableName = 'truck';
        $datasetTable = $this->createDatasetTable($expectedDatasetTableName, 0);
        $expectedSchema = <<<EOT
<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns="" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata" id="NewDataSet">
<xs:element name="NewDataSet" msdata:IsDataSet="true" msdata:UseCurrentLocale="true">
<xs:complexType>
<xs:choice minOccurs="0" maxOccurs="unbounded">
<xs:element name="$expectedDatasetTableName">
<xs:complexType>
<xs:sequence>
</xs:sequence>
</xs:complexType>
</xs:element>
</xs:choice>
</xs:complexType>
</xs:element>
</xs:schema>
EOT;

        $dataset = MakeDataset::init()->addDatasetTable($datasetTable);
        $this->assertEquals($expectedSchema, $dataset->schema());
    }

    /** @test */
    public function body_with_empty_datatable_is_ok()
    {
        $expectedDatasetTableName = 'truck';
        $datasetTable = $this->createDatasetTable($expectedDatasetTableName, 0);

        $expectedBody = <<<EOT
<diffgr:diffgram xmlns:diffgr="urn:schemas-microsoft-com:xml-diffgram-v1" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata">
<NewDataSet xmlns="">
<NOM_TABLE diffgr:id="{$expectedDatasetTableName}" msdata:rowOrder="0">
</NOM_TABLE>
</NewDataSet>
</diffgr:diffgram>
EOT;
        $dataset = MakeDataset::init()->addDatasetTable($datasetTable);
        $this->assertEquals($expectedBody, $dataset->body());
    }

    /** @test */
    public function schema_with_one_datatable_is_ok()
    {
        $expectedDatasetTableName = 'truck';
        $datasetTable = $this->createDatasetTable($expectedDatasetTableName, 4);
        $expectedDatasetFieldsSchemaString = $this->datasetFieldsSchemaToString($datasetTable->datasetFields());
        $expectedSchema = <<<EOT
<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns="" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata" id="NewDataSet">
<xs:element name="NewDataSet" msdata:IsDataSet="true" msdata:UseCurrentLocale="true">
<xs:complexType>
<xs:choice minOccurs="0" maxOccurs="unbounded">
<xs:element name="$expectedDatasetTableName">
<xs:complexType>
<xs:sequence>
{$expectedDatasetFieldsSchemaString}
</xs:sequence>
</xs:complexType>
</xs:element>
</xs:choice>
</xs:complexType>
</xs:element>
</xs:schema>
EOT;

        $dataset = MakeDataset::init()->addDatasetTable($datasetTable);
        $this->assertEquals($expectedSchema, $dataset->schema());
    }

    /** @test */
    public function body_with_one_datatable_is_ok()
    {
        $expectedDatasetTableName = 'truck';
        $datasetTable = $this->createDatasetTable($expectedDatasetTableName, 3);
        $expectedDatasetFieldsBodyString = $this->datasetFieldsBodyToString($datasetTable->datasetFields());
        $expectedBody = <<<EOT
<diffgr:diffgram xmlns:diffgr="urn:schemas-microsoft-com:xml-diffgram-v1" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata">
<NewDataSet xmlns="">
<NOM_TABLE diffgr:id="{$expectedDatasetTableName}" msdata:rowOrder="0">
{$expectedDatasetFieldsBodyString}
</NOM_TABLE>
</NewDataSet>
</diffgr:diffgram>
EOT;
        $dataset = MakeDataset::init()->addDatasetTable($datasetTable);
        $this->assertEquals($expectedBody, $dataset->body());
    }

    /** @test */
    public function schema_with_many_datatables_is_ok()
    {
        $datasetTables = $this->createDatasetTables(3);

        $expectedDatasetTableSchemaString = $this->datasetTablesToSchemaString($datasetTables);
        $expectedSchema = <<<EOT
<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns="" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata" id="NewDataSet">
<xs:element name="NewDataSet" msdata:IsDataSet="true" msdata:UseCurrentLocale="true">
<xs:complexType>
<xs:choice minOccurs="0" maxOccurs="unbounded">
<xs:element name="$expectedDatasetTableName">
<xs:complexType>
<xs:sequence>
{$expectedDatasetFieldsSchemaString}
</xs:sequence>
</xs:complexType>
</xs:element>
</xs:choice>
</xs:complexType>
</xs:element>
</xs:schema>
EOT;

        $dataset = MakeDataset::init()->addDatasetTable($datasetTable);
        $this->assertEquals($expectedSchema, $dataset->schema());
    }

    /** @test */
    public function body_with_many_datatables_is_ok()
    {
        $this->markTestIncomplete('TO BE DONE');
    }
}
