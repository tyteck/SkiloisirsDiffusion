<?php

namespace SkiLoisirsDiffusion\Datasets;

use InvalidArgumentException;
use SkiLoisirsDiffusion\Interfaces\DatasetTableContract;

class SignatureDataset implements DatasetTableContract
{
    /** @var \SkiLoisirsDiffusion\DatasetTables\DatasetTable $datasetTable */
    protected $datasetTable;

    /** @var string $tablename */
    protected $tableName = 'signature';

    private function __construct(array $attributes = [])
    {
        $requiredParameters = [
            'code_livraison',
            'id_partenaire',
            'mode_paiement',
            'utilisateurs_adresse1',
            'utilisateurs_adresse_nom',
            'utilisateurs_codepostal',
            'utilisateurs_email',
            'utilisateurs_nom',
            'utilisateurs_prenom',
            'utilisateurs_ville',
            'clef_secrete',
        ];
        array_map(function ($requiredParameter) use ($attributes) {
            if (!isset($attributes[$requiredParameter]) || !strlen($attributes[$requiredParameter])) {
                throw new InvalidArgumentException("Parameter {$requiredParameter} is required to generate signature.", 1);
            }
        }, $requiredParameters);

        $this->datasetTable = DatasetTable::create($this->tableName)->addDatasetField(
            DatasetField::create('signature', 'string', $this->generateSignature($attributes))
        );
    }

    public static function create(...$params)
    {
        return new static(...$params);
    }

    public function schema(): string
    {
        return $this->datasetTable->renderSchema();
    }

    public function body(): string
    {
        return $this->datasetTable->renderBody();
    }

    public function signature(): string
    {
        return $this->signature;
    }

    public function generateSignature($attributes)
    {
        return sha1(
            array_reduce(
                $attributes,
                function ($carry, $attribute) {
                    if (strlen($carry)) {
                        $carry .= '+';
                    }
                    return $carry .= $attribute;
                }
            )
        );
    }
}
