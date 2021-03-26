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
            ];
        }
        return $this;
    }

    public function deliveryModes()
    {
        return $this->deliveryModes;
    }
}
