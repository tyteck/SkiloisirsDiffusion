<?php

namespace SkiLoisirsDiffusion\Datasets;

use stdClass;

class CreateOrderDataset
{
    /** @var stdClass $dataset */
    protected $dataset;

    /** @var \SkiLoisirsDiffusion\Datasets\CEDataset */
    protected $ceDataset;

    /** @var \SkiLoisirsDiffusion\Datasets\UserDataset */
    protected $userDataset;

    /** @var \SkiLoisirsDiffusion\Datasets\OrderDataset */
    protected $orderDataset;

    private function __construct(CEDataset $ceDataset, UserDataset $userDataset, OrderDataset $orderDataset)
    {
        $this->ceDataset = $ceDataset;
        $this->userDataset = $userDataset;
        $this->orderDataset = $orderDataset;

        $this->dataset = new stdClass();

        $this->dataset->schema = '
<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns="" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata" id="NewDataSet">
    <xs:element name="NewDataSet" msdata:IsDataSet="true" msdata:UseCurrentLocale="true">
        <xs:complexType>
            <xs:sequence minOccurs="0" maxOccurs="unbounded">
                ' . $this->ceDataset->schema() . '
                ' . $this->userDataset->schema() . '
                ' . $this->orderDataset->schema() . '
            </xs:sequence>
        </xs:complexType>
    </xs:element>
</xs:schema>
';

        $this->dataset->any = '
<diffgr:diffgram xmlns:diffgr="urn:schemas-microsoft-com:xml-diffgram-v1" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata">
    <NewDataSet xmlns="">
    ' . $this->ceDataset->body() . '
    ' . $this->userDataset->body() . '
    ' . $this->orderDataset->body() . '
    </NewDataSet>
</diffgr:diffgram>
';
    }

    public static function create(...$params)
    {
        return new static(...$params);
    }

    public function schema()
    {
        return $this->dataset->schema;
    }

    public function body()
    {
        return $this->dataset->any;
    }
}
