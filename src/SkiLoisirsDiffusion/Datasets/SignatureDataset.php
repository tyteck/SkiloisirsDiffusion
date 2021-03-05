<?php

namespace SkiLoisirsDiffusion\Datasets;

use InvalidArgumentException;
use SkiLoisirsDiffusion\Interfaces\Dataset;
use stdClass;

class SignatureDataset implements Dataset
{
    /** @var stdClass $dataset */
    protected $dataset;

    /** @var string $tablename */
    protected $tablename = 'signature';

    private function __construct(array $attributes = [])
    {
        $requiredParameters = [
            'code_livraison',
            'id_partenaire',
            'mode_paiement',
            'utilisateurs_adresse1',
            'utilisateurs_adresse_nom',
            'utilisateurs_codepostal',
            'utilisateurs_email',
            'utilisateurs_nom',
            'utilisateurs_prenom',
            'utilisateurs_ville',
            'clef_secrete',
        ];
        array_map(function ($requiredParameter) use ($attributes) {
            if (
                !isset($attributes[$requiredParameter]) ||
                !strlen($attributes[$requiredParameter])
            ) {
                throw new InvalidArgumentException("Parameter {$requiredParameter} is required to generate signature.", 1);
            }
        }, $requiredParameters);

        $this->signature = $this->generateSignature($attributes);

        $this->dataset = new stdClass();
        $this->dataset->schema = '
<xs:element name="' . $this->tablename . '">
    <xs:complexType>
        <xs:sequence>
            <xs:element name="signature" type="xs:string" minOccurs="0" />
        </xs:sequence>
    </xs:complexType>
</xs:element>
';

        $this->dataset->any = '
<' . $this->tablename . ' diffgr:id="' . $this->tablename . '1" msdata:rowOrder="0">
    <signature>' . $this->signature . '</signature>
</' . $this->tablename . '>
';
    }

    public static function create(...$params)
    {
        return new static(...$params);
    }

    public function schema():string
    {
        return $this->dataset->schema;
    }

    public function body():string
    {
        return $this->dataset->any;
    }

    public function dataset():stdClass
    {
        return $this->dataset;
    }

    public function generateSignature($attributes)
    {
        return sha1(
            array_reduce(
                $attributes,
                function ($carry, $attribute) {
                    if (strlen($carry)) {
                        $carry .= '+';
                    }
                    return $carry .= $attribute;
                }
            )
        );
    }
}
