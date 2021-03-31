<?php

namespace SkiLoisirsDiffusion\Tests;

use SkiLoisirsDiffusion\Datasets\DatasetField;
use SkiLoisirsDiffusion\Datasets\DatasetTable;
use SkiLoisirsDiffusion\Tests\Factory\ArticleFactory;

class ArticleDatasetTest extends BaseTestCase
{
    public function setUp() :void
    {
        parent::setUp();
        $this->article = ArticleFactory::create();
        $this->articleDatasetTable = DatasetTable::create('article')
            ->addDatasetFields(
                [
                    DatasetField::create('code_article', 'string', $this->article['code_article']),
                    DatasetField::create('quantite', 'int32', $this->article['quantite']),
                    DatasetField::create('articles_prix', 'decimal', $this->article['articles_prix']),
                    DatasetField::create('code_parent', 'string', $this->article['code_parent'], 0, false),
                    DatasetField::create('acompte', 'decimal', $this->article['acompte'], 0, false),
                    DatasetField::create('subvention_montant', 'string', $this->article['subvention_montant'], 0, false),
                    DatasetField::create('subvention_payeur', 'string', $this->article['subvention_payeur']),
                    DatasetField::create('remise', 'decimal', $this->article['remise']),
                    DatasetField::create('nature_client_id', 'string', $this->article['nature_client_id']),
                    DatasetField::create('categorie_place_code', 'string', $this->article['categorie_place_code']),
                    DatasetField::create('libelle_article', 'string', $this->article['libelle_article'], 0, false),
                    DatasetField::create('famille_article', 'string', $this->article['famille_article'], 0, false),
                    DatasetField::create('skier_index', 'int32', $this->article['skier_index']),
                ]
            );
    }

    /** @test */
    public function article_dataset_schema_is_ok()
    {
        $expectedSchema = <<<EOT
<xs:element name="article">
<xs:complexType>
<xs:sequence>
<xs:element name="code_article" type="xs:string" minOccurs="0"/>
<xs:element name="quantite" type="xs:int32" minOccurs="0"/>
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
<xs:element name="skier_index" type="xs:int32" minOccurs="0"/>
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
<code_article>{$this->article['code_article']}</code_article>
<quantite>{$this->article['quantite']}</quantite>
<articles_prix>{$this->article['articles_prix']}</articles_prix>
<code_parent>{$this->article['code_parent']}</code_parent>
<acompte>{$this->article['acompte']}</acompte>
<subvention_montant>{$this->article['subvention_montant']}</subvention_montant>
<subvention_payeur>{$this->article['subvention_payeur']}</subvention_payeur>
<remise>{$this->article['remise']}</remise>
<nature_client_id>{$this->article['nature_client_id']}</nature_client_id>
<categorie_place_code>{$this->article['categorie_place_code']}</categorie_place_code>
<libelle_article>{$this->article['libelle_article']}</libelle_article>
<famille_article>{$this->article['famille_article']}</famille_article>
<skier_index>{$this->article['skier_index']}</skier_index>
</article>
EOT;
        $this->assertEquals($expectedBody, $this->articleDatasetTable->renderBody());
    }
}
