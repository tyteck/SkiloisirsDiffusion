<?php

namespace SkiLoisirsDiffusion\Datasets;

use SkiLoisirsDiffusion\Exceptions\FieldMinOccursShouldBeGreaterThanZeroException;
use SkiLoisirsDiffusion\Exceptions\FieldNameShouldNotBeEmptyException;
use SkiLoisirsDiffusion\Exceptions\FieldTypeNotAllowedException;

class DatasetFieldType
{
    /** @var string $fieldName */
    protected $fieldName;

    /** @var string $fieldType */
    protected $fieldType;

    /** @var int $fieldMinOccurs */
    protected $fieldMinOccurs = 0;

    /** @var bool $fieldRequired */
    protected $fieldRequired = true;

    protected $allowedFieldTypes = [
        'string',
    ];

    private function __construct(string $fieldName, string $fieldType, int $fieldMinOccurs = 0, bool $fieldRequired = true)
    {
        if (!strlen($fieldName)) {
            throw new FieldNameShouldNotBeEmptyException('Field name should not be empty');
        }
        $this->fieldName = $fieldName;

        if (!in_array($fieldType, $this->allowedFieldTypes)) {
            throw new FieldTypeNotAllowedException("Field type {$fieldType} not allowed. Are allowed : " . implode(', ', $this->allowedFieldTypes));
        }
        $this->fieldType = $fieldType;

        if ($fieldMinOccurs < 0) {
            throw new FieldMinOccursShouldBeGreaterThanZeroException("Field type {$fieldType} not allowed. Are allowed : " . implode(', ', $this->allowedFieldTypes));
        }
        $this->fieldMinOccurs = $fieldMinOccurs;

        $this->fieldRequired = $fieldRequired;
    }

    public static function create(string $fieldName, string $fieldType, int $fieldMinOccurs = 0, bool $fieldRequired = true)
    {
        return new static($fieldName, $fieldType, $fieldMinOccurs,  $fieldRequired);
    }

    public function fieldName()
    {
        return $this->fieldName;
    }

    public function fieldType()
    {
        return $this->fieldType;
    }

    public function fieldMinOccurs()
    {
        return $this->fieldMinOccurs;
    }

    public function fieldRequired()
    {
        return $this->fieldRequired;
    }
}
