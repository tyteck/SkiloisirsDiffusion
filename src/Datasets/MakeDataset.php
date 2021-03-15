<?php

namespace SkiLoisirsDiffusion\Datasets;

use stdClass;

class MakeDataset
{
    /** @var stdClass $dataset */
    protected stdClass $dataset;

    /** @var array $fields */
    protected array $fields = [];

    /** @var string $tableName */
    protected string $tableName;

    private function __construct(string $tableName)
    {
        $this->tableName = $tableName;
        $this->dataset = new stdClass();
    }

    public static function init(...$params)
    {
        return new static(...$params);
    }

    public function addField(DatasetField $field): self
    {
        $this->fields[] = $field;
        return $this;
    }

    public function schema()
    {
        $schema = '
<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns="" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata" id="NewDataSet">
    <xs:element name="NewDataSet" msdata:IsDataSet="true" msdata:UseCurrentLocale="true">
        <xs:complexType>
            <xs:choice minOccurs="0" maxOccurs="unbounded">
                <xs:element name="' . $this->tableName . '">
                    <xs:complexType>
                        <xs:sequence>' . PHP_EOL;
        $schema .= array_reduce(
            $this->fields,
            function ($carry, DatasetField $datasetField) {
                if (strlen($carry)) {
                    $carry .= PHP_EOL;
                }
                return $carry .= $datasetField->renderSchema();
            }
        );

        $schema .= '   
                        </xs:sequence>
                    </xs:complexType>
                </xs:element>
            </xs:choice>
        </xs:complexType>
    </xs:element>
</xs:schema>';
        return  $schema;
    }

    public function body()
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

    public function dataset()
    {
        return $this->dataset;
    }
}
