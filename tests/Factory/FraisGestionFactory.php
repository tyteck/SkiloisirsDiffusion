<?php

namespace SkiLoisirsDiffusion\Tests\Factory;

use Faker\Factory as Faker;

class FraisGestionFactory
{
    public static function create(?array $attributes = [])
    {
        $faker = Faker::create('fr_FR');
        return [
            'nb_ebillets' => $attributes['nb_ebillets'] ?? 0,
            'prix_ebillet' => $attributes['prix_ebillet'] ?? 0,
            'nb_ebc' => $attributes['nb_ebc'] ?? 0,
            'prix_ebc' => $attributes['prix_ebc'] ?? 0,
            'nb_ebr' => $attributes['nb_ebr'] ?? 0,
            'prix_ebr' => $attributes['prix_ebr'] ?? 0,
            'nb_be' => $attributes['nb_be'] ?? 0,
            'prix_be' => $attributes['prix_be'] ?? 0,
            'nb_etickets' => $attributes['nb_etickets'] ?? 0,
            'prix_etickets' => $attributes['prix_etickets'] ?? 0,
            'nb_retraits' => $attributes['nb_retraits'] ?? 0,
            'prix_retraits' => $attributes['prix_retraits'] ?? 0,
            'remise_ebillets' => $attributes['remise_ebillets'] ?? 0.0,
            'remise_ebc' => $attributes['remise_ebc'] ?? 0.0,
            'remise_ebr' => $attributes['remise_ebr'] ?? 0.0,
            'remise_be' => $attributes['remise_be'] ?? 0.0,
            'remise_etickets' => $attributes['remise_etickets'] ?? 0.0,
            'remise_retraits' => $attributes['remise_retraits'] ?? 0.0,
            'nb_cartes_cadeaux' => $attributes['nb_cartes_cadeaux'] ?? 0,
            'prix_carte_cadeau' => $attributes['prix_carte_cadeau'] ?? 0.0,
            'remise_cartes_cadeaux' => $attributes['remise_cartes_cadeaux'] ?? 0.0,
            'montant_plafond_commande' => $attributes['montant_plafond_commande'] ?? 0.0,
            'nb_frais_gestion' => $attributes['nb_frais_gestion'] ?? $faker->numberBetween(0, 1),
            'prix_frais_gestion' => $attributes['prix_frais_gestion'] ?? 0.0,
            'nb_frais_demat' => $attributes['nb_frais_demat'] ?? $faker->numberBetween(0, 1),
            'prix_frais_demat' => $attributes['prix_frais_demat'] ?? 0.0,
            'nb_frais_papier' => $attributes['nb_frais_papier'] ?? $faker->numberBetween(0, 1),
            'prix_frais_papier' => $attributes['prix_frais_papier'] ?? 0.0,
        ];
    }
}
