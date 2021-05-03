<?php

namespace SkiLoisirsDiffusion\DatasetTables;

use SkiLoisirsDiffusion\Datasets\DatasetField;
use SkiLoisirsDiffusion\Datatypes\CeDatatype;

class CeDatasetTable extends DatasetTable
{
    /** @var string $tablename */
    protected static $tablename = 'ce';

    public static function prepare()
    {
        return new self(static::$tablename);
    }

    public function with(CeDatatype $ceDatatype)
    {
        $this->addDatasetFields(
            [
                DatasetField::create('ce_id', 'string', $ceDatatype->ce_id),
                DatasetField::create('ce_societe', 'string', $ceDatatype->ce_societe),
                DatasetField::create('ce_civilite', 'string', $ceDatatype->ce_civilite),
                DatasetField::create('ce_nom', 'string', $ceDatatype->ce_nom),
                DatasetField::create('ce_prenom', 'string', $ceDatatype->ce_prenom),
                DatasetField::create('ce_telephone', 'string', $ceDatatype->ce_telephone),
                DatasetField::create('ce_portable', 'string', $ceDatatype->ce_portable),
                DatasetField::create('ce_fax', 'string', $ceDatatype->ce_fax),
                DatasetField::create('ce_email', 'string', $ceDatatype->ce_email),
                DatasetField::create('ce_adresse_nom', 'string', $ceDatatype->ce_adresse_nom),
                DatasetField::create('ce_adresse1', 'string', $ceDatatype->ce_adresse1),
                DatasetField::create('ce_adresse2', 'string', $ceDatatype->ce_adresse2),
                DatasetField::create('ce_codepostal', 'string', $ceDatatype->ce_codepostal),
                DatasetField::create('ce_ville', 'string', $ceDatatype->ce_ville),
                DatasetField::create('ce_pays', 'string', $ceDatatype->ce_pays),
            ]
        );
        return $this;
    }
}
