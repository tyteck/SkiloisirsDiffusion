<?php

namespace Tests;

use SkiLoisirsDiffusion\Datasets\CEDataset;
use SkiLoisirsDiffusion\Datasets\CreateOrderDataset;

class CreateOrderDatasetTest extends BaseTestCase
{
    /** @test */
    public function order_dataset_is_ok()
    {
        $ceDataSet = CEDataset::create();
        $userDataSet = $this->createUserDataset();
        $orderDataSet = $this->createOrderDataset();

        $createOrderDataset = CreateOrderDataset::create($ceDataSet, $userDataSet, $orderDataSet);

        var_dump($createOrderDataset->schema());
    }
}
