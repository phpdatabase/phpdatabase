<?php

namespace PhpDatabaseSchema\Metadata\NoSql\Object;

use PhpDatabaseSchema\Metadata\Object\SchemaObject as BaseSchemaObject;

class SchemaObject extends BaseSchemaObject
{
    private $sizeOnDisk;
    private $empty;

    public function __construct($name, $sizeOnDisk, $empty)
    {
        parent::__construct($name);

        $this->sizeOnDisk = $sizeOnDisk;
        $this->empty = $empty;
    }

    public function getSizeOnDisk()
    {
        return $this->sizeOnDisk;
    }

    public function setSizeOnDisk($sizeOnDisk)
    {
        $this->sizeOnDisk = $sizeOnDisk;
    }

    public function getEmpty()
    {
        return $this->empty;
    }

    public function setEmpty($empty)
    {
        $this->empty = $empty;
    }
}