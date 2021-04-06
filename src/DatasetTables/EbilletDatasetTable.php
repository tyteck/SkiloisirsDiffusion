<?php

namespace SkiLoisirsDiffusion\DatasetTables;

use SkiLoisirsDiffusion\Datasets\DatasetField;
use SkiLoisirsDiffusion\Datatypes\EbilletDatatype;

class EbilletDatasetTable extends DatasetTable
{
    /** @var string $tablename */
    protected static $tablename = 'ebillet';

    public static function prepare()
    {
        return new self(static::$tablename);
    }

    public function with(EbilletDatatype $ebillet): self
    {
        $this->addDatasetFields(
            [
                DatasetField::create('code_article', 'string', $ebillet->code_article),
                DatasetField::create('nom', 'string', $ebillet->nom),
                DatasetField::create('prenom', 'string', $ebillet->prenom),
                DatasetField::create('date', 'string', $ebillet->date),
                DatasetField::create('date_naissance', 'string', $ebillet->date_naissance),
                DatasetField::create('keycard', 'string', $ebillet->keycard),
                DatasetField::create('skier_index', 'int32', $ebillet->skier_index),
            ]
        );
        return $this;
    }
}
