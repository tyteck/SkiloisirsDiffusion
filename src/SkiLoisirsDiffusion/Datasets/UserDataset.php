<?php

namespace SkiLoisirsDiffusion\Datasets;

use stdClass;

class UserDataset
{
    /** @var stdClass $dataset */
    protected $dataset;

    /** @var string $tablename */
    protected $tablename = 'utilisateur';

    private function __construct(array $attributes = [])
    {
        $this->id_partenaire = $attributes['id_partenaire'] ?? '';
        $this->utilisateurs_nom = $attributes['utilisateurs_nom'] ?? '';
        $this->utilisateurs_prenom = $attributes['utilisateurs_prenom'] ?? '';
        $this->utilisateurs_telephone = $attributes['utilisateurs_telephone'] ?? '';
        $this->utilisateurs_portable = $attributes['utilisateurs_portable'] ?? '';
        $this->utilisateurs_email = $attributes['utilisateurs_email'] ?? '';
        $this->utilisateurs_adresse1 = $attributes['utilisateurs_adresse1'] ?? '';
        $this->utilisateurs_codepostal = $attributes['utilisateurs_codepostal'] ?? '';
        $this->utilisateurs_ville = $attributes['utilisateurs_ville'] ?? '';
        $this->utilisateurs_pays = $attributes['utilisateurs_pays'] ?? '';
        $this->utilisateurs_date_naissance = $attributes['utilisateurs_date_naissance'] ?? '';

        $this->dataset = new stdClass();
        $this->dataset->schema = '
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
';

        $this->dataset->any = '
<' . $this->tablename . ' diffgr:id="' . $this->tablename . '1" msdata:rowOrder="0">
    <id_partenaire>' . $this->id_partenaire . '</id_partenaire>
    <utilisateurs_nom>' . $this->utilisateurs_nom . '</utilisateurs_nom>
    <utilisateurs_prenom>' . $this->utilisateurs_prenom . '</utilisateurs_prenom>
    <utilisateurs_telephone>' . $this->utilisateurs_telephone . '</utilisateurs_telephone>
    <utilisateurs_portable>' . $this->utilisateurs_portable . '</utilisateurs_portable>
    <utilisateurs_email>' . $this->utilisateurs_email . '</utilisateurs_email>
    <utilisateurs_adresse1>' . $this->utilisateurs_adresse1 . '</utilisateurs_adresse1>
    <utilisateurs_codepostal>' . $this->utilisateurs_codepostal . '</utilisateurs_codepostal>
    <utilisateurs_ville>' . $this->utilisateurs_ville . '</utilisateurs_ville>
    <utilisateurs_pays>' . $this->utilisateurs_pays . '</utilisateurs_pays>
    <utilisateurs_date_naissance>' . $this->utilisateurs_date_naissance . '</utilisateurs_date_naissance>
</' . $this->tablename . '>
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
