<?php

namespace SkiLoisirsDiffusion\Datasets;

class InsertOrderLineDataset extends MakeDataset
{
    /** @var int $orderNumber */
    protected $orderNumber;

    private function __construct(int $orderNumber)
    {
        parent::__construct();
        $this->orderNumber = $orderNumber;
    }

    public static function create(...$params)
    {
        return new static(...$params);
    }
}
