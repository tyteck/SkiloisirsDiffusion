<?php

namespace SkiLoisirsDiffusion\Tests;

use SkiLoisirsDiffusion\Datasets\OrderDataset;

class OrderDatasetTest extends BaseTestCase
{
    /** @test */
    public function order_dataset_schema_is_ok()
    {
        $schema = OrderDataset::create()->schema();

        $expectedKeyTypes = [
            'nb_cheques_vacances' => 'string',
            'montant_total_cheques_vacances' => 'string',
            'mode_paiement' => 'string',
            'prix_livraison' => 'decimal',
            'code_livraison' => 'string',
            'commentaire' => 'string',
            'livraison_adresse_nom' => 'string',
            'livraison_adresse_1' => 'string',
            'livraison_adresse_2' => 'string',
            'livraison_codepostal' => 'string',
            'livraison_ville' => 'string',
            'livraison_pays' => 'string',
            'url_retour' => 'string',
            'url_retour_ok' => 'string',
            'url_retour_err' => 'string',
            'acompte' => 'decimal',
            'numero_commande_ticketnet' => 'string',
        ];

        array_map(
            function ($key, $type) use ($schema) {
                $this->assertStringContainsString(
                    '<xs:element name="' . $key . '" type="xs:' . $type . '" minOccurs="0"',
                    $schema,
                    "The key {$key} with type {$type} is not set properly."
                );
            },
            array_keys($expectedKeyTypes),
            $expectedKeyTypes
        );
    }

    /** @test */
    public function order_dataset_body_is_ok()
    {
        $expectedKeyValues = [
            'nb_cheques_vacances' => '1',
            'montant_total_cheques_vacances' => '12',
            'mode_paiement' => 'CB',
            'prix_livraison' => '1.9',
            'code_livraison' => 'AYB',
            'commentaire' => 'not required',
            'livraison_adresse_nom' => 'Gilbert Leroy',
            'livraison_adresse_1' => 'chemin de la charrue endommagée',
            'livraison_adresse_2' => '',
            'livraison_codepostal' => '77300',
            'livraison_ville' => 'Tourte la charrue',
            'livraison_pays' => 'not required',
            'url_retour' => 'not required',
            'url_retour_ok' => 'not required',
            'url_retour_err' => 'not required',
            'acompte' => 'not required',
            'numero_commande_ticketnet' => 'not required',
        ];

        $body = OrderDataset::create($expectedKeyValues)->body();

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
