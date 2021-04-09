<?php

namespace SkiLoisirsDiffusion\DatasetTables;

use SkiLoisirsDiffusion\Datasets\DatasetField;
use SkiLoisirsDiffusion\Datatypes\ArticleDatatype;

class ArticleDatasetTable extends DatasetTable
{
    /** @var string $tablename */
    protected static $tablename = 'article';

    public static function prepare()
    {
        return new self(static::$tablename);
    }

    public function with(ArticleDatatype $article): self
    {
        $this->addDatasetFields(
            [
                DatasetField::create('code_article', 'string', $article->code_article),
                DatasetField::create('quantite', 'int32', $article->quantite),
                DatasetField::create('articles_prix', 'decimal', $article->articles_prix),
                DatasetField::create('code_parent', 'string', $article->code_parent, 0, false),
                DatasetField::create('acompte', 'decimal', $article->acompte, 0, false),
                DatasetField::create('subvention_montant', 'string', $article->subvention_montant, 0, false),
                DatasetField::create('subvention_payeur', 'string', $article->subvention_payeur),
                DatasetField::create('remise', 'decimal', $article->remise),
                DatasetField::create('nature_client_id', 'string', $article->nature_client_id, 0, false),
                DatasetField::create('categorie_place_code', 'string', $article->categorie_place_code, 0, false),
                DatasetField::create('libelle_article', 'string', $article->libelle_article, 0, false),
                DatasetField::create('famille_article', 'string', $article->famille_article, 0, false),
                DatasetField::create('skier_index', 'int32', $article->skier_index),
            ]
        );
        return $this;
    }
}
