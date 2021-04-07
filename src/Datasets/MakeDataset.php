<?php

namespace SkiLoisirsDiffusion\Datasets;

use InvalidArgumentException;
use SkiLoisirsDiffusion\DatasetTables\DatasetTable;
use stdClass;

class MakeDataset
{
    /** @var stdClass $dataset */
    protected stdClass $dataset;

    /** @var array $datasetTables */
    protected array $datasetTables = [];

    /** @var int $rowOrder */
    protected int $rowOrder = 0;

    /**
     * @var array $knownTables
     * will record table and index. ['article'=>3, 'frais_gestion' => 1]
     */
    protected $knownTables = [];

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

    public function addDatasetTables(array $datasetTables = []): self
    {
        array_map(function ($datasetTable) {
            if (!(is_object($datasetTable) && is_a($datasetTable, DatasetTable::class))) {
                throw new InvalidArgumentException('addDatasetTables accept only array of datasetTable::class');
            }
            $this->addDatasetTable($datasetTable);
        }, $datasetTables);

        return $this;
    }

    /**
     * rendering dataset.
     * typically this function is to be called once all datasetTables have been added/removed.
     * it will generate the whole dataset whit schema and body.
     */
    public function render(): self
    {
        $this->renderSchema();
        $this->renderBody();
        return $this;
    }

    protected function renderSchema(): self
    {
        $this->dataset->schema = <<<EOT
<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns="" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata" id="NewDataSet">
<xs:element name="NewDataSet" msdata:IsDataSet="true" msdata:UseCurrentLocale="true">
<xs:complexType>
<xs:choice minOccurs="0" maxOccurs="unbounded">

EOT;
        $renderedSchemaTables = [];
        if (count($this->datasetTables)) {
            $this->dataset->schema .= array_reduce(
                $this->datasetTables,
                function ($carry, DatasetTable $datasetTable) use (&$renderedSchemaTables) {
                    if (in_array($datasetTable->tableName(), $renderedSchemaTables)) {
                        return $carry;
                    }
                    $renderedSchemaTables[] = $datasetTable->tableName();
                    if (strlen($carry)) {
                        $carry .= PHP_EOL;
                    }
                    return $carry .= $datasetTable->renderSchema();
                }
            ) . PHP_EOL;
        }
        $this->dataset->schema .= <<<EOT
</xs:choice>
</xs:complexType>
</xs:element>
</xs:schema>
EOT;
        return $this;
    }

    public function schema(): string
    {
        return $this->dataset->schema;
    }

    protected function renderBody(): string
    {
        $this->dataset->any = '<diffgr:diffgram xmlns:diffgr="urn:schemas-microsoft-com:xml-diffgram-v1" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata">' . PHP_EOL
        . '<NewDataSet xmlns="">' . PHP_EOL;
        if (count($this->datasetTables)) {
            $this->dataset->any .= array_reduce(
                $this->datasetTables,
                function ($carry, DatasetTable $datasetTable) use (&$index) {
                    if (strlen($carry)) {
                        $carry .= PHP_EOL;
                    }
                    /** this part to increment index. Index is the suffix in article1 (1 here) */
                    if (!isset($this->knownTables[$datasetTable->tableName()])) {
                        $this->knownTables[$datasetTable->tableName()] = 1;
                    } else {
                        $this->knownTables[$datasetTable->tableName()]++;
                    }
                    return $carry .= $datasetTable->renderBody(
                        $this->knownTables[$datasetTable->tableName()], // index
                        $this->rowOrder++ // order
                    );
                }
            ) . PHP_EOL;
        }
        return $this->dataset->any .= '</NewDataSet>' . PHP_EOL . '</diffgr:diffgram>';
    }

    /** alias for any */
    public function body(): string
    {
        return $this->any();
    }

    public function any(): string
    {
        return $this->dataset()->any;
    }

    public function dataset(): stdClass
    {
        return $this->dataset;
    }

    public function datasetTables(): array
    {
        return $this->datasetTables;
    }
}
