<?php

namespace SkiLoisirsDiffusion\Datasets;

use InvalidArgumentException;
use stdClass;

class MakeDataset
{
    /** @var stdClass $dataset */
    protected stdClass $dataset;

    /** @var array $datasetTables */
    protected array $datasetTables = [];

    /** @var int $rowOrder */
    protected int $rowOrder = 0;

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

    public function addDatasetTables(array $datasetTables = [])
    {
        array_map(function ($datasetTable) {
            if (!(is_object($datasetTable) && get_class($datasetTable) == 'SkiLoisirsDiffusion\Datasets\DatasetTable')) {
                throw new InvalidArgumentException('addDatasetTables accept only array of datasetTable::class');
            }
            $this->addDatasetTable($datasetTable);
        }, $datasetTables);

        return $this;
    }

    public function render()
    {
        $this->renderSchema();
        $this->renderBody();
        return $this;
    }

    protected function renderSchema()
    {
        $this->dataset->schema = '<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns="" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata" id="NewDataSet">' . PHP_EOL .
            '<xs:element name="NewDataSet" msdata:IsDataSet="true" msdata:UseCurrentLocale="true">' . PHP_EOL .
            '<xs:complexType>' . PHP_EOL .
            '<xs:choice minOccurs="0" maxOccurs="unbounded">' . PHP_EOL;
        if (count($this->datasetTables)) {
            $this->dataset->schema .= array_reduce(
                $this->datasetTables,
                function ($carry, DatasetTable $datasetTable) {
                    if (strlen($carry)) {
                        $carry .= PHP_EOL;
                    }
                    return $carry .= $datasetTable->renderSchema();
                }
            ) . PHP_EOL;
        }
        $this->dataset->schema .= '</xs:choice>' . PHP_EOL . '</xs:complexType>' . PHP_EOL . '</xs:element>' . PHP_EOL . '</xs:schema>';
        return $this;
    }

    public function schema()
    {
        return $this->dataset->schema;
    }

    protected function renderBody()
    {
        $this->dataset->any = '<diffgr:diffgram xmlns:diffgr="urn:schemas-microsoft-com:xml-diffgram-v1" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata">' . PHP_EOL
        . '<NewDataSet xmlns="">' . PHP_EOL;
        if (count($this->datasetTables)) {
            $this->dataset->any .= array_reduce(
                $this->datasetTables,
                function ($carry, DatasetTable $datasetTable) {
                    if (strlen($carry)) {
                        $carry .= PHP_EOL;
                    }
                    return $carry .= $datasetTable->renderBody($this->rowOrder++);
                }
            ) . PHP_EOL;
        }
        return $this->dataset->any .= '</NewDataSet>' . PHP_EOL . '</diffgr:diffgram>';
    }

    /** alias for any */
    public function body()
    {
        return $this->any();
    }

    public function any()
    {
        return $this->dataset()->any;
    }

    public function dataset()
    {
        return $this->dataset;
    }

    public function datasetTables()
    {
        return $this->datasetTables;
    }
}
