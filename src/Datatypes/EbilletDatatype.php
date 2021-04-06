<?php

namespace SkiLoisirsDiffusion\Datatypes;

use InvalidArgumentException;

class EbilletDatatype
{
    public ?string $code_article;
    public ?string $nom;
    public ?string $prenom;
    public ?string $date;
    public ?string $date_naissance;
    public ?string $keycard;
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
            'nom',
            'prenom',
            'date',
            'date_naissance',
            'keycard',
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
