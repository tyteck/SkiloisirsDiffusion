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
    public ?string $utilisateurs_date_naissance;

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
            'id_partenaire',
            //'utilisateurs_societe',
            //'utilisateurs_civilite',
            'utilisateurs_nom',
            'utilisateurs_prenom',
            'utilisateurs_telephone',
            'utilisateurs_portable',
            //'utilisateurs_fax',
            'utilisateurs_email',
            //'utilisateurs_adresse_nom',
            'utilisateurs_adresse1',
            //'utilisateurs_adresse2',
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
    }
}
