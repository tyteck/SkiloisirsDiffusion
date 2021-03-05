<?php

namespace SkiLoisirsDiffusion\Tests;

class ArticleDatasetTest extends BaseTestCase
{
    /** @test */
    public function article_dataset_schema_is_ok()
    {
        $articleDataset = $this->createArticleDataset($this->articleDatasetParameters());
        $schema = $articleDataset->schema();

        $expectedKeyTypes = [
            'code_article' => 'string',
            'quantite' => 'int',
            'articles_prix' => 'decimal',
            'code_parent' => 'string',
            'acompte' => 'decimal',
            'subvention_montant' => 'string',
            'subvention_payeur' => 'string',
            'remise' => 'decimal',
            'nature_client_id' => 'string',
            'categorie_place_code' => 'string',
            'libelle_article' => 'string',
            'famille_article' => 'string',
            'skier_index' => 'int',
        ];

        array_map(
            function ($key, $type) use ($schema) {
                $this->assertStringContainsString(
                    '<xs:element name="' . $key . '" type="xs:' . $type . '" minOccurs="0"',
                    $schema,
                    "The key {$key} with type {$type} is not set properly."
                );
            },
            array_keys($expectedKeyTypes),
            $expectedKeyTypes
        );
    }

    /** @test */
    public function article_dataset_body_is_ok()
    {
        $expectedKeyValues = $this->articleDatasetParameters();

        $articleDataset = $this->createArticleDataset($this->articleDatasetParameters());
        $body = $articleDataset->body();

        array_map(
            function ($key, $value) use ($body) {
                $this->assertStringContainsString(
                    "<{$key}>{$value}</{$key}>",
                    $body,
                    "The value {$value} for {$key} is not set properly."
                );
            },
            array_keys($expectedKeyValues),
            $expectedKeyValues
        );
    }
}
