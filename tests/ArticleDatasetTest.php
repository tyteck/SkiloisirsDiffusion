<?php

namespace SkiLoisirsDiffusion\Tests;

use SkiLoisirsDiffusion\DatasetTables\ArticleDatasetTable;
use SkiLoisirsDiffusion\Datatypes\ArticleDatatype;
use SkiLoisirsDiffusion\Tests\Factory\ArticleFactory;

class ArticleDatasetTest extends BaseTestCase
{
    /** @var \SkiLoisirsDiffusion\Datatypes\ArticleDatatype $article */
    protected $article;

    public function setUp() :void
    {
        parent::setUp();
        $this->article = ArticleDatatype::create(ArticleFactory::create());

        $this->articleDatasetTable = ArticleDatasetTable::prepare()->with($this->article);
    }

    /** @test */
    public function article_dataset_schema_is_ok()
    {
        $expectedSchema = <<<EOT
<xs:element name="article">
<xs:complexType>
<xs:sequence>
<xs:element name="code_article" type="xs:string" minOccurs="0"/>
<xs:element name="quantite" type="xs:int" minOccurs="0"/>
<xs:element name="articles_prix" type="xs:decimal" minOccurs="0"/>
<xs:element name="code_parent" type="xs:string" minOccurs="0"/>
<xs:element name="acompte" type="xs:decimal" minOccurs="0"/>
<xs:element name="subvention_montant" type="xs:string" minOccurs="0"/>
<xs:element name="subvention_payeur" type="xs:string" minOccurs="0"/>
<xs:element name="remise" type="xs:decimal" minOccurs="0"/>
<xs:element name="nature_client_id" type="xs:string" minOccurs="0"/>
<xs:element name="categorie_place_code" type="xs:string" minOccurs="0"/>
<xs:element name="libelle_article" type="xs:string" minOccurs="0"/>
<xs:element name="famille_article" type="xs:string" minOccurs="0"/>
<xs:element name="skier_index" type="xs:int" minOccurs="0"/>
</xs:sequence>
</xs:complexType>
</xs:element>
EOT;
        $this->assertEquals($expectedSchema, $this->articleDatasetTable->renderSchema());
    }

    /** @test */
    public function article_dataset_body_is_ok()
    {
        $expectedBody = <<<EOT
<article diffgr:id="article1" msdata:rowOrder="0">
<code_article>{$this->article->code_article}</code_article>
<quantite>{$this->article->quantite}</quantite>
<articles_prix>{$this->article->articles_prix}</articles_prix>
<code_parent>{$this->article->code_parent}</code_parent>
<acompte>{$this->article->acompte}</acompte>
<subvention_montant>{$this->article->subvention_montant}</subvention_montant>
<subvention_payeur>{$this->article->subvention_payeur}</subvention_payeur>
<remise>{$this->article->remise}</remise>
<nature_client_id>{$this->article->nature_client_id}</nature_client_id>
<categorie_place_code>{$this->article->categorie_place_code}</categorie_place_code>
<libelle_article>{$this->article->libelle_article}</libelle_article>
<famille_article>{$this->article->famille_article}</famille_article>
<skier_index>{$this->article->skier_index}</skier_index>
</article>
EOT;
        $this->assertEquals($expectedBody, $this->articleDatasetTable->renderBody());
    }
}
