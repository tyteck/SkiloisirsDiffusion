<?php

namespace SkiLoisirsDiffusion\Datatypes;

use InvalidArgumentException;

class CeDatatype
{
    public ?string $ce_id;
    public ?string $ce_societe;
    public ?string $ce_civilite;
    public ?string $ce_nom;
    public ?string $ce_prenom;
    public ?string $ce_telephone;
    public ?string $ce_portable;
    public ?string $ce_fax;
    public ?string $ce_email;
    public ?string $ce_adresse_nom;
    public ?string $ce_adresse1;
    public ?string $ce_adresse2;
    public ?string $ce_codepostal;
    public ?string $ce_ville;
    public ?string $ce_pays;

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
            'ce_id',
            'ce_societe',
            //'ce_civilite',
            'ce_nom',
            'ce_prenom',
            //'ce_telephone',
            //'ce_portable',
            //'ce_fax',
            'ce_email',
            //'ce_adresse_nom',
            //'ce_adresse1',
            //'ce_adresse2',
            'ce_codepostal',
            'ce_ville',
            //'ce_pays',
        ];
        array_map(function ($field) {
            if ($this->$field === null) {
                throw new InvalidArgumentException("Field {$field} is required and cannot be null");
            }
        }, $requiredFields);
        return true;
    }
}
