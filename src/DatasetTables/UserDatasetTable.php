<?php

namespace SkiLoisirsDiffusion\DatasetTables;

use SkiLoisirsDiffusion\Datasets\DatasetField;
use SkiLoisirsDiffusion\Datatypes\UserDatatype;

class UserDatasetTable extends DatasetTable
{
    /** @var string $tablename */
    protected static $tablename = 'utilisateur';

    public static function prepare()
    {
        return new self(static::$tablename);
    }

    public function with(UserDatatype $user): self
    {
        $this->addDatasetFields(
            [
                DatasetField::create('id_partenaire', 'string', $user->id_partenaire),
                DatasetField::create('utilisateurs_societe', 'string', $user->utilisateurs_societe, 0, false),
                DatasetField::create('utilisateurs_civilite', 'string', $user->utilisateurs_civilite, 0, false),
                DatasetField::create('utilisateurs_nom', 'string', $user->utilisateurs_nom),
                DatasetField::create('utilisateurs_prenom', 'string', $user->utilisateurs_prenom),
                DatasetField::create('utilisateurs_telephone', 'string', $user->utilisateurs_telephone),
                DatasetField::create('utilisateurs_portable', 'string', $user->utilisateurs_portable),
                DatasetField::create('utilisateurs_fax', 'string', $user->utilisateurs_fax, 0, false),
                DatasetField::create('utilisateurs_email', 'string', $user->utilisateurs_email),
                DatasetField::create('utilisateurs_adresse_nom', 'string', $user->utilisateurs_adresse_nom),
                DatasetField::create('utilisateurs_adresse1', 'string', $user->utilisateurs_adresse1),
                DatasetField::create('utilisateurs_adresse2', 'string', $user->utilisateurs_adresse2),
                DatasetField::create('utilisateurs_codepostal', 'string', $user->utilisateurs_codepostal),
                DatasetField::create('utilisateurs_ville', 'string', $user->utilisateurs_ville),
                DatasetField::create('utilisateurs_pays', 'string', $user->utilisateurs_pays),
                DatasetField::create('utilisateurs_date_naissance', 'dateTime', $user->utilisateurs_date_naissance),
            ]
        );
        return $this;
    }
}
