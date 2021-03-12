<?php

namespace SkiLoisirsDiffusion\Tests;

use Carbon\Carbon;
use SkiLoisirsDiffusion\Datasets\UserDataset;

class UserDatasetTest extends BaseTestCase
{
    /** @test */
    public function user_dataset_schema_is_ok()
    {
        $schema = UserDataset::create()->schema();

        array_map(
            function ($key, $type) use ($schema) {
                $this->assertStringContainsString(
                    '<xs:element name="' . $key . '" type="xs:' . $type . '" minOccurs="0"/>',
                    $schema,
                    "The key {$key} with type {$type} is not set properly."
                );
            },
            array_keys($this->expectedUserDatasetSchema()),
            $this->expectedUserDatasetSchema()
        );
    }

    /** @test */
    public function user_dataset_body_is_ok()
    {
        $expectedKeyValues = [
            'id_partenaire' => '42',
            'utilisateurs_nom' => 'Leroy',
            'utilisateurs_prenom' => 'Gilbert',
            'utilisateurs_telephone' => '0606060606',
            'utilisateurs_portable' => '0606060606',
            'utilisateurs_email' => 'gilbert@leroy.com',
            'utilisateurs_adresse1' => 'chemin de la charrue endommagée',
            'utilisateurs_codepostal' => '77300',
            'utilisateurs_ville' => 'Tourte la charrue',
            'utilisateurs_pays' => 'France',
            'utilisateurs_date_naissance' => Carbon::now()->subYears(25)->format('Y-m-d\Th:i:s'),
        ];

        $body = UserDataset::create($expectedKeyValues)->body();

        array_map(
            function ($key, $value) use ($body) {
                $this->assertStringContainsString(
                    "<{$key}>{$value}</{$key}>",
                    $body,
                    "The value {$value} for {$key} is not set properly."
                );
            },
            array_keys($expectedKeyValues),
            $expectedKeyValues
        );
    }
}
