<?php

namespace SkiLoisirsDiffusion\Tests;

use InvalidArgumentException;
use SkiLoisirsDiffusion\Datatypes\ArticleDatatype;
use SkiLoisirsDiffusion\Tests\Factory\ArticleFactory;

class ArticleDatatypeTest extends BaseTestCase
{
    /**
     * @test
     * @dataProvider provide_invalid_data
     */
    public function partial_info_should_fail($invalidData)
    {
        $this->expectException(InvalidArgumentException::class);
        ArticleDatatype::create($invalidData);
    }

    /**
     * @test
     * @dataProvider provide_valid_data
     */
    public function all_fields_filled_should_be_ok($validData)
    {
        $articleDatatype = ArticleDatatype::create($validData);
        $this->assertInstanceOf(ArticleDatatype::class, $articleDatatype);
        $this->assertEquals($validData['code_article'], $articleDatatype->code_article);
        $this->assertEquals($validData['quantite'], $articleDatatype->quantite);
        $this->assertEquals($validData['articles_prix'], $articleDatatype->articles_prix);
        $this->assertEquals($validData['code_parent'], $articleDatatype->code_parent);
        $this->assertEquals($validData['acompte'], $articleDatatype->acompte);
        $this->assertEquals($validData['subvention_montant'], $articleDatatype->subvention_montant);
        $this->assertEquals($validData['subvention_payeur'], $articleDatatype->subvention_payeur);
        $this->assertEquals($validData['remise'], $articleDatatype->remise);
        $this->assertEquals($validData['nature_client_id'], $articleDatatype->nature_client_id);
        $this->assertEquals($validData['categorie_place_code'], $articleDatatype->categorie_place_code);
        $this->assertEquals($validData['libelle_article'], $articleDatatype->libelle_article);
        $this->assertEquals($validData['famille_article'], $articleDatatype->famille_article);
        $this->assertEquals($validData['skier_index'], $articleDatatype->skier_index);
    }

    public function provide_invalid_data()
    {
        return [
            [
                [
                    'code_article' => null,
                    'quantite' => null,
                    'articles_prix' => null,
                    'code_parent' => null,
                    'acompte' => null,
                    'subvention_montant' => null,
                    'subvention_payeur' => null,
                    'remise' => null,
                    'nature_client_id' => null,
                    'categorie_place_code' => null,
                    'libelle_article' => null,
                    'famille_article' => null,
                    'skier_index' => null,
                ]
            ],
        ];
    }

    public function provide_valid_data()
    {
        return [
            [ArticleFactory::create()],
            [ArticleFactory::create()],
        ];
    }
}
