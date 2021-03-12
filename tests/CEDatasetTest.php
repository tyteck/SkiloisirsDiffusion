<?php

namespace SkiLoisirsDiffusion\Tests;

use SkiLoisirsDiffusion\Datasets\CEDataset;

class CEDatasetTest extends BaseTestCase
{
    /** @test */
    public function ce_dataset_schema_is_ok()
    {
        $schema = CEDataset::create()->schema();

        array_map(
            function ($key, $type) use ($schema) {
                $this->assertStringContainsString(
                    '<xs:element name="' . $key . '" type="xs:' . $type . '" minOccurs="0"/>',
                    $schema,
                    "The key {$key} with type {$type} is not set properly."
                );
            },
            array_keys($this->expectedCeDatasetSchema()),
            $this->expectedCeDatasetSchema()
        );
    }

    /** @test */
    public function ce_dataset_body_is_ok()
    {
        $ceDatasetBody = CEDataset::create()->body();

        $expectedBody = $this->expectedCeDatasetBody();

        array_map(
            function ($key, $value) use ($ceDatasetBody) {
                $this->assertStringContainsString(
                    "<{$key}>{$value}</{$key}>",
                    $ceDatasetBody,
                    "The value {$value} for {$key} is not set properly."
                );
            },
            array_keys($expectedBody),
            $expectedBody
        );
    }
}
