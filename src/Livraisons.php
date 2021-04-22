<?php

namespace SkiLoisirsDiffusion;

use SimpleXMLElement;

class Livraisons
{
    /** @var string $sldDomainUrl */
    protected $sldDomainUrl;

    /** @var array $deliveryModes */
    protected $deliveryModes = [];

    private function __construct(string $sldDomainUrl)
    {
        $this->sldDomainUrl = $sldDomainUrl;
    }

    public static function init(...$params)
    {
        return new static(...$params);
    }

    public function fromRemote()
    {
        $fileContent = file_get_contents($this->sldDomainUrl . '/flux_livraisons.aspx?catalogues=reducce.fr');
        $deliveryModes = new SimpleXMLElement($fileContent);

        foreach ($deliveryModes as $deliveryMode) {
            $this->deliveryModes[] = [
                'code_livraison' => trim($deliveryMode->livraisons_code),
                'prix_livraison' => (float)trim(str_replace(',', '.', $deliveryMode->livraisons_puttc)),
                'livraisons_maximum' => (int)trim($deliveryMode->livraisons_maximum),
            ];
        }
        return $this;
    }

    public function fromLocal()
    {
        $this->deliveryModes = [
            [
                'code_livraison' => 'LS20G',
                'prix_livraison' => 3.5,
                'livraisons_maximum' => 4,
            ],
            [
                'code_livraison' => 'LS50G',
                'prix_livraison' => 4.5,
                'livraisons_maximum' => 10,
            ],
            [
                'code_livraison' => 'LS100G',
                'prix_livraison' => 6.0,
                'livraisons_maximum' => 20,
            ],
            [
                'code_livraison' => 'LS250G',
                'prix_livraison' => 7.5,
                'livraisons_maximum' => 70,
            ],
            [
                'code_livraison' => 'LS500G',
                'prix_livraison' => 8.5,
                'livraisons_maximum' => 150,
            ],
            [
                'code_livraison' => 'LS1000G',
                'prix_livraison' => 10.5,
                'livraisons_maximum' => 300,
            ],
            [
                'code_livraison' => 'AR150',
                'prix_livraison' => 8.5,
                'livraisons_maximum' => 153,
            ],
            [
                'code_livraison' => 'AR450',
                'prix_livraison' => 9.5,
                'livraisons_maximum' => 458,
            ],
            [
                'code_livraison' => 'AR900',
                'prix_livraison' => 15.0,
                'livraisons_maximum' => 900,
            ],
            [
                'code_livraison' => 'AR1800',
                'prix_livraison' => 30.0,
                'livraisons_maximum' => 1832,
            ],
            [
                'code_livraison' => 'AR3600',
                'prix_livraison' => 32.9,
                'livraisons_maximum' => 3664,
            ],
            [
                'code_livraison' => 'AR7300',
                'prix_livraison' => 39.9,
                'livraisons_maximum' => 7328,
            ],
            [
                'code_livraison' => 'AR14600',
                'prix_livraison' => 59.9,
                'livraisons_maximum' => 14656,
            ],
            [
                'code_livraison' => 'TP2000G',
                'prix_livraison' => 35.0,
                'livraisons_maximum' => 301,
            ],
            [
                'code_livraison' => 'PEXPORT',
                'prix_livraison' => 10.0,
                'livraisons_maximum' => 20,
            ],
            [
                'code_livraison' => 'DISPO1',
                'prix_livraison' => 0.0,
                'livraisons_maximum' => 1,
            ],
            [
                'code_livraison' => 'DISPO2',
                'prix_livraison' => 0.0,
                'livraisons_maximum' => 1,
            ],
            [
                'code_livraison' => 'RETRAITMAGASIN',
                'prix_livraison' => 1.9,
                'livraisons_maximum' => 1,
            ]
        ];
        return $this;
    }

    public function deliveryModes()
    {
        return $this->deliveryModes;
    }
}
