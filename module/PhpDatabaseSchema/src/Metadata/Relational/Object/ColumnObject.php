<?php

namespace PhpDatabaseSchema\Metadata\Relational\Object;

class ColumnObject
{
    private $name;
    private $dataType;
    private $nullable;
    private $defaultValue;
    private $numberPrecision;
    private $numberScale;
    private $characterSetName;
    private $collationName;
    private $permittedValues;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDataType()
    {
        return $this->dataType;
    }

    public function setDataType($dataType)
    {
        $this->dataType = $dataType;
    }

    public function getNullable()
    {
        return $this->nullable;
    }

    public function setNullable($nullable)
    {
        $this->nullable = $nullable;
    }

    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
    }

    public function getNumberPrecision()
    {
        return $this->numberPrecision;
    }

    public function setNumberPrecision($numberPrecision)
    {
        $this->numberPrecision = $numberPrecision;
    }

    public function getNumberScale()
    {
        return $this->numberScale;
    }

    public function setNumberScale($numberScale)
    {
        $this->numberScale = $numberScale;
    }

    public function getCharacterSetName()
    {
        return $this->characterSetName;
    }

    public function setCharacterSetName($characterSetName)
    {
        $this->characterSetName = $characterSetName;
    }

    public function getCollationName()
    {
        return $this->collationName;
    }

    public function setCollationName($collationName)
    {
        $this->collationName = $collationName;
    }

    public function getPermittedValues()
    {
        return $this->permittedValues;
    }

    public function setPermittedValues($permittedValues)
    {
        $this->permittedValues = $permittedValues;
    }
}