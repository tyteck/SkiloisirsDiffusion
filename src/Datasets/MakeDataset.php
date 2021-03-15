<?php

namespace SkiLoisirsDiffusion\Datasets;

use stdClass;

class MakeDataset
{
    /** @var stdClass $dataset */
    protected $dataset;

    /** @var array $fields */
    protected $fields=[];

    private function __construct(array $attributes = [])
    {
        array_map(function ($fieldName, $fieldInfos) {
            dump($fieldName, $fieldInfos);
            $this->fields[] =  
        }, array_keys($attributes), $attributes);
    }

    public static function create(...$params)
    {
        return new static(...$params);
    }

    public function dataset()
    {
        return $this->dataset;
    }
}
