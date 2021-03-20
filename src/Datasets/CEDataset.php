<?php

namespace SkiLoisirsDiffusion\Datasets;

class CEDataset
{
    /** @var \SkiLoisirsDiffusion\Datasets\DatasetTable $datasetTable */
    protected $datasetTable;

    /** @var string $tablename */
    protected $tableName = 'ce';

    /** @var array $datasetFields */
    protected $datasetFields = [];

    protected $attributes = [/** ce_id, */'ce_societe', 'ce_nom', 'ce_prenom', 'ce_email', 'ce_codepostal', 'ce_ville'];

    private function __construct()
    {
        $this->datasetFields = array_merge(
            [DatasetField::create('ce_id', 'string', sldconfig('sld_partenaire_id'))],
            $this->datasetFields = array_map(function ($attributeName) {
                return DatasetField::create($attributeName, 'string', sldconfig($attributeName));
            }, $this->attributes)
        );

        $this->datasetTable = DatasetTable::create($this->tableName)->addDatasetFields($this->datasetFields);
    }

    public static function create(...$params)
    {
        return new static(...$params);
    }

    public function schema():string
    {
        return $this->datasetTable->renderSchema();
    }

    public function body():string
    {
        return $this->datasetTable->renderBody();
    }
}
