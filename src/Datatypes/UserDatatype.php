<?php

namespace SkiLoisirsDiffusion\Datatypes;

use InvalidArgumentException;

class UserDatatype
{
    public ?string $id_partenaire;
    public ?string $utilisateurs_societe;
    public ?string $utilisateurs_civilite;
    public ?string $utilisateurs_nom;
    public ?string $utilisateurs_prenom;
    public ?string $utilisateurs_telephone;
    public ?string $utilisateurs_portable;
    public ?string $utilisateurs_fax;
    public ?string $utilisateurs_email;
    public ?string $utilisateurs_adresse_nom;
    public ?string $utilisateurs_adresse1;
    public ?string $utilisateurs_adresse2;
    public ?string $utilisateurs_codepostal;
    public ?string $utilisateurs_ville;
    public ?string $utilisateurs_pays;
    public ?\Carbon\Carbon $utilisateurs_date_naissance;

    private function __construct(array $attributes = [])
    {
        $this->id_partenaire = $attributes['id_partenaire'] ?? null;
        $this->utilisateurs_societe = $attributes['utilisateurs_societe'] ?? null;
        $this->utilisateurs_civilite = $attributes['utilisateurs_civilite'] ?? null;
        $this->utilisateurs_nom = $attributes['utilisateurs_nom'] ?? null;
        $this->utilisateurs_prenom = $attributes['utilisateurs_prenom'] ?? null;
        $this->utilisateurs_telephone = $attributes['utilisateurs_telephone'] ?? null;
        $this->utilisateurs_portable = $attributes['utilisateurs_portable'] ?? null;
        $this->utilisateurs_fax = $attributes['utilisateurs_fax'] ?? null;
        $this->utilisateurs_email = $attributes['utilisateurs_email'] ?? null;
        $this->utilisateurs_adresse_nom = $attributes['utilisateurs_adresse_nom'] ?? null;
        $this->utilisateurs_adresse1 = $attributes['utilisateurs_adresse1'] ?? null;
        $this->utilisateurs_adresse2 = $attributes['utilisateurs_adresse2'] ?? null;
        $this->utilisateurs_codepostal = $attributes['utilisateurs_codepostal'] ?? null;
        $this->utilisateurs_ville = $attributes['utilisateurs_ville'] ?? null;
        $this->utilisateurs_pays = $attributes['utilisateurs_pays'] ?? null;
        $this->utilisateurs_date_naissance = $attributes['utilisateurs_date_naissance'] ?? null;
        $this->check();
    }

    public static function create(...$params)
    {
        return new static(...$params);
    }

    public function check()
    {
        $requiredFields = [
            'id_partenaire',
            'utilisateurs_societe',
            'utilisateurs_civilite',
            'utilisateurs_nom',
            'utilisateurs_prenom',
            'utilisateurs_telephone',
            'utilisateurs_portable',
            'utilisateurs_fax',
            'utilisateurs_email',
            'utilisateurs_adresse_nom',
            'utilisateurs_adresse1',
            'utilisateurs_adresse2',
            'utilisateurs_codepostal',
            'utilisateurs_ville',
            'utilisateurs_pays',
            'utilisateurs_date_naissance',
        ];
        array_map(function ($field) {
            if ($this->$field === null) {
                throw new InvalidArgumentException("Field {$field} is required and cannot be null");
            }
        }, $requiredFields);

        if (get_class($this->utilisateurs_date_naissance) !== 'Carbon\Carbon') {
            throw new InvalidArgumentException("Field utilisateurs_date_naissance should be a Carbon\Carbon object.");
        }
    }
}
