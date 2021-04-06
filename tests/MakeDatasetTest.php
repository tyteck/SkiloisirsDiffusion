<?php

namespace Skiloisirs\Tests;

use InvalidArgumentException;
use SkiLoisirsDiffusion\Datasets\MakeDataset;
use SkiLoisirsDiffusion\DatasetTables\CeDatasetTable;
use SkiLoisirsDiffusion\DatasetTables\EbilletDatasetTable;
use SkiLoisirsDiffusion\Datatypes\EbilletDatatype;
use SkiLoisirsDiffusion\Tests\BaseTestCase;
use SkiLoisirsDiffusion\Tests\Factory\EbilletFactory;
use stdClass;

class MakeDatasetTest extends BaseTestCase
{
    /** @test */
    public function schema_with_no_datatable_is_ok()
    {
        $dataset = MakeDataset::init()->render();

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
        $dataset = MakeDataset::init()->render();

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

        $dataset = MakeDataset::init()->addDatasetTable($datasetTable)->render();
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
<{$expectedDatasetTableName} diffgr:id="{$expectedDatasetTableName}1" msdata:rowOrder="0">
</{$expectedDatasetTableName}>
</NewDataSet>
</diffgr:diffgram>
EOT;
        $dataset = MakeDataset::init()->addDatasetTable($datasetTable)->render();
        $this->assertEquals($expectedBody, $dataset->body());
    }

    /** @test */
    public function schema_with_one_datatable_is_ok()
    {
        $expectedDatasetTableName = 'truck';
        $datasetTable = $this->createDatasetTable($expectedDatasetTableName, 4);
        $expectedDatasetFieldsSchemaString = $this->datasetFieldsToString($datasetTable->datasetFields(), true);
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

        $dataset = MakeDataset::init()->addDatasetTable($datasetTable)->render();
        $this->assertEquals($expectedSchema, $dataset->schema());
    }

    /** @test */
    public function body_with_one_datatable_is_ok()
    {
        $expectedDatasetTableName = 'truck';
        $datasetTable = $this->createDatasetTable($expectedDatasetTableName, 3);
        $expectedDatasetFieldsBodyString = $this->datasetFieldsToString($datasetTable->datasetFields(), false);
        $expectedBody = <<<EOT
<diffgr:diffgram xmlns:diffgr="urn:schemas-microsoft-com:xml-diffgram-v1" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata">
<NewDataSet xmlns="">
<{$expectedDatasetTableName} diffgr:id="{$expectedDatasetTableName}1" msdata:rowOrder="0">
{$expectedDatasetFieldsBodyString}
</{$expectedDatasetTableName}>
</NewDataSet>
</diffgr:diffgram>
EOT;
        $dataset = MakeDataset::init()->addDatasetTable($datasetTable)->render();
        $this->assertEquals($expectedBody, $dataset->body());
    }

    /** @test */
    public function adding_many_dataset_table_is_ok()
    {
        $expectedNumberOfDatasetTables = 8;
        $datasetTables = $this->createDatasetTables($expectedNumberOfDatasetTables);
        $dataset = MakeDataset::init()->addDatasetTables($datasetTables);
        $this->assertCount($expectedNumberOfDatasetTables, $dataset->datasetTables());
    }

    /** @test */
    public function adding_something_else_should_fail()
    {
        $datasetTables = $this->createDatasetTables(1);
        $datasetTables[] = ['Not a dataset table'];

        $this->expectException(InvalidArgumentException::class);
        MakeDataset::init()->addDatasetTables($datasetTables);
    }

    /** @test */
    public function schema_with_many_datatables_is_ok()
    {
        /** creating some dataset tables to add to whole dataset */
        $datasetTables = $this->createDatasetTables(3);

        /** transforming these as schema string I will include in expected schema */
        $expectedDatasetTableSchemaString = $this->datasetTablesToString($datasetTables);

        $expectedSchema = <<<EOT
<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns="" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata" id="NewDataSet">
<xs:element name="NewDataSet" msdata:IsDataSet="true" msdata:UseCurrentLocale="true">
<xs:complexType>
<xs:choice minOccurs="0" maxOccurs="unbounded">
{$expectedDatasetTableSchemaString}
</xs:choice>
</xs:complexType>
</xs:element>
</xs:schema>
EOT;

        $dataset = MakeDataset::init()->addDatasetTables($datasetTables)->render();
        $this->assertEquals($expectedSchema, $dataset->schema());
    }

    /** @test */
    public function body_with_many_datatables_is_ok()
    {
        /** creating some dataset tables to add to whole dataset */
        $datasetTables = $this->createDatasetTables(3);

        /** transforming these as schema string I will include in expected schema */
        $expectedDatasetTableBodyString = $this->datasetTablesToString($datasetTables, false);

        $expectedBody = <<<EOT
<diffgr:diffgram xmlns:diffgr="urn:schemas-microsoft-com:xml-diffgram-v1" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata">
<NewDataSet xmlns="">
{$expectedDatasetTableBodyString}
</NewDataSet>
</diffgr:diffgram>
EOT;
        $dataset = MakeDataset::init()->addDatasetTables($datasetTables)->render();
        $this->assertEquals($expectedBody, $dataset->body());
    }

    /** @test */
    public function whole_dataset_should_be_good()
    {
        /** creating some dataset tables to add to whole dataset */
        $datasetTables = $this->createDatasetTables(3);

        /** transforming these as schema string I will include in expected schema */
        $expectedDatasetTableSchemaString = $this->datasetTablesToString($datasetTables, true);

        $createdDataset = MakeDataset::init()->addDatasetTables($datasetTables)->render();
        $this->assertInstanceOf(stdClass::class, $createdDataset->dataset());
        $this->assertObjectHasAttribute('schema', $createdDataset->dataset());
        $this->assertObjectHasAttribute('any', $createdDataset->dataset());

        $expectedSchema = <<<EOT
<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns="" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata" id="NewDataSet">
<xs:element name="NewDataSet" msdata:IsDataSet="true" msdata:UseCurrentLocale="true">
<xs:complexType>
<xs:choice minOccurs="0" maxOccurs="unbounded">
{$expectedDatasetTableSchemaString}
</xs:choice>
</xs:complexType>
</xs:element>
</xs:schema>
EOT;

        $this->assertEquals($expectedSchema, $createdDataset->dataset()->schema);

        /** transforming these as schema string I will include in expected schema */
        $expectedDatasetTableBodyString = $this->datasetTablesToString($datasetTables, false);

        $expectedBody = <<<EOT
<diffgr:diffgram xmlns:diffgr="urn:schemas-microsoft-com:xml-diffgram-v1" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata">
<NewDataSet xmlns="">
{$expectedDatasetTableBodyString}
</NewDataSet>
</diffgr:diffgram>
EOT;

        $this->assertEquals($expectedBody, $createdDataset->dataset()->any);
    }

    /** @test */
    public function adding_ce_dataset_table_is_ok()
    {
        /** adding single datasetTable */
        $result = MakeDataset::init()->addDatasetTable(CeDatasetTable::prepare()->withConfig())->datasetTables();
        $this->assertIsArray($result);
        $this->assertEquals(1, count($result));

        /** adding many datasetTables */
        $result = MakeDataset::init()->addDatasetTables([CeDatasetTable::prepare()->withConfig()])->datasetTables();
        $this->assertIsArray($result);
        $this->assertEquals(1, count($result));
    }

    /** @test */
    public function foo()
    {
        $foo = ['chat', 'chien', 'chat', 'chat', 'poney'];
        $expected = 'chat1, chien1, chat2, chat3, poney1';
        $result = '';
        foreach ($foo as $key => $item) {
        }
        dump($result);
    }

    /** @test */
    public function adding_many_times_same_dataset_table_is_ok()
    {
        $ebillet1 = EbilletDatasetTable::prepare()
            ->with(EbilletDatatype::create(EbilletFactory::create()));
        $ebillet2 = EbilletDatasetTable::prepare()
            ->with(EbilletDatatype::create(EbilletFactory::create()));

        $expectedDatasetFieldsSchemaString = $this->datasetFieldsToString($ebillet1->datasetFields(), true);

        $dataset = MakeDataset::init()->addDatasetTables([$ebillet1, $ebillet2])->render();

        $expectedSchema = <<<EOT
<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns="" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata" id="NewDataSet">
<xs:element name="NewDataSet" msdata:IsDataSet="true" msdata:UseCurrentLocale="true">
<xs:complexType>
<xs:choice minOccurs="0" maxOccurs="unbounded">
<xs:element name="ebillet">
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

        $this->assertEquals($expectedSchema, $dataset->schema());

        $expectedDatasetTableBodyString = $this->datasetTablesToString([$ebillet1, $ebillet2], false);
        $expectedBody = <<<EOT
<diffgr:diffgram xmlns:diffgr="urn:schemas-microsoft-com:xml-diffgram-v1" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata">
<NewDataSet xmlns="">
{$expectedDatasetTableBodyString}
</NewDataSet>
</diffgr:diffgram>
EOT;
        $this->assertEquals($expectedBody, $dataset->body());
    }
}
