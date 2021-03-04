<?php

namespace SkiLoisirsDiffusion\Tests;

use SkiLoisirsDiffusion\Datasets\CEDataset;

class CEDatasetTest extends BaseTestCase
{
    /** @test */
    public function ce_dataset_schema_is_ok()
    {
        $ceDatasetSchema = CEDataset::create()->schema();

        array_map(
            function ($keyThatShouldBePresent) use ($ceDatasetSchema) {
                $this->assertStringContainsString(
                    '<xs:element name="' . $keyThatShouldBePresent . '" type="xs:string" minOccurs="0"/>',
                    $ceDatasetSchema,
                    "The key {$keyThatShouldBePresent} is not set properly."
                );
            },
            ['ce_id', 'ce_societe', 'ce_nom', 'ce_prenom', 'ce_email', 'ce_codepostal', 'ce_ville', ]
        );
    }

    /** @test */
    public function ce_dataset_body_is_ok()
    {
        $ceDatasetBody = CEDataset::create()->body();

        $expectedKeyValues = [
            'ce_id' => sldconfig('sld_partenaire_id'),
            'ce_societe' => sldconfig('ce_societe'),
            'ce_nom' => sldconfig('ce_nom'),
            'ce_prenom' => sldconfig('ce_prenom'),
            'ce_email' => sldconfig('ce_email'),
            'ce_codepostal' => sldconfig('ce_codepostal'),
            'ce_ville' => sldconfig('ce_ville'),
        ];
        array_map(
            function ($key, $value) use ($ceDatasetBody) {
                $this->assertStringContainsString(
                    "<{$key}>{$value}</{$key}>",
                    $ceDatasetBody,
                    "The value {$value} for {$key} is not set properly."
                );
            },
            array_keys($expectedKeyValues),
            $expectedKeyValues
        );
    }
}
