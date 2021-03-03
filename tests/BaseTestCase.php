<?php

namespace SkiLoisirsDiffusion\Tests;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use SkiLoisirsDiffusion\Datasets\OrderDataset;
use SkiLoisirsDiffusion\Datasets\UserDataset;

class BaseTestCase extends TestCase
{
    public function createUserDataset()
    {
        return UserDataset::create(
            [
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
            ]
        );
    }

    public function createOrderDataset()
    {
        return OrderDataset::create(
            [
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
            ]
        );
    }
}
