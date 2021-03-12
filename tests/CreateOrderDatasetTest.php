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
        $signatureDataSet = $this->createSignatureDataset();

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

    /** @test */
    public function order_dataset_body_is_ok()
    {
        $ceDataSet = CEDataset::create();
        $userDataSet = $this->createUserDataset();
        $orderDataSet = $this->createOrderDataset();
        $signatureDataSet = $this->createSignatureDataset();

        $createOrderDataset = CreateOrderDataset::create($ceDataSet, $userDataSet, $orderDataSet, $signatureDataSet);

        $expectedBody = array_merge(
            $this->expectedCeDatasetbody(),
            $this->expectedUserDatasetbody(),
            $this->expectedOrderDatasetbody(),
            /** signature */
            ['signature' => $signatureDataSet->signature()],
        );

        $body = $createOrderDataset->body();

        array_map(
            function ($key, $value) use ($body) {
                $this->assertStringContainsString(
                    "<{$key}>{$value}</{$key}>",
                    $body,
                    "The value {$value} for {$key} is not set properly."
                );
            },
            array_keys($expectedBody),
            $expectedBody
        );
    }
}
