<?php

namespace SkiLoisirsDiffusion\DatasetTables;

use SkiLoisirsDiffusion\Datasets\DatasetField;
use SkiLoisirsDiffusion\Datatypes\FraisGestionDatatype;

class FraisGestionDatasetTable extends DatasetTable
{
    /** @var string $tablename */
    protected static $tablename = 'frais_gestion';

    public static function prepare()
    {
        return new self(static::$tablename);
    }

    public function with(FraisGestionDatatype $fraisGestion): self
    {
        $this->addDatasetFields(
            [
                DatasetField::create('nb_ebillets', 'int32', $fraisGestion->nb_ebillets),
                DatasetField::create('prix_ebillet', 'decimal', $fraisGestion->prix_ebillet),
                DatasetField::create('nb_ebc', 'int32', $fraisGestion->nb_ebc),
                DatasetField::create('prix_ebc', 'decimal', $fraisGestion->prix_ebc),
                DatasetField::create('nb_ebr', 'int32', $fraisGestion->nb_ebr),
                DatasetField::create('prix_ebr', 'decimal', $fraisGestion->prix_ebr),
                DatasetField::create('nb_be', 'int32', $fraisGestion->nb_be),
                DatasetField::create('prix_be', 'decimal', $fraisGestion->prix_be),
                DatasetField::create('nb_etickets', 'int32', $fraisGestion->nb_etickets),
                DatasetField::create('prix_etickets', 'decimal', $fraisGestion->prix_etickets),
                DatasetField::create('nb_retraits', 'int32', $fraisGestion->nb_retraits),
                DatasetField::create('prix_retraits', 'decimal', $fraisGestion->prix_retraits),
                DatasetField::create('remise_ebillets', 'decimal', $fraisGestion->remise_ebillets),
                DatasetField::create('remise_ebc', 'decimal', $fraisGestion->remise_ebc),
                DatasetField::create('remise_ebr', 'decimal', $fraisGestion->remise_ebr),
                DatasetField::create('remise_be', 'decimal', $fraisGestion->remise_be),
                DatasetField::create('remise_etickets', 'decimal', $fraisGestion->remise_etickets),
                DatasetField::create('remise_retraits', 'decimal', $fraisGestion->remise_retraits),
                DatasetField::create('nb_cartes_cadeaux', 'int32', $fraisGestion->nb_cartes_cadeaux),
                DatasetField::create('prix_carte_cadeau', 'decimal', $fraisGestion->prix_carte_cadeau),
                DatasetField::create('remise_cartes_cadeaux', 'decimal', $fraisGestion->remise_cartes_cadeaux),
                DatasetField::create('montant_plafond_commande', 'decimal', $fraisGestion->montant_plafond_commande, 0, false),
                DatasetField::create('nb_frais_gestion', 'int32', $fraisGestion->nb_frais_gestion, 0, false),
                DatasetField::create('prix_frais_gestion', 'decimal', $fraisGestion->prix_frais_gestion, 0, false),
                DatasetField::create('nb_frais_demat', 'int32', $fraisGestion->nb_frais_demat, 0, false),
                DatasetField::create('prix_frais_demat', 'decimal', $fraisGestion->prix_frais_demat, 0, false),
                DatasetField::create('nb_frais_papier', 'int32', $fraisGestion->nb_frais_papier, 0, false),
                DatasetField::create('prix_frais_papier', 'decimal', $fraisGestion->prix_frais_papier, 0, false),
            ]
        );
        return $this;
    }
}
