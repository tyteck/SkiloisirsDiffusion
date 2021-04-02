<?php

namespace SkiLoisirsDiffusion\DatasetTables;

use SkiLoisirsDiffusion\Datasets\DatasetField;
use SkiLoisirsDiffusion\Datatypes\OrderDatatype;
use SkiLoisirsDiffusion\Datatypes\UserDatatype;

class SignatureDatasetTable extends DatasetTable
{
    /** @var string $tablename */
    protected static $tablename = 'signature';

    public ?string $signature;

    public static function prepare()
    {
        return new self(static::$tablename);
    }

    public function with(OrderDatatype $order, UserDatatype $user, string $clefSecrete): self
    {
        $createSignatureParameters = [
            'code_livraison' => $order->code_livraison,
            'id_partenaire' => $user->id_partenaire,
            'mode_paiement' => $order->mode_paiement,
            'utilisateurs_adresse1' => $user->utilisateurs_adresse1,
            'utilisateurs_adresse_nom' => $user->utilisateurs_adresse_nom,
            'utilisateurs_codepostal' => $user->utilisateurs_codepostal,
            'utilisateurs_email' => $user->utilisateurs_email,
            'utilisateurs_nom' => $user->utilisateurs_nom,
            'utilisateurs_prenom' => $user->utilisateurs_prenom,
            'utilisateurs_ville' => $user->utilisateurs_ville,
            'clef_secrete' => $clefSecrete,
        ];
        $this->signature = generateSignature($createSignatureParameters);
        $this->addDatasetFields(
            [
                DatasetField::create('signature', 'string', $this->signature),
            ]
        );

        return $this;
    }

    public function signature()
    {
        return $this->signature;
    }
}
