<?php

namespace SkiLoisirsDiffusion\Datasets;

use SkiLoisirsDiffusion\Interfaces\Dataset;
use stdClass;

class CreateOrderDataset implements Dataset
{
    /** @var stdClass $dataset */
    protected $dataset;

    /** @var \SkiLoisirsDiffusion\Datasets\CEDataset */
    protected $ceDataset;

    /** @var \SkiLoisirsDiffusion\Datasets\UserDataset */
    protected $userDataset;

    /** @var \SkiLoisirsDiffusion\Datasets\OrderDataset */
    protected $orderDataset;

    /** @var \SkiLoisirsDiffusion\Datasets\SignatureDataset */
    protected $signatureDataset;

    private function __construct(UserDataset $userDataset, OrderDataset $orderDataset, SignatureDataset $signatureDataset)
    {
        $this->ceDataset = CeDatasetTable::create();
        $this->userDataset = $userDataset;
        $this->orderDataset = $orderDataset;
        $this->signatureDataset = $signatureDataset;

        $this->dataset = new stdClass();

        $this->dataset->schema = '
<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns="" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata" id="NewDataSet">
    <xs:element name="NewDataSet" msdata:IsDataSet="true" msdata:UseCurrentLocale="true">
        <xs:complexType>
            <xs:sequence minOccurs="0" maxOccurs="unbounded">
                ' . $this->ceDataset->schema() . '
                ' . $this->userDataset->schema() . '
                ' . $this->orderDataset->schema() . '
                ' . $this->signatureDataset->schema() . '
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
    ' . $this->signatureDataset->body() . '
    </NewDataSet>
</diffgr:diffgram>
';
    }

    public static function create(...$params)
    {
        return new static(...$params);
    }

    public function schema():string
    {
        return $this->dataset->schema;
    }

    public function body():string
    {
        return $this->dataset->any;
    }

    public function dataset():stdClass
    {
        return $this->dataset;
    }
}
