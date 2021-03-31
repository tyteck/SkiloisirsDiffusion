<?php

namespace SkiLoisirsDiffusion\Tests\Factory;

use Faker\Factory as Faker;

class ArticleFactory
{
    public static function create(?array $attributes = [])
    {
        $faker = Faker::create('fr_FR');
        return [
            'code_article' => $attributes['code_article'] ?? $faker->regexify('[a-zA-Z0-9]{4}'),
            'quantite' => $attributes['quantite'] ?? 1,
            'articles_prix' => $attributes['articles_prix'] ?? 29.9,
            'code_parent' => $attributes['code_parent'] ?? null,
            'acompte' => $attributes['acompte'] ?? null,
            'subvention_montant' => $attributes['subvention_montant'] ?? null,
            'subvention_payeur' => $attributes['subvention_payeur'] ?? $faker->word,
            'remise' => $attributes['remise'] ?? 3.0,
            'nature_client_id' => $attributes['nature_client_id'] ?? $faker->word,
            'categorie_place_code' => $attributes['categorie_place_code'] ?? $faker->word,
            'libelle_article' => $attributes['libelle_article'] ?? null,
            'famille_article' => $attributes['famille_article'] ?? null,
            'skier_index' => $attributes['skier_index'] ?? $faker->randomNumber(4),
        ];
    }
}
