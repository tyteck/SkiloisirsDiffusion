<?php

namespace SkiLoisirsDiffusion\Tests\Factory;

use Faker\Factory as Faker;
use SkiLoisirsDiffusion\Livraisons;

class OrderFactory
{
    public static function create(?array $attributes = [])
    {
        $faker = Faker::create('fr_FR');

        $codeLivraison = $attributes['code_livraison'] ?? null;
        $prixLivraison = $attributes['prix_livraison'] ?? null;

        if ($codeLivraison === null || $prixLivraison === null) {
            $deliveryModes = Livraisons::init(sldconfig('sld_domain_url'))->fromRemote()->deliveryModes();
            $randomIndex = rand(0, count($deliveryModes) - 1);
            $codeLivraison = $deliveryModes[$randomIndex]['code_livraison'];
            $prixLivraison = $deliveryModes[$randomIndex]['prix_livraison'];
        }

        return [
            'nb_cheques_vacances' => $attributes['nb_cheques_vacances'] ?? rand(0, 2),
            'montant_total_cheques_vacances' => $attributes['montant_total_cheques_vacances'] ?? $faker->randomFloat(2),
            'mode_paiement' => $attributes['mode_paiement'] ?? 'FCH',
            'prix_livraison' => $prixLivraison,
            'code_livraison' => $codeLivraison,
            'commentaire' => $attributes['commentaire'] ?? 'commentaire',
            'livraison_adresse_societe' => $attributes['livraison_adresse_societe'] ?? $faker->company,
            'livraison_adresse_nom' => $attributes['livraison_adresse_nom'] ?? $faker->lastName,
            'livraison_adresse1' => $attributes['livraison_adresse1'] ?? $faker->streetAddress,
            'livraison_adresse2' => $attributes['livraison_adresse2'] ?? $faker->streetSuffix,
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
