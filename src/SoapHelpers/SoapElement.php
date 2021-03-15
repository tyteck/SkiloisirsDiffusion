<?php

namespace SkiLoisirsDiffusion\SoapHelpers;

class SoapElement
{
    /** @var string $name */
    protected $name;

    /** @var mixed $value */
    protected $value;

    /** @var string $type */
    protected $type;

    /** @var int $minOccurs */
    protected $minOccurs;

    private function __construct(string $name, $value, string $type = 'string', $minOccurs = 0)
    {
        $this->name = $name;
        $this->value = $value;
        $this->type = $type;
        $this->minOccurs = $minOccurs;
    }

    public static function create(...$params)
    {
        return new static(...$params);
    }

    public function schema()
    {
        return '<xs:element name="' . $this->name . '" type="xs:' . $this->type . '" minOccurs="' . $this->minOccurs . '" />';
    }

    public function body()
    {
        return "<{$this->name}>{$this->value}</{$this->name}>";
    }
}
