<?php

namespace SkiLoisirsDiffusion\Tests\Factory;

use Carbon\Carbon;
use Faker\Factory as Faker;

class UserFactory
{
    public static function create(?array $attributes = [])
    {
        $faker = Faker::create('fr_FR');
        return [
            'id_partenaire' => $attributes['id_partenaire'] ?? '42',
            'utilisateurs_societe' => $attributes['utilisateurs_societe'] ?? null,
            'utilisateurs_civilite' => $attributes['utilisateurs_civilite'] ?? null,
            'utilisateurs_nom' => $faker->lastName,
            'utilisateurs_prenom' => $faker->firstName,
            'utilisateurs_telephone' => $faker->phoneNumber,
            'utilisateurs_portable' => $faker->phoneNumber,
            'utilisateurs_fax' => $attributes['utilisateurs_fax'] ?? null,
            'utilisateurs_email' => $faker->safeEmail,
            'utilisateurs_adresse_nom' => $faker->title,
            'utilisateurs_adresse1' => $faker->streetAddress,
            'utilisateurs_adresse2' => 'entrée b',
            'utilisateurs_codepostal' => $faker->postcode,
            'utilisateurs_ville' => $faker->city,
            'utilisateurs_pays' => 'France',
            'utilisateurs_date_naissance' => null, //Carbon::now()->subYears(rand(20, 50))->format('Y-m-d\Th:i:s'),
        ];
    }
}
