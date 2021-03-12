<?php

namespace SkiLoisirsDiffusion\Tests;

use SkiLoisirsDiffusion\Datasets\OrderDataset;

class OrderDatasetTest extends BaseTestCase
{
    /** @test */
    public function order_dataset_schema_is_ok()
    {
        $schema = OrderDataset::create()->schema();

        array_map(
            function ($key, $type) use ($schema) {
                $this->assertStringContainsString(
                    '<xs:element name="' . $key . '" type="xs:' . $type . '" minOccurs="0"',
                    $schema,
                    "The key {$key} with type {$type} is not set properly."
                );
            },
            array_keys($this->expectedOrderDatasetSchema()),
            $this->expectedOrderDatasetSchema()
        );
    }

    /** @test */
    public function order_dataset_body_is_ok()
    {
        $body = OrderDataset::create($this->expectedOrderDatasetBody())->body();

        array_map(
            function ($key, $value) use ($body) {
                $this->assertStringContainsString(
                    "<{$key}>{$value}</{$key}>",
                    $body,
                    "The value {$value} for {$key} is not set properly."
                );
            },
            array_keys($this->expectedOrderDatasetBody()),
            $this->expectedOrderDatasetBody()
        );
    }
}
