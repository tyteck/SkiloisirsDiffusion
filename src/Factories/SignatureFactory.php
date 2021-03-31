<?php

namespace SkiLoisirsDiffusion\Factories;

use SkiLoisirsDiffusion\Datasets\DatasetField;
use SkiLoisirsDiffusion\Datasets\DatasetTable;

class SignatureFactory
{
    /** @var string $signature */
    protected $signature;

    private function __construct(array $order, array $user, string $clefSecrete)
    {
        $createSignatureParameters = [
            'code_livraison' => $order['code_livraison'],
            'id_partenaire' => $user['id_partenaire'],
            'mode_paiement' => $order['mode_paiement'],
            'utilisateurs_adresse1' => $user['utilisateurs_adresse1'],
            'utilisateurs_adresse_nom' => $user['utilisateurs_adresse_nom'],
            'utilisateurs_codepostal' => $user['utilisateurs_codepostal'],
            'utilisateurs_email' => $user['utilisateurs_email'],
            'utilisateurs_nom' => $user['utilisateurs_nom'],
            'utilisateurs_prenom' => $user['utilisateurs_prenom'],
            'utilisateurs_ville' => $user['utilisateurs_ville'],
            'clef_secrete' => $clefSecrete,
        ];

        $this->signature = generateSignature($createSignatureParameters);
    }

    public static function create(array $order, array $user, string $clefSecrete)
    {
        return new static($order, $user, $clefSecrete);
    }

    public function signature()
    {
        return $this->signature;
    }

    public function datasetTable()
    {
        return DatasetTable::create('signature')
            ->addDatasetFields(
                [
                    DatasetField::create('signature', 'string', $this->signature),
                ]
            );
    }
}
