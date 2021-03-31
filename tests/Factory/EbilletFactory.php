<?php

namespace SkiLoisirsDiffusion\Tests\Factory;

use Carbon\Carbon;
use Faker\Factory as Faker;

class EbilletFactory
{
    public static function create(?array $attributes = [])
    {
        $faker = Faker::create('fr_FR');
        return [
            'code_article' => $attributes['code_article'] ?? $faker->regexify('[a-zA-Z0-9]{4}'),
            'nom' => $attributes['nom'] ?? $faker->lastName,
            'prenom' => $attributes['prenom'] ?? $faker->firstName,
            'date' => $attributes['date'] ?? Carbon::now()->subday()->format('d/m/Y'),
            'date_naissance' => $attributes['date_naissance'] ?? Carbon::now()->subYears(rand(20, 50))->format('d/m/Y'),
            'keycard' => $attributes['keycard'] ?? $faker->word,
            'skier_index' => $attributes['skier_index'] ?? $faker->randomNumber(4),
        ];
    }
}
