<?php

namespace SkiLoisirsDiffusion\Tests;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use SkiLoisirsDiffusion\Datasets\ArticleDataset;
use SkiLoisirsDiffusion\Datasets\DatasetField;
use SkiLoisirsDiffusion\Datasets\DatasetTable;

class BaseTestCase extends TestCase
{
    public function createArticleDataset()
    {
        return ArticleDataset::create($this->expectedArticleDatasetBody());
    }

    public function expectedArticleDatasetBody()
    {
        return [
            'code_article' => '',
            'quantite' => '',
            'articles_prix' => '',
            'code_parent' => '',
            'acompte' => '',
            'subvention_montant' => '',
            'subvention_payeur' => '',
            'remise' => '',
            'nature_client_id' => '',
            'categorie_place_code' => '',
            'libelle_article' => '',
            'famille_article' => '',
            'skier_index' => '',
        ];
    }

    public function expectedArticleDatasetSchema()
    {
        return [
            'code_article' => 'string',
            'quantite' => 'int',
            'articles_prix' => 'decimal',
            'code_parent' => 'string',
            'acompte' => 'decimal',
            'subvention_montant' => 'string',
            'subvention_payeur' => 'string',
            'remise' => 'decimal',
            'nature_client_id' => 'string',
            'categorie_place_code' => 'string',
            'libelle_article' => 'string',
            'famille_article' => 'string',
            'skier_index' => 'int',
        ];
    }

    public function createDatasetField()
    {
        $fieldName = 'field' . rand(1, 1000);
        $fieldTypes = DatasetField::allowedFieldTypes();
        $fieldType = $fieldTypes[rand(0, (count($fieldTypes) - 1))];
        switch ($fieldType) {
            case 'string': $fieldValue = 'lorem ipsum'; break;
            case 'dateTime': $fieldValue = Carbon::now()->subDay(); break;
            case 'decimal': $fieldValue = 29.90; break;
            case 'int32': $fieldValue = 2846; break;
            case 'int64': $fieldValue = 2847; break;
        }
        return DatasetField::create($fieldName, $fieldType, $fieldValue);
    }

    public function createManyDatasetFields(int $numberOfDataset)
    {
        $datasetFields = [];
        for ($i = 0;$i < $numberOfDataset;$i++) {
            $datasetFields[] = $this->createDatasetField();
        }
        return $datasetFields;
    }

    public function createDatasetTable($datasetTableName, $nbDatasetFields)
    {
        return DatasetTable::create($datasetTableName)
            ->addDatasetFields(
                $this->createManyDatasetFields($nbDatasetFields)
            );
    }

    public function createDatasetTables($nbDatasetTables)
    {
        $datasetTables = [];
        for ($i = 0;$i < $nbDatasetTables;$i++) {
            $datasetTableName = 'table' . rand(1, 1000);
            $nbDatasetFields = rand(1, 5);
            $datasetTables[] = DatasetTable::create($datasetTableName)
                ->addDatasetFields(
                    $this->createManyDatasetFields($nbDatasetFields)
                );
        }
        return $datasetTables;
    }

    public function datasetFieldsToString(array $datasetFields, bool $INeedSchema = true)
    {
        $datasetFieldsAsString = '';
        if (count($datasetFields)) {
            $method = $INeedSchema === true ? 'renderSchema' : 'renderBody';
            $datasetFieldsAsString .= array_reduce(
                $datasetFields,
                function ($carry, DatasetField $datasetField) use ($method) {
                    if (strlen($carry)) {
                        $carry .= PHP_EOL;
                    }
                    return $carry .= $datasetField->$method();
                }
            );
        }
        return $datasetFieldsAsString;
    }

    public function datasetTablesToString(array $datasetTables, bool $INeedSchema = true)
    {
        $result = '';
        if (count($datasetTables)) {
            $method = $INeedSchema === true ? 'renderSchema' : 'renderBody';

            $rowOrder = 0;
            $result .= array_reduce(
                $datasetTables,
                function ($carry, DatasetTable $datasetTable) use ($method, &$rowOrder) {
                    if (strlen($carry)) {
                        $carry .= PHP_EOL;
                    }
                    return $carry .= $datasetTable->$method($rowOrder++);
                }
            );
        }
        return $result;
    }

    public function createCeDatasetTable(): DatasetTable
    {
        return DatasetTable::create('ce')
            ->addDatasetFields(
                [
                    DatasetField::create('ce_id', 'string', sldconfig('sld_partenaire_id')),
                    DatasetField::create('ce_societe', 'string', sldconfig('ce_societe')),
                    DatasetField::create('ce_nom', 'string', sldconfig('ce_nom')),
                    DatasetField::create('ce_prenom', 'string', sldconfig('ce_prenom')),
                    DatasetField::create('ce_email', 'string', sldconfig('ce_email')),
                    DatasetField::create('ce_codepostal', 'string', sldconfig('ce_codepostal')),
                    DatasetField::create('ce_ville', 'string', sldconfig('ce_ville')),
                ]
            );
    }
}
