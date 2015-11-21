<?php

namespace PhpDatabaseSchema\Metadata\Relational\Object;

class CharacterSetObject
{
    private $name;
    private $description;
    private $defaultCollationName;
    private $maximumLength;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDefaultCollationName()
    {
        return $this->defaultCollationName;
    }

    public function setDefaultCollationName($defaultCollationName)
    {
        $this->defaultCollationName = $defaultCollationName;
    }

    public function getMaximumLength()
    {
        return $this->maximumLength;
    }

    public function setMaximumLength($maximumLength)
    {
        $this->maximumLength = $maximumLength;
    }
}