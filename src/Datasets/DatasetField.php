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
    protected static $allowedFieldTypes = [
        'string' => 'xs:string',
        'decimal' => 'xs:decimal',
        'dateTime' => 'xs:dateTime',
        'int32' => 'xs:int',
        'int64' => 'xs:long',
    ];

    private function __construct(string $fieldName, string $fieldType, $fieldValue, int $fieldMinOccurs = 0, bool $fieldRequired = true)
    {
        if (!strlen($fieldName)) {
            throw new FieldNameShouldNotBeEmptyException('Field name should not be empty');
        }
        $this->fieldName = $fieldName;

        if (!array_key_exists($fieldType, self::allowedFieldTypes())) {
            throw new FieldTypeNotAllowedException("Field type {$fieldType} not allowed. Are allowed : " . implode(', ', array_keys(self::allowedFieldTypes())));
        }
        $this->fieldType = self::allowedFieldTypes()[$fieldType];

        if ($fieldMinOccurs < 0) {
            throw new FieldMinOccursShouldBeGreaterThanZeroException('Field min occurs should be greater or equal to 0.');
        }
        $this->fieldMinOccurs = $fieldMinOccurs;

        $this->fieldRequired = $fieldRequired;
        $this->fieldValue = $fieldValue;
        if (!$this->isValueMatchingType()) {
            throw new FieldValueDoesNotMatchWithTypeException("Field {$fieldName} is expecting type {$fieldType} and we got {$fieldValue}.");
        }
    }

    public static function create(string $fieldName, string $fieldType, $fieldValue, int $fieldMinOccurs = 0, bool $fieldRequired = true)
    {
        return new static($fieldName, $fieldType, $fieldValue, $fieldMinOccurs, $fieldRequired);
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
        $result = "<xs:element name=\"{$this->fieldName()}\" type=\"{$this->fieldType()}\" minOccurs=\"{$this->fieldMinOccurs()}\"";
        $result .= $this->fieldRequired() === false ? ' nillable="true"' : '';
        $result .= '/>';
        return $result;
    }

    public function renderBody()
    {
        return "<{$this->fieldName()}>{$this->fieldValue}</{$this->fieldName()}>";
    }

    public function isValueMatchingType(): bool
    {
        if (!$this->fieldRequired()) {
            return true;
        }

        if ($this->fieldType() == 'xs:string') {
            return strlen($this->fieldValue) >= 0;
        }

        if ($this->fieldType() == 'xs:decimal') {
            return is_float($this->fieldValue);
        }

        if (in_array($this->fieldType(), ['xs:int', 'xs:long'])) {
            return is_integer($this->fieldValue);
        }

        if ($this->fieldType() == 'xs:dateTime') {
            try {
                $isItADate = Carbon::parse($this->fieldValue);
            } catch (InvalidFormatException $exception) {
                return false;
            }
            $this->fieldValue = $isItADate->toDateTimeLocalString();
            return true;
        }
        return false;
    }

    public static function allowedFieldTypes()
    {
        return self::$allowedFieldTypes;
    }
}
