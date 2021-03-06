<?php

namespace SkiLoisirsDiffusion\Tests\Factory;

use Faker\Factory as Faker;

class ArticleFactory
{
    public static function realFake()
    {
        return [
            // cine
            ['code_article' => 'ALHAMBRA', 'articles_prix' => 6.5, 'sousgenres_nom' => 'Alhambra - Camion Rouge'],
            ['code_article' => 'GAUM001FRANCEEBC', 'articles_prix' => 8.9, 'sousgenres_nom' => 'Gaumont Pathé France'],
            ['code_article' => 'GAUM001MARSEBC', 'articles_prix' => 8.3, 'sousgenres_nom' => 'Pathé Marseille'],

            // parc
            ['code_article' => 'DISNE1P01CEADEB', 'articles_prix' => 59.0, 'sousgenres_nom' => 'Disneyland Paris Billets'],
            ['code_article' => 'ASTER01EBR', 'articles_prix' => 41.0, 'sousgenres_nom' => 'Astérix'],
            ['code_article' => 'FUTUR01EBR', 'articles_prix' => 40.0, 'sousgenres_nom' => 'Futuroscope'],
        ];
    }

    public static function create(?array $attributes = [])
    {
        if (!isset($attributes['code_article']) || $attributes['code_article'] === null) {
            $realFakes = self::realFake();
            $selectedIndex = array_rand($realFakes);

            $attributes['code_article'] = $realFakes[$selectedIndex]['code_article'];
            $attributes['articles_prix'] = $realFakes[$selectedIndex]['articles_prix'];
        }

        $subvention_payeurs = ['ce', 'salarie'];

        $faker = Faker::create('fr_FR');
        $result = [
            'code_article' => $attributes['code_article'] ?? $faker->regexify('[a-zA-Z0-9]{4}'),
            'quantite' => $attributes['quantite'] ?? 1,
            'articles_prix' => (float)$attributes['articles_prix'] ?? $faker->randomFloat(2, 0, 30),
            'code_parent' => $attributes['code_parent'] ?? null,
            'acompte' => $attributes['acompte'] ?? 0,
            'subvention_montant' => $attributes['subvention_montant'] ?? 0.25,
            'subvention_payeur' => $attributes['subvention_payeur'] ?? $subvention_payeurs[array_rand($subvention_payeurs)],
            'remise' => $attributes['remise'] ?? 3.0,
            'nature_client_id' => $attributes['nature_client_id'] ?? null,
            'categorie_place_code' => $attributes['categorie_place_code'] ?? null,
            'libelle_article' => $attributes['libelle_article'] ?? null,
            'famille_article' => $attributes['famille_article'] ?? null,
            'skier_index' => $attributes['skier_index'] ?? $faker->randomNumber(4),
        ];
        return $result;
    }
}
