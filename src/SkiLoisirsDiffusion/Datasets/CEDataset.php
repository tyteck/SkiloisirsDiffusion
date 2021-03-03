<?php

namespace SkiLoisirsDiffusion\Datasets;

use stdClass;

class CEDataset
{
    /** @var stdClass $dataset */
    protected $dataset;

    /** @var string $tablename */
    protected $tablename = 'ce';

    private function __construct()
    {
        $this->dataset = new stdClass();
        $this->dataset->schema = <<<EOT
<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns="" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata" id="NewDataSet">
    <xs:element name="NewDataSet" msdata:IsDataSet="true" msdata:UseCurrentLocale="true">
        <xs:complexType>
            <xs:choice minOccurs="0" maxOccurs="unbounded">
                <xs:element name="' . $this->tablename . '">
                    <xs:complexType>
                        <xs:sequence>
                            <xs:element name="ce_id" type="xs:string" minOccurs="0"/>
                            <xs:element name="ce_societe" type="xs:string" minOccurs="0"/>
                            <xs:element name="ce_nom" type="xs:string" minOccurs="0"/>
                            <xs:element name="ce_prenom" type="xs:string" minOccurs="0"/>
                            <xs:element name="ce_email" type="xs:string" minOccurs="0"/>
                            <xs:element name="ce_codepostal" type="xs:string" minOccurs="0"/>
                            <xs:element name="ce_ville" type="xs:string" minOccurs="0"/>
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
        <' . $this->tablename . ' diffgr:id="' . $this->tablename . '1" msdata:rowOrder="0">
            <ce_id>' . sldconfig('ce_id') . '</ce_id>
            <ce_societe>' . sldconfig('ce_societe') . '</ce_societe>
            <ce_nom>' . sldconfig('ce_nom') . '</ce_nom>
            <ce_prenom>' . sldconfig('ce_prenom') . '</ce_prenom>
            <ce_email>' . sldconfig('ce_email') . '</ce_email>
            <ce_codepostal>' . sldconfig('ce_codepostal') . '</ce_codepostal>
            <ce_ville>' . sldconfig('ce_ville') . '</ce_ville>
        </' . $this->tablename . '>
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
