<?php

namespace SkiLoisirsDiffusion\Datasets;

use SkiLoisirsDiffusion\Exceptions\TableNameShouldNotBeEmptyException;

class DatasetTable
{
    /** @var string $fieldName */
    protected $tableName;

    /** @var array $datasetFields */
    protected $datasetFields = [];

    private function __construct(string $tableName)
    {
        if (!strlen($tableName)) {
            throw new TableNameShouldNotBeEmptyException('Table name should not be empty');
        }
        $this->tableName = $tableName;
    }

    public static function create(...$params)
    {
        return new static(...$params);
    }

    public function renderSchema()
    {
        $schema = '<xs:element name="' . $this->tableName . '">' . PHP_EOL . '<xs:complexType>' . PHP_EOL . '<xs:sequence>' . PHP_EOL;
        $schema .= array_reduce(
            $this->fields,
            function ($carry, DatasetField $datasetField) {
                if (strlen($carry)) {
                    $carry .= PHP_EOL;
                }
                return $carry .= $datasetField->renderSchema();
            }
        );
        $schema .= PHP_EOL . '</xs:sequence>' . PHP_EOL . '</xs:complexType>' . PHP_EOL . '</xs:element>';
    }

    public function renderBody()
    {
        $body = '<' . $this->tablename . ' diffgr:id="' . $this->tablename . '1" msdata:rowOrder="0">';
        $body .= array_reduce(
            $this->fields,
            function ($carry, DatasetField $datasetField) {
                if (strlen($carry)) {
                    $carry .= PHP_EOL;
                }
                return $carry .= $datasetField->renderBody();
            }
        );
        $body .= '</tablename>';
        return  $body;
    }

    public function addDatasetField(DatasetField $datasetField)
    {
        $this->datasetFields[] = $datasetField;
    }
}
