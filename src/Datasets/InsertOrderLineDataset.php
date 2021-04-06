<?php

namespace SkiLoisirsDiffusion\Datasets;

use SkiLoisirsDiffusion\DatasetTables\CeDatasetTable;
use SkiLoisirsDiffusion\DatasetTables\OrderDatasetTable;
use SkiLoisirsDiffusion\DatasetTables\SignatureDatasetTable;
use SkiLoisirsDiffusion\DatasetTables\UserDatasetTable;
use SkiLoisirsDiffusion\Datatypes\OrderDatatype;
use SkiLoisirsDiffusion\Datatypes\UserDatatype;
use stdClass;

class InsertOrderLineDataset extends MakeDataset
{
    /** @var \SkiLoisirsDiffusion\DatasetTables\CeDatasetTable */
    protected $ceDataSetTable;

    /** @var \SkiLoisirsDiffusion\DatasetTables\UserDatasetTable */
    protected $userDatasetTable;

    /** @var \SkiLoisirsDiffusion\DatasetTables\OrderDatasetTable */
    protected $orderDatasetTable;

    /** @var \SkiLoisirsDiffusion\DatasetTables\SignatureDatasetTable */
    protected $signatureDataSetTable;

    private function __construct(UserDatatype $user, OrderDatatype $order)
    {
        $this->user = $user;
        $this->order = $order;

        $this->ceDataSetTable = CeDatasetTable::prepare()->withConfig();
        $this->userDatasetTable = UserDatasetTable::prepare()->with($this->user);
        $this->orderDataSetTable = OrderDatasetTable::prepare()->with($this->order);
        $this->signatureDataSetTable = SignatureDatasetTable::prepare()->with($this->order, $this->user, sldconfig('clef_secrete'));

        $this->dataset = new stdClass();

        $this->addDatasetTables(
            [
                $this->ceDataSetTable,
                $this->userDatasetTable,
                $this->orderDataSetTable,
                $this->signatureDataSetTable,
            ]
        );
    }

    public static function create(...$params)
    {
        return new static(...$params);
    }
}
