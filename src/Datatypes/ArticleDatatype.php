<?php

namespace SkiLoisirsDiffusion\Datatypes;

use InvalidArgumentException;

class ArticleDatatype
{
    public ?string $code_article;
    public ?int $quantite;
    public ?float $articles_prix;
    public ?string $code_parent;
    public ?float $acompte;
    public ?string $subvention_montant;
    public ?string $subvention_payeur;
    public ?float $remise;
    public ?string $nature_client_id;
    public ?string $categorie_place_code;
    public ?string $libelle_article;
    public ?string $famille_article;
    public ?int $skier_index;

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
            'code_article',
            'quantite',
            'articles_prix',
            //'code_parent',
            //'acompte',
            //'subvention_montant',
            'subvention_payeur',
            'remise',
            'nature_client_id',
            'categorie_place_code',
            //'libelle_article',
            //'famille_article',
            'skier_index',
        ];
        array_map(function ($field) {
            if ($this->$field === null) {
                throw new InvalidArgumentException("Field {$field} is required and cannot be null");
            }
        }, $requiredFields);
        return true;
    }
}
