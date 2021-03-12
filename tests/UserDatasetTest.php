<?php

namespace SkiLoisirsDiffusion\Tests;

use SkiLoisirsDiffusion\Datasets\UserDataset;

class UserDatasetTest extends BaseTestCase
{
    /** @test */
    public function user_dataset_schema_is_ok()
    {
        $schema = UserDataset::create()->schema();

        array_map(
            function ($key, $type) use ($schema) {
                $this->assertStringContainsString(
                    '<xs:element name="' . $key . '" type="xs:' . $type . '" minOccurs="0"/>',
                    $schema,
                    "The key {$key} with type {$type} is not set properly."
                );
            },
            array_keys($this->expectedUserDatasetSchema()),
            $this->expectedUserDatasetSchema()
        );
    }

    /** @test */
    public function user_dataset_body_is_ok()
    {
        $body = UserDataset::create($this->expectedUserDatasetBody())->body();

        array_map(
            function ($key, $value) use ($body) {
                $this->assertStringContainsString(
                    "<{$key}>{$value}</{$key}>",
                    $body,
                    "The value {$value} for {$key} is not set properly."
                );
            },
            array_keys($this->expectedUserDatasetBody()),
            $this->expectedUserDatasetBody()
        );
    }
}
