<?php

namespace SkiLoisirsDiffusion\Tests;

class ArticleDatasetTest extends BaseTestCase
{
    /** @test */
    public function article_dataset_schema_is_ok()
    {
        $articleDataset = $this->createArticleDataset($this->expectedArticleDatasetBody());
        $schema = $articleDataset->schema();

        array_map(
            function ($key, $type) use ($schema) {
                $this->assertStringContainsString(
                    '<xs:element name="' . $key . '" type="xs:' . $type . '" minOccurs="0"',
                    $schema,
                    "The key {$key} with type {$type} is not set properly."
                );
            },
            array_keys($this->expectedArticleDatasetSchema()),
            $this->expectedArticleDatasetSchema()
        );
    }

    /** @test */
    public function article_dataset_body_is_ok()
    {
        $articleDataset = $this->createArticleDataset($this->expectedArticleDatasetBody());
        $body = $articleDataset->body();

        array_map(
            function ($key, $value) use ($body) {
                $this->assertStringContainsString(
                    "<{$key}>{$value}</{$key}>",
                    $body,
                    "The value {$value} for {$key} is not set properly."
                );
            },
            array_keys($this->expectedArticleDatasetBody()),
            $this->expectedArticleDatasetBody()
        );
    }
}
