<?php

namespace PhpDatabaseSchema\Metadata;

interface MetadataInterface
{
    public function getSchema($schemaName);

    public function getSchemas();
}
