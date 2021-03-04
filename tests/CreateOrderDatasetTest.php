<?php

namespace SkiLoisirsDiffusion\Tests;

use SkiLoisirsDiffusion\Datasets\CEDataset;
use SkiLoisirsDiffusion\Datasets\CreateOrderDataset;

class CreateOrderDatasetTest extends BaseTestCase
{
    /** @test */
    public function order_dataset_is_ok()
    {
        $this->markTestIncomplete('to be done');
        $ceDataSet = CEDataset::create();
        $userDataSet = $this->createUserDataset();
        $orderDataSet = $this->createOrderDataset();
        $signatureDataSet = $this->createSignatureDataset($this->signatureDatasetParameters());

        $createOrderDataset = CreateOrderDataset::create($ceDataSet, $userDataSet, $orderDataSet, $signatureDataSet);
    }
}
