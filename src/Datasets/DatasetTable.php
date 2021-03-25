<?php

namespace SkiLoisirsDiffusion\Datasets;

use InvalidArgumentException;
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

    public static function create(string $tableName)
    {
        return new static($tableName);
    }

    public function renderSchema(): string
    {
        $schema = '<xs:element name="' . $this->tableName . '">' . PHP_EOL . '<xs:complexType>' . PHP_EOL . '<xs:sequence>' . PHP_EOL;
        if (count($this->datasetFields)) {
            $schema .= array_reduce(
                $this->datasetFields,
                function ($carry, DatasetField $datasetField) {
                    if (strlen($carry)) {
                        $carry .= PHP_EOL;
                    }
                    return $carry .= $datasetField->renderSchema();
                }
            ) . PHP_EOL;
        }
        $schema .= '</xs:sequence>' . PHP_EOL . '</xs:complexType>' . PHP_EOL . '</xs:element>';
        return $schema;
    }

    public function renderBody(?int $rowOrder = 0): string
    {
        $body = '<' . $this->tableName . ' diffgr:id="' . $this->tableName . '1" msdata:rowOrder="' . $rowOrder . '">' . PHP_EOL;
        if (count($this->datasetFields)) {
            $body .= array_reduce(
                $this->datasetFields,
                function ($carry, DatasetField $datasetField) {
                    if (strlen($carry)) {
                        $carry .= PHP_EOL;
                    }
                    return $carry .= $datasetField->renderBody();
                }
            ) . PHP_EOL;
        }
        $body .= '</' . $this->tableName . '>';
        return  $body;
    }

    public function addDatasetField(DatasetField $datasetField)
    {
        $this->datasetFields[] = $datasetField;
        return $this;
    }

    public function datasetFields(): array
    {
        return $this->datasetFields;
    }

    public function addDatasetFields(array $datasetFields)
    {
        array_map(function ($datasetField) {
            if (!(is_object($datasetField) && get_class($datasetField) == 'SkiLoisirsDiffusion\Datasets\DatasetField')) {
                throw new InvalidArgumentException('addDatasetFields accept only array of datasetField::class');
            }
            $this->addDatasetField($datasetField);
        }, $datasetFields);

        return $this;
    }
}
