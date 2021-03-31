<?php

namespace SkiLoisirsDiffusion\Factories;

use SkiLoisirsDiffusion\Datasets\DatasetField;
use SkiLoisirsDiffusion\Datasets\DatasetTable;

class OrderDatasetTableFactory
{
    public static function create(array $order): DatasetTable
    {
        return DatasetTable::create('commande')
            ->addDatasetFields(
                [
                    DatasetField::create('nb_cheques_vacances', 'string', $order['nb_cheques_vacances']),
                    DatasetField::create('montant_total_cheques_vacances', 'string', $order['montant_total_cheques_vacances']),
                    DatasetField::create('mode_paiement', 'string', $order['mode_paiement']),
                    DatasetField::create('prix_livraison', 'decimal', $order['prix_livraison']),
                    DatasetField::create('code_livraison', 'string', $order['code_livraison']),
                    DatasetField::create('commentaire', 'string', $order['commentaire'], 0, false),
                    DatasetField::create('livraison_adresse_societe', 'string', $order['livraison_adresse_societe']),
                    DatasetField::create('livraison_adresse_nom', 'string', $order['livraison_adresse_nom']),
                    DatasetField::create('livraison_adresse1', 'string', $order['livraison_adresse1']),
                    DatasetField::create('livraison_adresse2', 'string', $order['livraison_adresse2']),
                    DatasetField::create('livraison_codepostal', 'string', $order['livraison_codepostal']),
                    DatasetField::create('livraison_ville', 'string', $order['livraison_ville']),
                    DatasetField::create('livraison_pays', 'string', $order['livraison_pays'], 0, false),
                    DatasetField::create('url_retour', 'string', $order['url_retour'], 0, false),
                    DatasetField::create('url_retour_ok', 'string', $order['url_retour_ok'], 0, false),
                    DatasetField::create('url_retour_err', 'string', $order['url_retour_err'], 0, false),
                    DatasetField::create('acompte', 'decimal', $order['acompte'], 0, false),
                    DatasetField::create('numero_commande_ticketnet', 'string', $order['numero_commande_ticketnet'], 0, false),
                    DatasetField::create('frais_gestion_payeur', 'string', $order['frais_gestion_payeur'], 0, false),
                    DatasetField::create('frais_port_payeur', 'string', $order['frais_port_payeur'], 0, false),
                    DatasetField::create('remise_frais_port', 'decimal', $order['remise_frais_port'], 0, false),
                    DatasetField::create('numero_commande_distributeur', 'string', $order['numero_commande_distributeur'], 0, false),
                ]
            );
    }
}
