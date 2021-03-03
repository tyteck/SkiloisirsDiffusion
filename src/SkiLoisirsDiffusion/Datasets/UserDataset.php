<?php

namespace SkiLoisirsDiffusion\Datasets;

use stdClass;

class UserDataset
{
    /** @var stdClass $dataset */
    protected $dataset;

    /** @var string $tablename */
    protected $tablename = 'utilisateur';

    private function __construct()
    {
        $this->dataset = new stdClass();
        $this->dataset->schema = '
<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns="" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata" id="NewDataSet">
    <xs:element name="NewDataSet" msdata:IsDataSet="true" msdata:UseCurrentLocale="true">
        <xs:complexType>
            <xs:choice minOccurs="0" maxOccurs="unbounded">
                <xs:element name="' . $this->tablename . '">
                    <xs:complexType>
                        <xs:sequence>
                            <xs:element name="id_partenaire" type="xs:string" minOccurs="0"/>
                            <xs:element name="utilisateurs_nom" type="xs:string" minOccurs="0"/>
                            <xs:element name="utilisateurs_prenom" type="xs:string" minOccurs="0"/>
                            <xs:element name="utilisateurs_telephone" type="xs:string" minOccurs="0"/>
                            <xs:element name="utilisateurs_portable" type="xs:string" minOccurs="0"/>
                            <xs:element name="utilisateurs_email" type="xs:string" minOccurs="0"/>
                            <xs:element name="utilisateurs_adresse1" type="xs:string" minOccurs="0"/>
                            <xs:element name="utilisateurs_codepostal" type="xs:string" minOccurs="0"/>
                            <xs:element name="utilisateurs_ville" type="xs:string" minOccurs="0"/>
                            <xs:element name="utilisateurs_pays" type="xs:string" minOccurs="0"/>
                            <xs:element name="utilisateurs_date_naissance" type="xs:dateTime" minOccurs="0"/>
                        </xs:sequence>
                    </xs:complexType>
                </xs:element>
            </xs:choice>
        </xs:complexType>
    </xs:element>
</xs:schema>
';

        $this->dataset->any = '
<diffgr:diffgram xmlns:diffgr="urn:schemas-microsoft-com:xml-diffgram-v1" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata">
    <NewDataSet xmlns="">
        <' . $this->tablename . ' diffgr:id="' . $this->tablename . '1" msdata:rowOrder="0">
            <id_partenaire><id_partenaire/>
            <utilisateurs_nom><utilisateurs_nom/>
            <utilisateurs_prenom><utilisateurs_prenom/>
            <utilisateurs_telephone><utilisateurs_telephone/>
            <utilisateurs_portable><utilisateurs_portable/>
            <utilisateurs_email><utilisateurs_email/>
            <utilisateurs_adresse1><utilisateurs_adresse1/>
            <utilisateurs_codepostal><utilisateurs_codepostal/>
            <utilisateurs_ville><utilisateurs_ville/>
            <utilisateurs_pays><utilisateurs_pays/>
            <utilisateurs_date_naissance><utilisateurs_date_naissance/>
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
