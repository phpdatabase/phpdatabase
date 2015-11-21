<?php

namespace PhpDatabaseSchema\Metadata\Relational\Object;

class CollationObject
{
    private $name;
    private $characterSetName;
    private $id;
    private $isDefault;
    private $isCompiled;
    private $sortLength;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCharacterSetName()
    {
        return $this->characterSetName;
    }

    public function setCharacterSetName($characterSetName)
    {
        $this->characterSetName = $characterSetName;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIsDefault()
    {
        return $this->isDefault;
    }

    public function setIsDefault($isDefault)
    {
        $this->isDefault = $isDefault;
    }

    public function getIsCompiled()
    {
        return $this->isCompiled;
    }

    public function setIsCompiled($isCompiled)
    {
        $this->isCompiled = $isCompiled;
    }

    public function getSortLength()
    {
        return $this->sortLength;
    }

    public function setSortLength($sortLength)
    {
        $this->sortLength = $sortLength;
    }
}