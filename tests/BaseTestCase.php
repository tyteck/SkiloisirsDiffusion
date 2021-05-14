<?php

namespace SkiLoisirsDiffusion\Tests;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use SkiLoisirsDiffusion\Datasets\CreateOrderDataset;
use SkiLoisirsDiffusion\Datasets\DatasetField;
use SkiLoisirsDiffusion\Datasets\InsertOrderLineDataset;
use SkiLoisirsDiffusion\DatasetTables\ArticleDatasetTable;
use SkiLoisirsDiffusion\DatasetTables\DatasetTable;
use SkiLoisirsDiffusion\DatasetTables\EbilletDatasetTable;
use SkiLoisirsDiffusion\DatasetTables\FraisGestionDatasetTable;
use SkiLoisirsDiffusion\Datatypes\ArticleDatatype;
use SkiLoisirsDiffusion\Datatypes\CeDatatype;
use SkiLoisirsDiffusion\Datatypes\EbilletDatatype;
use SkiLoisirsDiffusion\Datatypes\FraisGestionDatatype;
use SkiLoisirsDiffusion\Datatypes\OrderDatatype;
use SkiLoisirsDiffusion\Datatypes\UserDatatype;
use SkiLoisirsDiffusion\Tests\Factory\ArticleFactory;
use SkiLoisirsDiffusion\Tests\Factory\EbilletFactory;
use SkiLoisirsDiffusion\Tests\Factory\FraisGestionFactory;
use SkiLoisirsDiffusion\Tests\Factory\OrderFactory;
use SkiLoisirsDiffusion\Tests\Factory\UserFactory;

class BaseTestCase extends TestCase
{
    public function createDatasetField(int $minOccurs = 0, bool $required = true)
    {
        $fieldName = 'field' . rand(1, 1000);
        $fieldTypes = array_keys(DatasetField::allowedFieldTypes());
        $fieldType = $fieldTypes[rand(0, (count($fieldTypes) - 1))];
        switch ($fieldType) {
            case 'string': $fieldValue = 'lorem ipsum'; break;
            case 'dateTime': $fieldValue = Carbon::now()->subDay(); break;
            case 'decimal': $fieldValue = 29.90; break;
            case 'int32': $fieldValue = 2846; break;
            case 'int64': $fieldValue = 2847; break;
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

    public function ceDatatypeFromConfig()
    {
        return CeDatatype::create(
            [
                'ce_id' => sldconfig('sld_partenaire_id'),
                'ce_societe' => sldconfig('ce_societe'),
                'ce_civilite' => null,
                'ce_nom' => sldconfig('ce_nom'),
                'ce_prenom' => sldconfig('ce_prenom'),
                'ce_telephone' => null,
                'ce_portable' => null,
                'ce_fax' => null,
                'ce_email' => sldconfig('ce_email'),
                'ce_adresse_nom' => null,
                'ce_adresse1' => null,
                'ce_adresse2' => null,
                'ce_codepostal' => sldconfig('ce_codepostal'),
                'ce_ville' => sldconfig('ce_ville'),
                'ce_pays' => null,
            ]
        );
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

    public function getOrderDataSet()
    {
        /** creating datatypes to be used */
        $ce = $this->ceDatatypeFromConfig();
        $user = UserDatatype::create(UserFactory::create());
        $order = OrderDatatype::create(OrderFactory::create(
            [
                'code_livraison' => 'LS20G',
                'prix_livraison' => 3.5,
            ]
        ));

        return CreateOrderDataset::create($ce, $user, $order, sldconfig('clef_secrete'))->render();
    }

    public function getInsertOrderLineDataset(string $orderNumber, ?string $codeArticle = 'ALHAMBRA', ?float $articlePrix = 6.5)
    {
        $article = ArticleDatatype::create(
            ArticleFactory::create(['code_article' => $codeArticle, 'articles_prix' => $articlePrix])
        );
        $ebillet = EbilletDatatype::create(EbilletFactory::create());
        $fraisGestion = FraisGestionDatatype::create(FraisGestionFactory::create(
            [
                'nb_ebc' => 1,
                'prix_ebc' => 0.5,
                'nb_frais_gestion' => 1,
                'prix_frais_gestion' => 0.5
            ]
        ));

        /** creating order */
        $datasetTables = [];
        $datasetTables[] = ArticleDatasetTable::prepare()->with($article);
        $datasetTables[] = EbilletDatasetTable::prepare()->with($ebillet);
        $datasetTables[] = FraisGestionDatasetTable::prepare()->with($fraisGestion);

        return InsertOrderLineDataset::create($orderNumber)
            ->addDatasetTables($datasetTables)
            ->render();
    }
}
