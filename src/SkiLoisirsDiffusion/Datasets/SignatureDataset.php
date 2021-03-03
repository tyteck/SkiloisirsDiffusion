<?php

namespace SkiLoisirsDiffusion;

use stdClass;

class SignatureDataset
{
    /** @var stdClass $dataset */
    protected $dataset;

    private function __construct()
    {
        throw new NotImplentedException
        $this->dataset = new stdClass();
        
        $this->dataset->schema = <<<EOT
<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns="" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata" id="NewDataSet">
    <xs:element name="NewDataSet" msdata:IsDataSet="true" msdata:UseCurrentLocale="true">
        <xs:complexType>
            <xs:choice minOccurs="0" maxOccurs="unbounded">
                <xs:element name="SIGNATURE">
                    <xs:complexType>
                        <xs:sequence>
                            <xs:element name="signature" type="xs:string" minOccurs="1"/>
                        </xs:sequence>
                    </xs:complexType>
                </xs:element>
            </xs:choice>
        </xs:complexType>
    </xs:element>
</xs:schema>
EOT;

        $this->dataset->any = '
<diffgr:diffgram xmlns:diffgr="urn:schemas-microsoft-com:xml-diffgram-v1" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata">
    <NewDataSet xmlns="">
        <SIGNATURE diffgr:id="SIGNATURE1" msdata:rowOrder="0">
            <signature>' . sldconfig('ce_id') . '</signature>
        </SIGNATURE>
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
