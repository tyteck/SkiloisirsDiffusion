<?php

namespace SkiLoisirsDiffusion\Datasets;

use stdClass;

class ArticleDataset
{
    /** @var stdClass $dataset */
    protected $dataset;

    /** @var string $tablename */
    protected $tablename = 'article';

    private function __construct(array $attributes = [])
    {
        $this->code_article = $attributes['code_article'] ?? '';
        $this->quantite = $attributes['quantite'] ?? '';
        $this->articles_prix = $attributes['articles_prix'] ?? '';
        $this->code_parent = $attributes['code_parent'] ?? '';
        $this->acompte = $attributes['acompte'] ?? '';
        $this->subvention_montant = $attributes['subvention_montant'] ?? '';
        $this->subvention_payeur = $attributes['subvention_payeur'] ?? '';
        $this->remise = $attributes['remise'] ?? '';
        $this->nature_client_id = $attributes['nature_client_id'] ?? '';
        $this->categorie_place_code = $attributes['categorie_place_code'] ?? '';
        $this->libelle_article = $attributes['libelle_article'] ?? '';
        $this->famille_article = $attributes['famille_article'] ?? '';
        $this->skier_index = $attributes['skier_index'] ?? '';

        $this->dataset = new stdClass();
        $this->dataset->schema = '
<xs:element name="' . $this->tablename . '">
    <xs:complexType>
        <xs:sequence>
            <xs:element name="code_article" type="xs:string" minOccurs="0" />
            <xs:element name="quantite" type="xs:int" minOccurs="0" />
            <xs:element name="articles_prix" type="xs:decimal" minOccurs="0" />
            <xs:element name="code_parent" type="xs:string" minOccurs="0" />
            <xs:element name="acompte" type="xs:decimal" minOccurs="0" />
            <xs:element name="subvention_montant" type="xs:string" minOccurs="0" />
            <xs:element name="subvention_payeur" type="xs:string" minOccurs="0" />
            <xs:element name="remise" type="xs:decimal" minOccurs="0" />
            <xs:element name="nature_client_id" type="xs:string" minOccurs="0" />
            <xs:element name="categorie_place_code" type="xs:string" minOccurs="0" />
            <xs:element name="libelle_article" type="xs:string" minOccurs="0" />
            <xs:element name="famille_article" type="xs:string" minOccurs="0" />
            <xs:element name="skier_index" type="xs:int" minOccurs="0" />
        </xs:sequence>
    </xs:complexType>
</xs:element>
';

        $this->dataset->any = '
<' . $this->tablename . ' diffgr:id="' . $this->tablename . '1" msdata:rowOrder="0">
    <code_article>' . $this->code_article . '</code_article>
    <quantite>' . $this->quantite . '</quantite>
    <articles_prix>' . $this->articles_prix . '</articles_prix>
    <code_parent>' . $this->code_parent . '</code_parent>
    <acompte>' . $this->acompte . '</acompte>
    <subvention_montant>' . $this->subvention_montant . '</subvention_montant>
    <subvention_payeur>' . $this->subvention_payeur . '</subvention_payeur>
    <remise>' . $this->remise . '</remise>
    <nature_client_id>' . $this->nature_client_id . '</nature_client_id>
    <categorie_place_code>' . $this->categorie_place_code . '</categorie_place_code>
    <libelle_article>' . $this->libelle_article . '</libelle_article>
    <famille_article>' . $this->famille_article . '</famille_article>
    <skier_index>' . $this->skier_index . '</skier_index>
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

    public function dataset():stdClass
    {
        return $this->dataset;
    }
}
