<?php

namespace SkiLoisirsDiffusion\Datasets;

use stdClass;

class MakeDataset
{
    /** @var stdClass $dataset */
    protected stdClass $dataset;

    /** @var array $datasetTables */
    protected array $datasetTables = [];

    private function __construct()
    {
        $this->dataset = new stdClass();
    }

    public static function init(...$params)
    {
        return new static(...$params);
    }

    public function addDatasetTable(DatasetTable $datasetTable): self
    {
        $this->datasetTables[] = $datasetTable;
        return $this;
    }

    public function schema()
    {
        $schema = '<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns="" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata" id="NewDataSet">' . PHP_EOL .
            '<xs:element name="NewDataSet" msdata:IsDataSet="true" msdata:UseCurrentLocale="true">' . PHP_EOL .
            '<xs:complexType>' . PHP_EOL .
            '<xs:choice minOccurs="0" maxOccurs="unbounded">' . PHP_EOL;
        if (count($this->datasetTables)) {
            $schema .= array_reduce(
                $this->datasetTables,
                function ($carry, DatasetTable $datasetTable) {
                    if (strlen($carry)) {
                        $carry .= PHP_EOL;
                    }
                    return $carry .= $datasetTable->renderSchema();
                }
            ) . PHP_EOL;
        }
        $schema .= '</xs:choice>' . PHP_EOL . '</xs:complexType>' . PHP_EOL . '</xs:element>' . PHP_EOL . '</xs:schema>';
        return  $schema;
    }

    public function body()
    {
        $body = '<diffgr:diffgram xmlns:diffgr="urn:schemas-microsoft-com:xml-diffgram-v1" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata">' . PHP_EOL
        . '<NewDataSet xmlns="">' . PHP_EOL;
        if (count($this->datasetTables)) {
            $body .= array_reduce(
                $this->datasetTables,
                function ($carry, DatasetTable $datasetTable) {
                    if (strlen($carry)) {
                        $carry .= PHP_EOL;
                    }
                    return $carry .= $datasetTable->renderBody();
                }
            ) . PHP_EOL;
        }
        return $body .= '</NewDataSet>' . PHP_EOL . '</diffgr:diffgram>';
    }

    public function dataset()
    {
        return $this->dataset;
    }
}
