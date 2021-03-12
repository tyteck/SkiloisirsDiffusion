<?php

namespace SkiLoisirsDiffusion\Tests;

use SkiLoisirsDiffusion\Datasets\CEDataset;
use SkiLoisirsDiffusion\Datasets\CreateOrderDataset;

class CreateOrderDatasetTest extends BaseTestCase
{
    /** @test */
    public function order_dataset_schema_is_ok()
    {
        $ceDataSet = CEDataset::create();
        $userDataSet = $this->createUserDataset();
        $orderDataSet = $this->createOrderDataset();
        $signatureDataSet = $this->createSignatureDataset($this->signatureDatasetParameters());

        $createOrderDataset = CreateOrderDataset::create($ceDataSet, $userDataSet, $orderDataSet, $signatureDataSet);

        $expectedSchema = array_merge(
            $this->expectedCeDatasetSchema(),
            $this->expectedUserDatasetSchema(),
            $this->expectedOrderDatasetSchema(),
            /** signature */
            ['signature' => 'string'],
        );

        $schema = $createOrderDataset->schema();

        array_map(
            function ($key, $type) use ($schema) {
                $this->assertStringContainsString(
                    '<xs:element name="' . $key . '" type="xs:' . $type . '" minOccurs="0"/>',
                    $schema,
                    "The key {$key} with type {$type} is not set properly."
                );
            },
            array_keys($expectedSchema),
            $expectedSchema
        );
    }
}
