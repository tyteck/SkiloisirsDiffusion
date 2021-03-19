<?php

namespace SkiLoisirsDiffusion\Datasets;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use SkiLoisirsDiffusion\Exceptions\FieldMinOccursShouldBeGreaterThanZeroException;
use SkiLoisirsDiffusion\Exceptions\FieldNameShouldNotBeEmptyException;
use SkiLoisirsDiffusion\Exceptions\FieldTypeNotAllowedException;
use SkiLoisirsDiffusion\Exceptions\FieldValueDoesNotMatchWithTypeException;

class DatasetField
{
    /** @var string $fieldName */
    protected $fieldName;

    /** @var string $fieldType */
    protected $fieldType;

    /** @var int $fieldMinOccurs */
    protected $fieldMinOccurs = 0;

    /** @var bool $fieldRequired */
    protected $fieldRequired = true;

    /** @var mixed $fieldValue */
    protected $fieldValue;

    /** @var array $allowedFieldTypes */
    protected static $allowedFieldTypes = ['string', 'decimal', 'dateTime'];

    private function __construct(string $fieldName, string $fieldType, $fieldValue, int $fieldMinOccurs = 0, bool $fieldRequired = true)
    {
        if (!strlen($fieldName)) {
            throw new FieldNameShouldNotBeEmptyException('Field name should not be empty');
        }
        $this->fieldName = $fieldName;

        if (!in_array($fieldType, self::allowedFieldTypes())) {
            throw new FieldTypeNotAllowedException("Field type {$fieldType} not allowed. Are allowed : " . implode(', ', self::allowedFieldTypes()));
        }
        $this->fieldType = "xs:{$fieldType}";

        if ($fieldMinOccurs < 0) {
            throw new FieldMinOccursShouldBeGreaterThanZeroException("Field type {$fieldType} not allowed. Are allowed : " . implode(', ', self::allowedFieldTypes()));
        }
        $this->fieldMinOccurs = $fieldMinOccurs;

        $this->fieldValue = $fieldValue;
        if (!$this->isValueMatchingType()) {
            throw new FieldValueDoesNotMatchWithTypeException("We were expecting type {$fieldType} and we got {$fieldValue}.");
        }

        $this->fieldRequired = $fieldRequired;
    }

    public static function create(...$params)
    {
        return new static(...$params);
    }

    public function fieldName()
    {
        return $this->fieldName;
    }

    public function fieldType()
    {
        return $this->fieldType;
    }

    public function fieldValue()
    {
        return $this->fieldValue;
    }

    public function fieldMinOccurs()
    {
        return $this->fieldMinOccurs;
    }

    public function fieldRequired()
    {
        return $this->fieldRequired;
    }

    public function renderSchema()
    {
        return '<xs:element name="' . $this->fieldName() . '" type="' . $this->fieldType() . '" minOccurs="' . $this->fieldMinOccurs() . '"/>';
    }

    public function renderBody()
    {
        return "<{$this->fieldName()}>{$this->fieldValue}</{$this->fieldName()}>";
    }

    public function isValueMatchingType()
    {
        if ($this->fieldType() == 'xs:string') {
            return strlen($this->fieldValue);
        }

        if ($this->fieldType() == 'xs:decimal') {
            return is_float($this->fieldValue);
        }

        if ($this->fieldType() == 'xs:dateTime') {
            try {
                $isItADate = Carbon::parse($this->fieldValue);
            } catch (InvalidFormatException $exception) {
                return false;
            }
            $this->fieldValue = $isItADate->format(sldconfig('datetime_format'));
            return true;
        }
    }

    public static function allowedFieldTypes()
    {
        return self::$allowedFieldTypes;
    }
}
