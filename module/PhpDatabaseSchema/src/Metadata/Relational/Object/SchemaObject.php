<?php

namespace PhpDatabaseSchema\Metadata\Relational\Object;

use PhpDatabaseSchema\Metadata\Object\SchemaObject as BaseSchemaObject;

class SchemaObject extends BaseSchemaObject
{
    private $defaultCharacterSetName;
    private $defaultCollationName;

    public function getDefaultCharacterSetName()
    {
        return $this->defaultCharacterSetName;
    }

    public function setDefaultCharacterSetName($defaultCharacterSetName)
    {
        $this->defaultCharacterSetName = $defaultCharacterSetName;
    }

    public function getDefaultCollationName()
    {
        return $this->defaultCollationName;
    }

    public function setDefaultCollationName($defaultCollationName)
    {
        $this->defaultCollationName = $defaultCollationName;
    }
}