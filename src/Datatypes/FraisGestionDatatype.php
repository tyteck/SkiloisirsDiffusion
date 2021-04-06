<?php

namespace SkiLoisirsDiffusion\Datatypes;

use InvalidArgumentException;

class FraisGestionDatatype
{
    public ?int $nb_ebillets;
    public ?float $prix_ebillet;
    public ?int $nb_ebc;
    public ?float $prix_ebc;
    public ?int $nb_ebr;
    public ?float $prix_ebr;
    public ?int $nb_be;
    public ?float $prix_be;
    public ?int $nb_etickets;
    public ?float $prix_etickets;
    public ?int $nb_retraits;
    public ?float $prix_retraits;
    public ?float $remise_ebillets;
    public ?float $remise_ebc;
    public ?float $remise_ebr;
    public ?float $remise_be;
    public ?float $remise_etickets;
    public ?float $remise_retraits;
    public ?int $nb_cartes_cadeaux;
    public ?float $prix_carte_cadeau;
    public ?float $remise_cartes_cadeaux;
    public ?float $montant_plafond_commande;
    public ?int $nb_frais_gestion;
    public ?float $prix_frais_gestion;
    public ?int $nb_frais_demat;
    public ?float $prix_frais_demat;
    public ?int $nb_frais_papier;
    public ?float $prix_frais_papier;

    private function __construct(array $attributes = [])
    {
        foreach (array_keys(get_class_vars(self::class)) as $key) {
            $this->$key = $attributes[$key] ?? null;
        }
        $this->check();
    }

    public static function create(...$params)
    {
        return new static(...$params);
    }

    public function check()
    {
        $requiredFields = [
            'nb_ebillets',
            'prix_ebillet',
            'nb_ebc',
            'prix_ebc',
            'nb_ebr',
            'prix_ebr',
            'nb_be',
            'prix_be',
            'nb_etickets',
            'prix_etickets',
            'nb_retraits',
            'prix_retraits',
            'remise_ebillets',
            'remise_ebc',
            'remise_ebr',
            'remise_be',
            'remise_etickets',
            'remise_retraits',
            'nb_cartes_cadeaux',
            'prix_carte_cadeau',
            'remise_cartes_cadeaux',
            //'montant_plafond_commande',
            //'nb_frais_gestion',
            //'prix_frais_gestion',
            //'nb_frais_demat',
            //'prix_frais_demat',
            //'nb_frais_papier',
            //'prix_frais_papier',
        ];
        array_map(function ($field) {
            if ($this->$field === null) {
                throw new InvalidArgumentException("Field {$field} is required and cannot be null");
            }
        }, $requiredFields);
        return true;
    }
}
