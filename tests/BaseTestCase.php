<?php

namespace SkiLoisirsDiffusion\Tests;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use SkiLoisirsDiffusion\Datasets\DatasetField;
use SkiLoisirsDiffusion\DatasetTables\DatasetTable;
use SkiLoisirsDiffusion\Datatypes\OrderDatatype;
use SkiLoisirsDiffusion\Datatypes\UserDatatype;

class BaseTestCase extends TestCase
{
    public function createDatasetField(int $minOccurs = 0, bool $required = true)
    {
        $fieldName = 'field' . rand(1, 1000);
        $fieldTypes = array_keys(DatasetField::allowedFieldTypes());
        $fieldType = $fieldTypes[rand(0, (count($fieldTypes) - 1))]; 
        switch ($fieldType) {
            case 'string': $fieldValue = $required ? 'lorem ipsum' : null ; break;
            case 'dateTime': $fieldValue = $required ? Carbon::now()->subDay() : null ; break;
            case 'decimal': $fieldValue = $required ? 29.90 : null; break;
            case 'int32': $fieldValue = $required ? 2846 : null;  break;
            case 'int64': $fieldValue = $required ? 2847 : null;  break;
        }
        return DatasetField::create($fieldName, $fieldType, $fieldValue, $minOccurs, $required);
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
            $knownTablesWithIndex = [];
            $result .= array_reduce(
                $datasetTables,
                function ($carry, DatasetTable $datasetTable) use ($method, &$knownTablesWithIndex, &$rowOrder) {
                    if (strlen($carry)) {
                        $carry .= PHP_EOL;
                    }
                    if (!isset($knownTablesWithIndex[$datasetTable->tableName()])) {
                        $knownTablesWithIndex[$datasetTable->tableName()] = 1;
                    } else {
                        $knownTablesWithIndex[$datasetTable->tableName()]++;
                    }
                    return $carry .= $datasetTable->$method(
                        $knownTablesWithIndex[$datasetTable->tableName()],
                        $rowOrder++
                    );
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

    public function makeSignatureFrom(UserDatatype $user, OrderDatatype $order, string $clefSecrete)
    {
        $createSignatureParameters = [
            'code_livraison' => $order->code_livraison,
            'id_partenaire' => $user->id_partenaire,
            'mode_paiement' => $order->mode_paiement,
            'utilisateurs_adresse1' => $user->utilisateurs_adresse1,
            'utilisateurs_adresse_nom' => $user->utilisateurs_adresse_nom,
            'utilisateurs_codepostal' => $user->utilisateurs_codepostal,
            'utilisateurs_email' => $user->utilisateurs_email,
            'utilisateurs_nom' => $user->utilisateurs_nom,
            'utilisateurs_prenom' => $user->utilisateurs_prenom,
            'utilisateurs_ville' => $user->utilisateurs_ville,
            'clef_secrete' => $clefSecrete,
        ];
        return generateSignature($createSignatureParameters);
    }
}
