<?php

namespace SkiLoisirsDiffusion\Datatypes;

use InvalidArgumentException;

class OrderDatatype
{
    public ?string $nb_cheques_vacances;
    public ?string $montant_total_cheques_vacances;
    public ?string $mode_paiement;
    public ?float $prix_livraison;
    public ?string $code_livraison;
    public ?string $commentaire;
    public ?string $livraison_adresse_societe;
    public ?string $livraison_adresse_nom;
    public ?string $livraison_adresse1;
    public ?string $livraison_adresse2;
    public ?string $livraison_codepostal;
    public ?string $livraison_ville;
    public ?string $livraison_pays;
    public ?string $url_retour;
    public ?string $url_retour_ok;
    public ?string $url_retour_err;
    public ?float $acompte;
    public ?string $numero_commande_ticketnet;
    public ?string $frais_gestion_payeur;
    public ?string $frais_port_payeur;
    public ?float $remise_frais_port;
    public ?string $numero_commande_distributeur;

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
            'nb_cheques_vacances',
            'montant_total_cheques_vacances',
            'mode_paiement',
            'prix_livraison',
            'code_livraison',
            //'commentaire',
            'livraison_adresse_societe',
            'livraison_adresse_nom',
            'livraison_adresse1',
            'livraison_adresse2',
            'livraison_codepostal',
            'livraison_ville',
            //'livraison_pays',
            //'url_retour',
            //'url_retour_ok',
            //'url_retour_err',
            //'acompte',
            //'numero_commande_ticketnet',
            //'frais_gestion_payeur',
            //'frais_port_payeur',
            //'remise_frais_port',
            //'numero_commande_distributeur',
        ];
        array_map(function ($field) {
            if ($this->$field === null) {
                throw new InvalidArgumentException("Field {$field} is required and cannot be null");
            }
        }, $requiredFields);
    }
}
