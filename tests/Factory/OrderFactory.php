<?php

namespace SkiLoisirsDiffusion\Tests\Factory;

use Faker\Factory as Faker;

class OrderFactory
{
    public static function create(?array $attributes = [])
    {
        $faker = Faker::create('fr_FR');
        return [
            'nb_cheques_vacances' => $attributes['nb_cheques_vacances'] ?? rand(0, 2),
            'montant_total_cheques_vacances' => $attributes['montant_total_cheques_vacances'] ?? $faker->randomFloat(2),
            'mode_paiement' => $attributes['mode_paiement'] ?? 'FCH',
            'prix_livraison' => $attributes['prix_livraison'] ?? 6.5,
            'code_livraison' => $attributes['code_livraison'] ?? 'xbx',
            'commentaire' => $attributes['commentaire'] ?? 'commentaire',
            'livraison_adresse_societe' => $attributes['livraison_adresse_societe'] ?? $faker->company,
            'livraison_adresse_nom' => $attributes['livraison_adresse_nom'] ?? $faker->lastName,
            'livraison_adresse_1' => $attributes['livraison_adresse_1'] ?? $faker->streetAddress,
            'livraison_adresse_2' => $attributes['livraison_adresse_2'] ?? $faker->streetSuffix,
            'livraison_codepostal' => $attributes['livraison_codepostal'] ?? $faker->postcode,
            'livraison_ville' => $attributes['livraison_ville'] ?? $faker->city,
            'livraison_pays' => $attributes['livraison_pays'] ?? 'France',
            'url_retour' => $attributes['url_retour'] ?? $faker->url,
            'url_retour_ok' => $attributes['url_retour_ok'] ?? $faker->url,
            'url_retour_err' => $attributes['url_retour_err'] ?? $faker->url,
            'acompte' => $attributes['acompte'] ?? 0.0,
            'numero_commande_ticketnet' => $attributes['numero_commande_ticketnet'] ?? '',
            'frais_gestion_payeur' => $attributes['frais_gestion_payeur'] ?? 'ayant_droit',
            'frais_port_payeur' => $attributes['frais_port_payeur'] ?? 'ayant_droit',
            'remise_frais_port' => $attributes['remise_frais_port'] ?? 0.0,
            'numero_commande_distributeur' => $attributes['numero_commande_distributeur'] ?? 'no commande distributeur',
        ];
    }
}
